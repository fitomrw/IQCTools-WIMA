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

        return view('riwayatPengecekan', [
            "title" => "Pengecekan",
            "image" => "img/wima_logo.png"
        ], compact('data'));
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
        // dd($request);
        // Validasi input jika diperlukan
        $request->validate([
            'value_dimensi.*' => 'required|numeric', // Sesuaikan dengan aturan validasi Anda
        ]);

        for ($i=0; $i < count($request->input('id_value_dimensi')); $i++) { 
            $modelData = CatatanCekModel::findOrFail($request->input('id_value_dimensi')[$i]);
            // dd($modelData);

           // Update nilai value_dimensi dalam model dengan nilai yang diterima dari formulir
            $modelData->update(['value_dimensi' =>  $request->input('value_dimensi')[$i]]);
        }
            $updateData = dataPartIncoming::where('id_part_supply', $id)->first();
            $updateData->update([
                'tanggal_pengecekan' => $request->tanggal_periksa,
                'status_pengecekan' => $request->status_pengecekan
            ]); 

        return redirect('/riwayatPengecekan');
    }

    public function detailPengecekan(Request $request, $id)
    {
        $dataPartIn = dataPartIncoming::where('id_part_supply', $id)->first();
        $tanggalSekarang = Carbon::now()->toDateString();
        $getValueDimensi = CatatanCekModel::whereNotNull('value_dimensi')->get();
        $valueDimensi = $getValueDimensi->pluck('value_dimensi', 'id')->toArray();
        // $getValueDimensi = CatatanCekModel::select('select value_dimensi from catatan_cek where id')->get();
        // dd($valueDimensi);

        // }
        
        // $getStatus = CatatanCekModel::();
        // $valueStatus = $getStatus->get(["id", "id_standar_part", "urutan_sample"])->toArray();
        // dd($valueStatus);
        // $valueStatus = $getStatus->pluck('id','urutan_sample','status');
        
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
    
    public function verifikasiPengecekan()
    {
        $data = dataPartIncoming::where('status_pengecekan', 1)->get();

        return view('verifikasiPengecekan', [
            "title" => "Verifikasi Pengecekan",
            "image" => "/img/wima_logo.png",
            "data" => $data
        ]);
    }

    public function verifPengecekanShow($id)
    {
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
            "verifCekFunction" => $verifCekFunction
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
         return redirect('/verifikasi-pengecekan')->with("notify", 'Data Pengecekan Telah Diverifikasi!');
    }
}


