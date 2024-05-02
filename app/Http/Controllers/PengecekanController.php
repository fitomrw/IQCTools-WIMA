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
        // $getHasilOK = CatatanCekModel::where('final_status', 0)->get()
        // $getCheckResults = CatatanCekModel::where('id_part_supply', $id)->get();
        //     $cekDimensi = [];
        //     $cekVisual = [];
        //     $cekFunction = [];
        //     // dd($getCheckResults);
        //     foreach ($getCheckResults as $key ) {
        //         if ($key->standarPart->standar->jenis_standar == 'VISUAL') {
        //             $cekVisual[] = $key;
        //         } elseif ($key->standarPart->standar->jenis_standar == 'DIMENSI') {
        //             $cekDimensi[] = $key;
        //         } elseif ($key->standarPart->standar->jenis_standar == 'FUNCTION') {
        //             $cekFunction[] = $key;
        //         }
        //     }
        
        //     $getHasilCek = false;
        //     $countHasilCek = collect([$cekVisual, $cekDimensi, $cekFunction])->flatMap(function ($item) {
        //         return $item ;
        //     })->groupBy('urutan_sample');
            
        //     foreach ($countHasilCek as $urutanSample => $items) {
        //         $getHasilCek = $items->contains(function ($item) {
        //             return $item['status'] === 'NG';
        //         });
        //         if($getHasilCek) {
        //             $firstItem = $items->first();
        //             $modelData = CatatanCekModel::findOrFail($firstItem->id);
        //             $modelData->update(['final_status' => 1]);
        //         }else {
        //             $firstItem = $items->first();
        //             $modelData = CatatanCekModel::findOrFail($firstItem->id);
        //             $modelData->update(['final_status' => 0]);
        //         }
        //     }

        // $getHasilCek = CatatanCekModel::all()->pluck('final_status', 'id_part_supply')->toArray();  
        // $throwHasilCek = collect($getHasilCek)->groupBy('id_part_supply');
        // dd($getHasilCek);
        // dd($throwHasilCek);
        // $getHasilOK = $finalStatusShow->groupBy('id_part_supply')->map(function ($items) {
        //     return $items->where('final_status', 0)->count();
        // });
        
        // $getHasilNG = $finalStatusShow->groupBy('id_part_supply')->map(function ($items) {
        //     return $items->where('final_status', 1)->count();
        // });
        // dd($getHasilOK);
        // $getHasilCek     = $finalStatusShow->pluck('final_status')->groupBy('id_part_supply');
        // dd($getHasilCek);
        
        // $countedNG = $finalStatusShow->where('final_status', 1)->count();
        // $countedOK = $finalStatusShow->where('final_status', 0)->count();
        // $s4Levels = $data->inspection_level == 'S-IV';
        // $s3Levels = $data->inspection_level == 'S-III';
        // $s2Levels = $data->inspection_level == 'S-II';
        // $s1Levels = $data->inspection_level == 'S-I';
        // $aqlNumber1 = $data->aql_number == 1;
        // $AQLStatus = $this->calculatedAqlStatus($countedOK, $countedNG, $s4Levels, $s3Levels, $s2Levels, $s1Levels, $aqlNumber1);
        // for sending data through view
        // 's4Levels', 's3Levels', 's2Levels', 's1Levels', 'aqlNumber1'

        $finalStatusShow = CatatanCekModel::whereNotNull('final_status')->get();
        $countedNG = $finalStatusShow->where('final_status', 1)->groupBy('id_part_supply');
        $countedOK = $finalStatusShow->where('final_status', 0)->groupBy('id_part_supply');
        // dd($countedOK);
 
        return view('riwayatPengecekan', [
            "title" => "Pengecekan",
            "image" => "img/wima_logo.png"
        ], compact('data', 'countedNG', 'countedOK'));
    }

    // public function calculatedAqlStatus ($countedOK, $countedNG, $s4Levels, $s3Levels, $s2Levels, $s1Levels, $aqlNumber1)
    // {
    //     if ($countedNG >=1 && $s4Levels && $aqlNumber1){
    //         //    dd('test1');
    //         return "Reject";
    //     } elseif ($countedOK >=1 && $countedNG <= 2 && $s4Levels  && $aqlNumber1){
    //         return "Reject";
    //     } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s4Levels  && $aqlNumber1){
    //         // dd('test3');
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s4Levels && $aqlNumber1){
    //         // dd('test4');
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s4Levels && $aqlNumber1){
    //         // dd('test5');
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s4Levels && $aqlNumber1){
    //         // dd('test6');        
    //         return 8;
    //     } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s4Levels && $aqlNumber1){
    //         // dd('test7');
    //         return 13;
    //     } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s4Levels && $aqlNumber1){
    //         // dd('test8');
    //         return 13;
    //     } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s4Levels && $aqlNumber1){
    //         // dd('test9');
    //         return 20;
    //     } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s4Levels && $aqlNumber1){
    //         return 32;
    //     } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s4Levels && $aqlNumber1){
    //         return 32;
    //     } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s4Levels && $aqlNumber1){
    //         return 50;
    //     } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s4Levels && $aqlNumber1){
    //         return 80;
    //     } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s4Levels && $aqlNumber1){
    //         return 80;
    //     }elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s4Levels && $aqlNumber1){
    //         return 125;

    //     //Inspection Levels = "S-III", AQL Number = 1
    //     }elseif($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s3Levels && $aqlNumber1){
    //         return 2;
    //     } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s3Levels  && $aqlNumber1){
    //         return 2;
    //     } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s3Levels  && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s3Levels && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s3Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s3Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s3Levels && $aqlNumber1){
    //         return 8;
    //     } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s3Levels && $aqlNumber1){
    //         return 8;
    //     } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s3Levels && $aqlNumber1){
    //         return 13;
    //     } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s3Levels && $aqlNumber1){
    //         return 13;
    //     } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s3Levels && $aqlNumber1){
    //         return 20;
    //     } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s3Levels && $aqlNumber1){
    //         return 20;
    //     } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s3Levels && $aqlNumber1){
    //         return 32;
    //     } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s3Levels && $aqlNumber1){
    //         return 32;
    //     }elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s3Levels && $aqlNumber1){
    //         return 50;
        
    //     //Inspection Levels = "S-II", AQL Number = 1
    //     }elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s2Levels && $aqlNumber1){
    //     return 2;
    //     } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s2Levels  && $aqlNumber1){
    //         return 2;
    //     } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s2Levels  && $aqlNumber1){
    //         return 2;
    //     } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s2Levels && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s2Levels && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s2Levels && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s2Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s2Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s2Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s2Levels && $aqlNumber1){
    //         return 8;
    //     } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s2Levels && $aqlNumber1){
    //         return 8;
    //     } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s2Levels && $aqlNumber1){
    //         return 8;
    //     } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s2Levels && $aqlNumber1){
    //         return 13;
    //     } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s2Levels && $aqlNumber1){
    //         return 13;
    //     } elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s2Levels && $aqlNumber1){
    //         return 13;

    //     //Inspection Levels = "S-I" AQL Number = 1
    //     }elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s1Levels && $aqlNumber1){
    //         return 2;
    //     } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s1Levels  && $aqlNumber1){
    //         return 2;
    //     } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s1Levels  && $aqlNumber1){
    //         return 2;
    //     } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s1Levels && $aqlNumber1){
    //         return 2;
    //     } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s1Levels && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s1Levels && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s1Levels && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s1Levels && $aqlNumber1){
    //         return 3;
    //     } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s1Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s1Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s1Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s1Levels && $aqlNumber1){
    //         return 5;
    //     } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s1Levels && $aqlNumber1){
    //         return 8;
    //     } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s1Levels && $aqlNumber1){
    //         return 8;
    //     } elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s1Levels && $aqlNumber1){
    //         return 8;
    //     }
    // }

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
        // dd($request);
        // Validasi input jika diperlukan
        // $request->validate([
        //     'value_dimensi.*' => 'required|numeric',
        //     // Sesuaikan dengan aturan validasi Anda
        // ]);

        for ($i=0; $i < count($request->input('id_value_dimensi')); $i++) { 
            $modelData = CatatanCekModel::findOrFail($request->input('id_value_dimensi')[$i]);
            // dd($modelData);

           // Update nilai value_dimensi dalam model dengan nilai yang diterima dari formulir
            $modelData->update(['value_dimensi' =>  $request->input('value_dimensi')[$i]]);
        }

            $updateData = dataPartIncoming::where('id_part_supply', $id)->first();
            $updateData->update([
                'status_pengecekan' => $request->status_pengecekan
            ]);

            $getFinalStatus = CatatanCekModel::where('id_part_supply', $id)->get();
        // $getValueDimensi = $listCek->whereNotNull('value_dimensi')->get();
            $cekDimensi = [];
            $cekVisual = [];
            $cekFunction = [];
            
            foreach ($getFinalStatus as $key ) {
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
                return $item ;
            })->groupBy('urutan_sample');
            foreach ($setFinalStatus as $urutanSample => $items) {
                $setNGFound = $items->contains(function ($item) {
                    return $item['status'] === 'NG';
                });
                if($setNGFound) {
                    $firstItem = $items->first();
                    $modelData = CatatanCekModel::findOrFail($firstItem->id);
                    $modelData->update(['final_status' => 1]);
                }else {
                    $firstItem = $items->first();
                    $modelData = CatatanCekModel::findOrFail($firstItem->id);
                    $modelData->update(['final_status' => 0]);
                }
            }                    

        return redirect('/riwayatPengecekan');
    }

    public function detailPengecekan(Request $request, $id)
    {
        $dataPartIn = dataPartIncoming::where('id_part_supply', $id)->first();
        $tanggalSekarang = Carbon::now()->toDateString();
        $getValueDimensi = CatatanCekModel::whereNotNull('value_dimensi')->get();
        $valueDimensi = $getValueDimensi->pluck('value_dimensi', 'id')->toArray();
        
        $listCek = CatatanCekModel::where('id_part_supply', $id)->get();
        // $getValueDimensi = $listCek->whereNotNull('value_dimensi')->get();

        $cekDimensi = [];
        $cekVisual = [];
        $cekFunction = [];
        
        foreach ($listCek as $key ) {
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
        ], compact('dataPartIn','jumlahTabel', 'cekVisual', 'cekDimensi', 'cekFunction', 'tanggalSekarang', 'getValueDimensi', 'valueDimensi'));
   
    }

    public function calculateJumlahTabel($s4Levels, $s3Levels, $s2Levels, $s1Levels, $dataPartIn, $aqlNumber1)
    {
        // dd('test');
        //Inspection Levels = "S-IV", AQL Number = 1 (Default WIMA)
        if ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s4Levels && $aqlNumber1){
    //    dd('test1');
            return 2;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s4Levels  && $aqlNumber1){
            // dd('test2');
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s4Levels  && $aqlNumber1){
            // dd('test3');
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s4Levels && $aqlNumber1){
            // dd('test4');
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s4Levels && $aqlNumber1){
            // dd('test5');
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s4Levels && $aqlNumber1){
            // dd('test6');        
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s4Levels && $aqlNumber1){
            // dd('test7');
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s4Levels && $aqlNumber1){
            // dd('test8');
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s4Levels && $aqlNumber1){
            // dd('test9');
            return 20;
        } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s4Levels && $aqlNumber1){
            return 32;
        } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s4Levels && $aqlNumber1){
            return 32;
        } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s4Levels && $aqlNumber1){
            return 50;
        } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s4Levels && $aqlNumber1){
            return 80;
        } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s4Levels && $aqlNumber1){
            return 80;
        }elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s4Levels && $aqlNumber1){
            return 125;

        //Inspection Levels = "S-III", AQL Number = 1
        }elseif($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s3Levels && $aqlNumber1){
            return 2;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s3Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s3Levels  && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s3Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s3Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s3Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s3Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s3Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s3Levels && $aqlNumber1){
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s3Levels && $aqlNumber1){
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s3Levels && $aqlNumber1){
            return 20;
        } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s3Levels && $aqlNumber1){
            return 20;
        } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s3Levels && $aqlNumber1){
            return 32;
        } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s3Levels && $aqlNumber1){
            return 32;
        }elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s3Levels && $aqlNumber1){
            return 50;
        
        //Inspection Levels = "S-II", AQL Number = 1
        }elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s2Levels && $aqlNumber1){
        return 2;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s2Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s2Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s2Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s2Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s2Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s2Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s2Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s2Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s2Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s2Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s2Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s2Levels && $aqlNumber1){
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s2Levels && $aqlNumber1){
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s2Levels && $aqlNumber1){
            return 13;

        //Inspection Levels = "S-I" AQL Number = 1
        }elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s1Levels && $aqlNumber1){
            return 2;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s1Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s1Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s1Levels && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s1Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s1Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s1Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s1Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s1Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s1Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s1Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s1Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s1Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s1Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s1Levels && $aqlNumber1){
            return 8;
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
        $countedNG = $finalStatusShow->where('final_status', 1)->count();
        $countedOK = $finalStatusShow->where('final_status', 0)->count();

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

    public function verifPengecekanShow($id)
    {
        // $getValueDimensi = CatatanCekModel::whereNotNull('value_dimensi')->get();
        // $valueDimensi = $getValueDimensi->pluck('value_dimensi', 'id')->toArray();

        // $verifPengecekan = CatatanCekModel::where('id_part_supply', $id)->get();
        // $verifCekDimensi = [];
        // $verifCekVisual = [];
        // $verifCekFunction = [];

        // // dd($cekVisual);
        
        // foreach ($verifPengecekan as $key ) {
        //     // dd($key->standarPart->standar);
        //     if ($key->standarPart->standar->jenis_standar == 'VISUAL') {
        //     $verifCekVisual[] = $key;
        //     } elseif ($key->standarPart->standar->jenis_standar == 'DIMENSI') {
        //         $verifCekDimensi[] = $key;
        //     } elseif ($key->standarPart->standar->jenis_standar == 'FUNCTION') {
        //         $verifCekFunction[] = $key;
        //     }
        // } 

        // $dataPartIn = dataPartIncoming::where('id_part_supply', $id)->first();

        // $s4Levels = $dataPartIn->inspection_level == 'S-IV';
        // $s3Levels = $dataPartIn->inspection_level == 'S-III';
        // $s2Levels = $dataPartIn->inspection_level == 'S-II';
        // $s1Levels = $dataPartIn->inspection_level == 'S-I';
        // $aqlNumber1 = $dataPartIn->aql_number == 1;
        
        // $jumlahTabel = $this->showCalculateJumlahTabel($s4Levels, $s3Levels, $s2Levels, $s1Levels, $dataPartIn, $aqlNumber1);

        // return view('verifDetailPengecekan', [
        //     "title" => "Verifikasi Pengecekan",
        //     "image" => "/img/wima_logo.png",
        //     "verifPengecekan" => $verifPengecekan,
        //     "dataPartIn" => $dataPartIn,
        //     "jumlahTabel" => $jumlahTabel,
        //     "verifCekVisual" => $verifCekVisual,
        //     "verifCekDimensi" => $verifCekDimensi,
        //     "verifCekFunction" => $verifCekFunction,
        //     "valueDimensi" => $valueDimensi
        // ]);
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

        // dd($cekVisual);
        
        foreach ($verifPengecekan as $key ) {
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
            "valueDimensi" => $valueDimensi
        ]);
    }

    public function showCalculateJumlahTabel($s4Levels, $s3Levels, $s2Levels, $s1Levels, $dataPartIn, $aqlNumber1)
    {
        // dd('test');
        //Inspection Levels = "S-IV", AQL Number = 1 (Default WIMA)
        if ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s4Levels && $aqlNumber1){
    //    dd('test1');
            return 2;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s4Levels  && $aqlNumber1){
            // dd('test2');
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s4Levels  && $aqlNumber1){
            // dd('test3');
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s4Levels && $aqlNumber1){
            // dd('test4');
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s4Levels && $aqlNumber1){
            // dd('test5');
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s4Levels && $aqlNumber1){
            // dd('test6');        
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s4Levels && $aqlNumber1){
            // dd('test7');
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s4Levels && $aqlNumber1){
            // dd('test8');
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s4Levels && $aqlNumber1){
            // dd('test9');
            return 20;
        } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s4Levels && $aqlNumber1){
            return 32;
        } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s4Levels && $aqlNumber1){
            return 32;
        } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s4Levels && $aqlNumber1){
            return 50;
        } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s4Levels && $aqlNumber1){
            return 80;
        } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s4Levels && $aqlNumber1){
            return 80;
        }elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s4Levels && $aqlNumber1){
            return 125;

        //Inspection Levels = "S-III", AQL Number = 1
        }elseif($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s3Levels && $aqlNumber1){
            return 2;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s3Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s3Levels  && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s3Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s3Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s3Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s3Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s3Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s3Levels && $aqlNumber1){
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s3Levels && $aqlNumber1){
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s3Levels && $aqlNumber1){
            return 20;
        } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s3Levels && $aqlNumber1){
            return 20;
        } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s3Levels && $aqlNumber1){
            return 32;
        } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s3Levels && $aqlNumber1){
            return 32;
        }elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s3Levels && $aqlNumber1){
            return 50;
        
        //Inspection Levels = "S-II", AQL Number = 1
        }elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s2Levels && $aqlNumber1){
        return 2;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s2Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s2Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s2Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s2Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s2Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s2Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s2Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s2Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s2Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s2Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s2Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s2Levels && $aqlNumber1){
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s2Levels && $aqlNumber1){
            return 13;
        } elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s2Levels && $aqlNumber1){
            return 13;

        //Inspection Levels = "S-I" AQL Number = 1
        }elseif ($dataPartIn->jumlah_kirim >= 2 && $dataPartIn->jumlah_kirim <= 8 && $s1Levels && $aqlNumber1){
            return 2;
        } elseif ($dataPartIn->jumlah_kirim >= 9 && $dataPartIn->jumlah_kirim <= 15 && $s1Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 16 && $dataPartIn->jumlah_kirim <= 25 && $s1Levels  && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 26 && $dataPartIn->jumlah_kirim <= 50 && $s1Levels && $aqlNumber1){
            return 2;
        } elseif($dataPartIn->jumlah_kirim >= 51 && $dataPartIn->jumlah_kirim <= 90 && $s1Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 91 && $dataPartIn->jumlah_kirim <= 150 && $s1Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 151 && $dataPartIn->jumlah_kirim <= 280 && $s1Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 281 && $dataPartIn->jumlah_kirim <= 500 && $s1Levels && $aqlNumber1){
            return 3;
        } elseif($dataPartIn->jumlah_kirim >= 501 && $dataPartIn->jumlah_kirim <= 1200 && $s1Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 1201 && $dataPartIn->jumlah_kirim <= 3200 && $s1Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 3201 && $dataPartIn->jumlah_kirim <= 10000 && $s1Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 10001 && $dataPartIn->jumlah_kirim <= 35000 && $s1Levels && $aqlNumber1){
            return 5;
        } elseif($dataPartIn->jumlah_kirim >= 35001 && $dataPartIn->jumlah_kirim <= 150000 && $s1Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 150001 && $dataPartIn->jumlah_kirim <= 500000 && $s1Levels && $aqlNumber1){
            return 8;
        } elseif($dataPartIn->jumlah_kirim >= 500001 && $dataPartIn->jumlah_kirim <= INF  && $s1Levels && $aqlNumber1){
            return 8;
        }
    }

    public function storeVerifikasiPengecekan (Request $request, $id)
    {
        $updateData = dataPartIncoming::where('id_part_supply', $id)->first();
        $updateData->update([
             'status_pengecekan' => $request->status_pengecekan
         ]); 
         return redirect('/verifikasi-pengecekan/0/0/0')->with("notify", 'Data Pengecekan Telah Diverifikasi!');
    }
}
