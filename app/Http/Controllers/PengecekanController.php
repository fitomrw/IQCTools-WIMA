<?php

namespace App\Http\Controllers;

use App\Models\CatatanCekModel;
use App\Models\dataPartIncoming;
use App\Models\StandarPerPartModel;
use App\Models\Pengecekan;
use App\Models\standarMIL;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\kategoriPart;
use App\Models\Part;
use stdClass;

class PengecekanController extends Controller
{
    // public function index()
    // {
    //     return view ('kelola-pengecekan',[
    //         "title" => "Pengecekan"
    //     ]);
    // }

    // public function create()
    // {
    //     return view('tambahdata-pengecekan', [
    //         "title" => "Tambah Pengecekan",
    //            "image" => "img/wima_logo.png"
    //     ]);
    // }

    public function riwayatPengecekan()
    {
        $data = dataPartIncoming::all();

        $finalStatusShow = CatatanCekModel::whereNotNull('final_status')->get();
        $countedNG = $finalStatusShow->where('final_status', 1)->groupBy('id_part_supply');
        $countedOK = $finalStatusShow->where('final_status', 0)->groupBy('id_part_supply');
        
        $getKeputusan = CatatanCekModel::whereNotNull('keputusan')->get();
        $keputusanDiterima = $getKeputusan->where('keputusan', 'Diterima')->groupBy('id_part_supply');
        // dd($keputusanDiterima);
        $keputusanDitolak = $getKeputusan->where('keputusan', 'Ditolak')->groupBy('id_part_supply');

        // dd($countedOK);

        return view('riwayatPengecekan', [
            "title" => "Pengecekan",
            "image" => "img/wima_logo.png"
        ], compact('data', 'countedNG', 'countedOK', 'keputusanDiterima', 'keputusanDitolak'));
    }


    public function cekPerPoint(Request $request)
    {
        $updateData = CatatanCekModel::where('id', $request->key2)->first();
        $updateData->update([
            'status' => $request->key1,
            'checksheet' => 'checked'
        ]);
    }

    public function submitPengecekan(Request $request, $id)
    {
        // dd($request->input('id_value_dimensi'));
        for ($i = 0; $i < count($request->input('id_value_dimensi')); $i++) {
            $modelData = CatatanCekModel::findOrFail($request->input('id_value_dimensi')[$i]);
            // dd($modelData);

            // Update nilai value_dimensi dalam model dengan nilai yang diterima dari formulir
            $modelData->update(['value_dimensi' =>  $request->input('value_dimensi')[$i]]);
        }

        $updateData = dataPartIncoming::where('id_part_supply', $id)->first();
        $updateData->update([
            'status_pengecekan' => $request->status_pengecekan
        ]);

        //Untuk Notifikasi Keputusan
        $s4Levels = $updateData->inspection_level == 'S-IV';
        $s3Levels = $updateData->inspection_level == 'S-III';
        $s2Levels = $updateData->inspection_level == 'S-II';
        $s1Levels = $updateData->inspection_level == 'S-I';
        $aqlNumber1 = $updateData->aql_number == 1;
        
        $getFinalStatus = CatatanCekModel::where('id_part_supply', $id)->get();
        // $getValueDimensi = $listCek->whereNotNull('value_dimensi')->get();
        $cekDimensi = [];
        $cekVisual = [];
        $cekFunction = [];
        
        foreach ($getFinalStatus as $key) {
            // dd($key->standarPart->standar);
            if ($key->standarPart->standar->jenis_standar == 'VISUAL') {
                $cekVisual[] = $key;
            } elseif ($key->standarPart->standar->jenis_standar == 'DIMENSI') {
                $cekDimensi[] = $key;
            } elseif ($key->standarPart->standar->jenis_standar == 'FUNCTION') {
                $cekFunction[] = $key;
            }
        }
        
        $setNGFound = false;
        $setFinalStatus = collect([$cekVisual, $cekDimensi, $cekFunction])->flatMap(function ($item) {
            return $item;
        })->groupBy('urutan_sample');
        // dd($setFinalStatus);
        foreach ($setFinalStatus as $urutanSample => $items) {
            $setNGFound = $items->contains(function ($item) {
                return $item['status'] === 'NG';
            });
            if ($setNGFound) {
                $firstItem = $items->first();
                $modelData = CatatanCekModel::findOrFail($firstItem->id);
                $modelData->update(['final_status' => 1]);
            } else {
                $firstItem = $items->first();
                $modelData = CatatanCekModel::findOrFail($firstItem->id);
                $modelData->update(['final_status' => 0]);
            }
        }
        $pengecekanDecision = $this->calculateJumlahNG($s4Levels, $s3Levels, $s2Levels, $s1Levels, $aqlNumber1, $updateData, $setFinalStatus);
        
        $storeTanggalCek = CatatanCekModel::where('id_part_supply', $id)->first();
        $storeTanggalCek->update([
            'tanggal_cek' => $request->tanggal_cek,
            'keputusan' => $pengecekanDecision
        ]);
       
        $jumlahNG = $setFinalStatus->flatMap(function ($items) {
            return $items;
        })->filter(function ($item) {
            return $item->final_status == 1;
        })->count();

        

        return redirect('/riwayatPengecekan');
    }

    public function calculateJumlahNG($s4Levels, $s3Levels, $s2Levels, $s1Levels, $aqlNumber1, $updateData, $setFinalStatus)
    {
        $jumlahFinalStatusSatu = $setFinalStatus->flatMap(function ($items) {
            return $items;
        })->filter(function ($item) {
            return $item->final_status == 1;
        })->count();

        // dd($jumlahFinalStatusSatu);
        // dd('test');
        //Inspection Levels = "S-IV", AQL Number = 1 (Default WIMA)
        if ($updateData->jumlah_kirim >= 1 && $updateData->jumlah_kirim <= 8 && $s4Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } elseif ($jumlahFinalStatusSatu <= 1) {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 9 && $updateData->jumlah_kirim <= 15 && $s4Levels  && $aqlNumber1) {
            // dd('test2');
            if ($updateData->jumlah_kirim >= 13 && $updateData->jumlah_kirim <= 15) {
                if ($jumlahFinalStatusSatu >= 1) {
                    return "Ditolak";
                } else {
                    return "Diterima";
                }
            }
        } elseif ($updateData->jumlah_kirim >= 16 && $updateData->jumlah_kirim <= 25 && $s4Levels  && $aqlNumber1) {
            // dd('test3');
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 26 && $updateData->jumlah_kirim <= 50 && $s4Levels && $aqlNumber1) {
            // dd('test4');
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 51 && $updateData->jumlah_kirim <= 90 && $s4Levels && $aqlNumber1) {
            // dd('test5');
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            }  else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 91 && $updateData->jumlah_kirim <= 150 && $s4Levels && $aqlNumber1) {
            // dd('test6');        
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 151 && $updateData->jumlah_kirim <= 280 && $s4Levels && $aqlNumber1) {
            // dd('test7');
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 281 && $updateData->jumlah_kirim <= 500 && $s4Levels && $aqlNumber1) {
            // dd('test8');
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 501 && $updateData->jumlah_kirim <= 1200 && $s4Levels && $aqlNumber1) {
            // dd('test9');
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 1201 && $updateData->jumlah_kirim <= 3200 && $s4Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 2) {
                return "Ditolak";
            } 
        } elseif ($updateData->jumlah_kirim >= 3201 && $updateData->jumlah_kirim <= 10000 && $s4Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 2) {
                return "Ditolak";
            }
        } elseif ($updateData->jumlah_kirim >= 10001 && $updateData->jumlah_kirim <= 35000 && $s4Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu > 1) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 2) {
                return "Ditolak";
            }
        } elseif ($updateData->jumlah_kirim >= 35001 && $updateData->jumlah_kirim <= 150000 && $s4Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 2) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 3) {
                return "Ditolak";
            }
        } elseif ($updateData->jumlah_kirim >= 150001 && $updateData->jumlah_kirim <= 500000 && $s4Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 2) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 3) {
                return "Ditolak";
            }
        } elseif ($updateData->jumlah_kirim >= 500001 && $updateData->jumlah_kirim <= INF  && $s4Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 3) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 4) {
                return "Ditolak";
            }

            //Inspection Levels = "S-III", AQL Number = 1
        } elseif ($updateData->jumlah_kirim >= 1 && $updateData->jumlah_kirim <= 8 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 9 && $updateData->jumlah_kirim <= 15 && $s3Levels  && $aqlNumber1) {
            if ($updateData->jumlah_kirim >= 13 && $updateData->jumlah_kirim <= 15) {
                if ($jumlahFinalStatusSatu >= 1) {
                    return "Ditolak";
                } else {
                    return "Diterima";
                }
            } 
        } elseif ($updateData->jumlah_kirim >= 16 && $updateData->jumlah_kirim <= 25 && $s3Levels  && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 26 && $updateData->jumlah_kirim <= 50 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 51 && $updateData->jumlah_kirim <= 90 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 91 && $updateData->jumlah_kirim <= 150 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 151 && $updateData->jumlah_kirim <= 280 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 281 && $updateData->jumlah_kirim <= 500 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 501 && $updateData->jumlah_kirim <= 1200 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 1201 && $updateData->jumlah_kirim <= 3200 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 3201 && $updateData->jumlah_kirim <= 10000 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 10001 && $updateData->jumlah_kirim <= 35000 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 35001 && $updateData->jumlah_kirim <= 150000 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 2) {
                return "Ditolak";
            }
        } elseif ($updateData->jumlah_kirim >= 150001 && $updateData->jumlah_kirim <= 500000 && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 2) {
                return "Ditolak";
            }
        } elseif ($updateData->jumlah_kirim >= 500001 && $updateData->jumlah_kirim <= INF  && $s3Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Diterima";
            } elseif ($jumlahFinalStatusSatu >= 2) {
                return "Ditolak";
            }

            //Inspection Levels = "S-II", AQL Number = 1
        } elseif ($updateData->jumlah_kirim >= 1 && $updateData->jumlah_kirim <= 8 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 9 && $updateData->jumlah_kirim <= 15 && $s2Levels  && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 16 && $updateData->jumlah_kirim <= 25 && $s2Levels  && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 26 && $updateData->jumlah_kirim <= 50 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 51 && $updateData->jumlah_kirim <= 90 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 91 && $updateData->jumlah_kirim <= 150 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 151 && $updateData->jumlah_kirim <= 280 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 281 && $updateData->jumlah_kirim <= 500 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 501 && $updateData->jumlah_kirim <= 1200 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 1201 && $updateData->jumlah_kirim <= 3200 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 3201 && $updateData->jumlah_kirim <= 10000 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 10001 && $updateData->jumlah_kirim <= 35000 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 35001 && $updateData->jumlah_kirim <= 150000 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 150001 && $updateData->jumlah_kirim <= 500000 && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 500001 && $updateData->jumlah_kirim <= INF  && $s2Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }

            //Inspection Levels = "S-I" AQL Number = 1
        } elseif ($updateData->jumlah_kirim >= 1 && $updateData->jumlah_kirim <= 8 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 9 && $updateData->jumlah_kirim <= 15 && $s1Levels  && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 16 && $updateData->jumlah_kirim <= 25 && $s1Levels  && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 26 && $updateData->jumlah_kirim <= 50 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 51 && $updateData->jumlah_kirim <= 90 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 91 && $updateData->jumlah_kirim <= 150 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 151 && $updateData->jumlah_kirim <= 280 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 281 && $updateData->jumlah_kirim <= 500 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 501 && $updateData->jumlah_kirim <= 1200 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 1201 && $updateData->jumlah_kirim <= 3200 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 3201 && $updateData->jumlah_kirim <= 10000 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 10001 && $updateData->jumlah_kirim <= 35000 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 35001 && $updateData->jumlah_kirim <= 150000 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 150001 && $updateData->jumlah_kirim <= 500000 && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        } elseif ($updateData->jumlah_kirim >= 500001 && $updateData->jumlah_kirim <= INF  && $s1Levels && $aqlNumber1) {
            if ($jumlahFinalStatusSatu >= 1) {
                return "Ditolak";
            } else {
                return "Diterima";
            }
        }
    }

    public function detailPengecekan(Request $request, $id)
    {
        $dataPartIn = dataPartIncoming::where('id_part_supply', $id)->first();
        $tanggalSekarang = Carbon::now()->toDateString();
        $getValueDimensi = CatatanCekModel::whereNotNull('value_dimensi')->get();
        $valueDimensi = $getValueDimensi->pluck('value_dimensi', 'id')->toArray();
        $tanggalCek = CatatanCekModel::where('id_part_supply', $id)->first();

        $listCek = CatatanCekModel::where('id_part_supply', $id)->get();
        // $getValueDimensi = $listCek->whereNotNull('value_dimensi')->get();

        $cekDimensi = [];
        $cekVisual = [];
        $cekFunction = [];

        foreach ($listCek as $key) {
            // dd($key->standarPart->standar);
            if ($key->standarPart->standar->jenis_standar == 'VISUAL') {
                $cekVisual[] = $key;
            } elseif ($key->standarPart->standar->jenis_standar == 'DIMENSI') {
                $cekDimensi[] = $key;
            } elseif ($key->standarPart->standar->jenis_standar == 'FUNCTION') {
                $cekFunction[] = $key;
            }
        }

        $s4Levels = $dataPartIn->inspection_level == 'S-IV';
        $s3Levels = $dataPartIn->inspection_level == 'S-III';
        $s2Levels = $dataPartIn->inspection_level == 'S-II';
        $s1Levels = $dataPartIn->inspection_level == 'S-I';
        $aqlNumber1 = $dataPartIn->aql_number == 1;

        $jumlahTabel = $this->calculateJumlahTabel($s4Levels, $s3Levels, $s2Levels, $s1Levels, $dataPartIn, $aqlNumber1);
        // dd($jumlahTabel);
        return view('detailPengecekan', [
            "title" => "Detail Pengecekan",
            "image" => "img/wima_logo.png"
        ], compact('dataPartIn', 'jumlahTabel', 'cekVisual', 'cekDimensi', 'cekFunction', 'tanggalSekarang', 'getValueDimensi', 'valueDimensi', 'tanggalCek'));
    }

    public function calculateJumlahTabel($s4Levels, $s3Levels, $s2Levels, $s1Levels, $dataPartIn, $aqlNumber1)
    {
        // dd('test');
        //Inspection Levels = "S-IV", AQL Number = 1 (Default WIMA)
        if ($dataPartIn->jumlah_kirim >= 1 && $dataPartIn->jumlah_kirim <= 8 && $s4Levels && $aqlNumber1) {
            //    dd('test1');
            return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s4Levels  && $aqlNumber1) {
            // dd('test2');
            if ($dataPartIn->jumlah_kirim >= 13 && $dataPartIn->jumlah_kirim <= 15) {
                return 13;
            } return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s4Levels  && $aqlNumber1) {
            // dd('test3');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s4Levels && $aqlNumber1) {
            // dd('test4');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s4Levels && $aqlNumber1) {
            // dd('test5');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s4Levels && $aqlNumber1) {
            // dd('test6');        
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s4Levels && $aqlNumber1) {
            // dd('test7');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s4Levels && $aqlNumber1) {
            // dd('test8');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s4Levels && $aqlNumber1) {
            // dd('test9');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s4Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s4Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s4Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s4Levels && $aqlNumber1) {
            return 80;
        } elseif ($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s4Levels && $aqlNumber1) {
            return 80;
        } elseif ($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s4Levels && $aqlNumber1) {
            return 125;

            //Inspection Levels = "S-III", AQL Number = 1
        } elseif ($dataPartIn->jumlah_kirim >= 1 && $dataPartIn->jumlah_kirim <= 8 && $s3Levels && $aqlNumber1) {
            return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s3Levels  && $aqlNumber1) {
            if ($dataPartIn->jumlah_kirim >= 13 && $dataPartIn->jumlah_kirim <= 15) {
                return 13;
            } return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s3Levels  && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s3Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s3Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s3Levels && $aqlNumber1) {
            return 50;

            //Inspection Levels = "S-II", AQL Number = 1
        } elseif ($dataPartIn->jumlah_kirim >= 1 && $dataPartIn->jumlah_kirim <= 8 && $s2Levels && $aqlNumber1) {
            return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s2Levels  && $aqlNumber1) {
            if ($dataPartIn->jumlah_kirim >= 13 && $dataPartIn->jumlah_kirim <= 15) {
                return 13;
            } return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s2Levels  && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s2Levels && $aqlNumber1) {
            return 13;

            //Inspection Levels = "S-I" AQL Number = 1
        } elseif ($dataPartIn->jumlah_kirim >= 1 && $dataPartIn->jumlah_kirim <= 8 && $s1Levels && $aqlNumber1) {
            return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s1Levels  && $aqlNumber1) {
            if ($dataPartIn->jumlah_kirim >= 13 && $dataPartIn->jumlah_kirim <= 15) {
                return 13;
            } return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s1Levels  && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s1Levels && $aqlNumber1) {
            return 13;
        }
    }

    public function indexMIL()
    {
        $standarMIL = standarMIL::orderBy('created_at', 'desc')->get();

        return view('kelola-standarMIL', [
            "title" => "Kelola Data Standar MIL STD 105 E",
            "standarMIL" => $standarMIL
        ]);
    }

    public function createMIL()
    {
        return view('tambah-standarMIL', [
            "title" => "Tambah Data Standar MIL STD 105 E"
        ]);
    }

    public function storeMIL(Request $request)
    {
        $validatedData = $request->validate([
            'min_sample' => ['required'],
            'max_sample' => ['required'],
            'size_code' => ['required'],
            'sample_size' => ['required']
        ]);

        standarMIL::create($validatedData);

        return redirect('/kelola-standarMIL')->with('success', 'Standar MIL STD 105 E Berhasil Dibuat!');
    }

    public function editMIL($id)
    {
        $edit_standarMIL = standarMIL::find($id);

        return view('edit-standarMIL', [
            "title" => "Edit Data Standar MIL STD 105 E",
            "edit_standarMIL" => $edit_standarMIL
        ]);
    }

    public function updateMIL($id, Request $request)
    {
        $validatedData = $request->validate([
            'min_sample' => ['required'],
            'max_sample' => ['required'],
            'size_code' => ['required'],
            'sample_size' => ['required']
        ]);

        standarMIL::where('id', $id)
            ->update($validatedData);

        return redirect('/kelola-standarMIL')->with('success', 'Standar MIL STD 105 E Berhasil Di Update!');
    }

    public function deleteMIL($id)
    {
        $deleteMIL = standarMIL::find($id);
        $deleteMIL->delete();

        return redirect('/kelola-standarMIL')->with('danger', 'Standar MIL STD 105 E Berhasil Di Hapus');
    }

    public function pengecekanShow($id)
    {
    }

    public function verifikasiPengecekan($supplier, $kategori, $bulan)
    {
        $data = dataPartIncoming::where('status_pengecekan', 1)->get();
        $finalStatusShow = CatatanCekModel::whereNotNull('final_status')->get();
        $countedNG = $finalStatusShow->where('final_status', 1)->groupBy('id_part_supply');
        $countedOK = $finalStatusShow->where('final_status', 0)->groupBy('id_part_supply');

        $laporan = null;
        $getSupplier = Supplier::all();
        $getKategori = kategoriPart::all();
        // dd($supplier);
        if ($bulan == 0) {
            $bulanForView =  Carbon::now()->month;
        } else {
            $bulanForView =  $bulan;
        }

        return view('grafik', [
            "title" => "Grafik Pengecekan Part",
            "image" => "/img/wima_logo.png",
            "laporan" => $laporan,
            "getSupplier" => $getSupplier,
            "getKategori" => $getKategori,
            "supplier" => $supplier,
            "kategori" => $kategori,
            "bulan" => $bulan,
            "bulanForView" => $bulanForView,
            "data" => $data,
            "countedNG" => $countedNG,
            "countedOK" => $countedOK
        ]);
    }




    public function filterGrafik(Request $request)
    {
        // dd($request->supplierFilter, $request->kategoriFilter, $request->bulanFilter);
        $supplier = $request->supplierFilter;
        $kategori =  $request->kategoriFilter;
        $bulan = $request->bulanFilter;

        if ($supplier == null) {
            $supplier = 0;
        }

        if ($kategori == null) {
            $kategori = 0;
        }

        if ($bulan == null) {
            $bulan = 0;
        }
        return redirect()->route('grafikVerif', compact('supplier', 'kategori', 'bulan'));
    }

    public function pengecekanIndex()
    {
        $data = dataPartIncoming::where('status_pengecekan', 1)->get();
        $finalStatusShow = CatatanCekModel::whereNotNull('final_status')->get();
        $countedNG = $finalStatusShow->where('final_status', 1)->count();
        $countedOK = $finalStatusShow->where('final_status', 0)->count();

        return view('verifikasiPengecekan', [
            "title" => "Verifikasi Pengecekan",
            "image" => "/img/wima_logo.png",
            "data" => $data,
            "countedNG" => $countedNG,
            "countedOK" => $countedOK
        ]);
    }

    public function verifikasiShow($id)
    {
        // dd('test');
        $getValueDimensi = CatatanCekModel::whereNotNull('value_dimensi')->get();
        $valueDimensi = $getValueDimensi->pluck('value_dimensi', 'id')->toArray();

        $verifPengecekan = CatatanCekModel::where('id_part_supply', $id)->get();
        $verifCekDimensi = [];
        $verifCekVisual = [];
        $verifCekFunction = [];

        $getTanggalCek = CatatanCekModel::where('id_part_supply', $id)->first();

        foreach ($verifPengecekan as $key) {
            // dd($key->standarPart->standar);
            if ($key->standarPart->standar->jenis_standar == 'VISUAL') {
                $verifCekVisual[] = $key;
            } elseif ($key->standarPart->standar->jenis_standar == 'DIMENSI') {
                $verifCekDimensi[] = $key;
            } elseif ($key->standarPart->standar->jenis_standar == 'FUNCTION') {
                $verifCekFunction[] = $key;
            }
        }

        $dataPartIn = dataPartIncoming::where('id_part_supply', $id)->first();

        $s4Levels = $dataPartIn->inspection_level == 'S-IV';
        $s3Levels = $dataPartIn->inspection_level == 'S-III';
        $s2Levels = $dataPartIn->inspection_level == 'S-II';
        $s1Levels = $dataPartIn->inspection_level == 'S-I';
        $aqlNumber1 = $dataPartIn->aql_number == 1;

        $jumlahTabel = $this->showCalculateJumlahTabel($s4Levels, $s3Levels, $s2Levels, $s1Levels, $dataPartIn, $aqlNumber1);

        return view('verifDetailPengecekan', [
            "title" => "Verifikasi Pengecekan",
            "image" => "/img/wima_logo.png",
            "verifPengecekan" => $verifPengecekan,
            "dataPartIn" => $dataPartIn,
            "jumlahTabel" => $jumlahTabel,
            "verifCekVisual" => $verifCekVisual,
            "verifCekDimensi" => $verifCekDimensi,
            "verifCekFunction" => $verifCekFunction,
            "valueDimensi" => $valueDimensi,
            "getTanggalCek" => $getTanggalCek
        ]);
    }

    public function showCalculateJumlahTabel($s4Levels, $s3Levels, $s2Levels, $s1Levels, $dataPartIn, $aqlNumber1)
    {
        // dd('test');
        //Inspection Levels = "S-IV", AQL Number = 1 (Default WIMA)
        if ($dataPartIn->jumlah_kirim >= 1 && $dataPartIn->jumlah_kirim <= 8 && $s4Levels && $aqlNumber1) {
            //    dd('test1');
            return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s4Levels  && $aqlNumber1) {
            // dd('test2');
            if ($dataPartIn->jumlah_kirim >= 13 && $dataPartIn->jumlah_kirim <= 15) {
                return 13;
            } return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s4Levels  && $aqlNumber1) {
            // dd('test3');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s4Levels && $aqlNumber1) {
            // dd('test4');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s4Levels && $aqlNumber1) {
            // dd('test5');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s4Levels && $aqlNumber1) {
            // dd('test6');        
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s4Levels && $aqlNumber1) {
            // dd('test7');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s4Levels && $aqlNumber1) {
            // dd('test8');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s4Levels && $aqlNumber1) {
            // dd('test9');
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s4Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s4Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s4Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s4Levels && $aqlNumber1) {
            return 80;
        } elseif ($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s4Levels && $aqlNumber1) {
            return 80;
        } elseif ($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s4Levels && $aqlNumber1) {
            return 125;

            //Inspection Levels = "S-III", AQL Number = 1
        } elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s3Levels && $aqlNumber1) {
            return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s3Levels  && $aqlNumber1) {
            if ($dataPartIn->jumlah_kirim >= 13 && $dataPartIn->jumlah_kirim <= 15) {
                return 13;
            } return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s3Levels  && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s3Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s3Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s3Levels && $aqlNumber1) {
            return 50;
        } elseif ($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s3Levels && $aqlNumber1) {
            return 50;

            //Inspection Levels = "S-II", AQL Number = 1
        } elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s2Levels && $aqlNumber1) {
            return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s2Levels  && $aqlNumber1) {
            if ($dataPartIn->jumlah_kirim >= 13 && $dataPartIn->jumlah_kirim <= 15) {
                return 13;
            } return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s2Levels  && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s2Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s2Levels && $aqlNumber1) {
            return 13;

            //Inspection Levels = "S-I" AQL Number = 1
        } elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s1Levels && $aqlNumber1) {
            return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s1Levels  && $aqlNumber1) {
            if ($dataPartIn->jumlah_kirim >= 13 && $dataPartIn->jumlah_kirim <= 15) {
                return 13;
            } return $dataPartIn->jumlah_kirim;
        } elseif ($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s1Levels  && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s1Levels && $aqlNumber1) {
            return 13;
        } elseif ($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s1Levels && $aqlNumber1) {
            return 13;
        }
    }

    public function storeVerifikasiPengecekan(Request $request, $id)
    {
        $updateData = dataPartIncoming::where('id_part_supply', $id)->first();
        $updateData->update([
            'status_pengecekan' => $request->status_pengecekan
        ]);
        return redirect('/verifikasi-pengecekan/0/0/0')->with("notify", 'Data Pengecekan Telah Di Verifikasi!');
    }

    public function anjenk()
    {
        return "SAAAAAATTTT BISAAA DONG JEEENGGG";
    }



    // public function simpanData(Request $request, $id)
    // {
    //     for ($i=0; $i < count($request->input('id_value_dimensi')); $i++) { 
    //         $modelData = CatatanCekModel::findOrFail($request->input('id_value_dimensi')[$i]);
    //         dd($modelData);

    //         // Update nilai value_dimensi dalam model dengan nilai yang diterima dari formulir
    //         $modelData->update(['value_dimensi' =>  $request->input('value_dimensi')[$i]]);
    //     }

    //         $updateData = dataPartIncoming::where('id_part_supply', $id)->first();
    //         $updateData->update([
    //             'status_pengecekan' => $request->status_pengecekan
    //         ]);

    //         $getFinalStatus = CatatanCekModel::where('id_part_supply', $id)->get();
    //     // $getValueDimensi = $listCek->whereNotNull('value_dimensi')->get();
    //         $cekDimensi = [];
    //         $cekVisual = [];
    //         $cekFunction = [];

    //         foreach ($getFinalStatus as $key ) {
    //             // dd($key->standarPart->standar);
    //             if ($key->standarPart->standar->jenis_standar == 'VISUAL') {
    //                 $cekVisual[] = $key;
    //             } elseif ($key->standarPart->standar->jenis_standar == 'DIMENSI') {
    //                 $cekDimensi[] = $key;
    //             } elseif ($key->standarPart->standar->jenis_standar == 'FUNCTION') {
    //                 $cekFunction[] = $key;
    //             }
    //         }

    //         $setNGFound = false;
    //         $setFinalStatus = collect([$cekVisual, $cekDimensi, $cekFunction])->flatMap(function ($item) {
    //             return $item ;
    //         })->groupBy('urutan_sample');
    //         foreach ($setFinalStatus as $urutanSample => $items) {
    //             $setNGFound = $items->contains(function ($item) {
    //                 return $item['status'] === 'NG';
    //             });
    //             if($setNGFound) {
    //                 $firstItem = $items->first();
    //                 $modelData = CatatanCekModel::findOrFail($firstItem->id);
    //                 $modelData->update(['final_status' => 1]);
    //             }else {
    //                 $firstItem = $items->first();
    //                 $modelData = CatatanCekModel::findOrFail($firstItem->id);
    //                 $modelData->update(['final_status' => 0]);
    //             }
    //         }                    

    //     return redirect()->back();
    // }
}
