<?php

namespace App\Http\Controllers;

use App\Models\dataPartIncoming;
use App\Models\Part;
use App\Models\kategoriPart;
use App\Models\Supplier;
use App\Http\Requests\StoredataPartIncomingRequest;
use App\Http\Requests\UpdatedataPartIncomingRequest;
use App\Models\CatatanCekModel;
use App\Models\StandarPerPartModel;
use App\Http\Controllers\PengecekanController;
use GuzzleHttp\Psr7\Request;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Carbon;

class DataPartIncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dataPartIncoming', [
            "title" => "Part Incoming",
            "image" => "/img/wima_logo.png",
            'dataPartIncomings' => dataPartIncoming::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function verifikasiPengecekan()
    {
        return view('verifikasiPengecekan', [
            "title" => "Verifikasi Pengecekan",
            "image" => "/img/wima_logo.png",
            'dataPartIncomings' => dataPartIncoming::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function verifPengecekanShow($id)
    {
        return view('verifDetailPengecekan', [
            "title" => "Verifikasi Pengecekan",
            "image" => "/img/wima_logo.png",
        ]);
    }
// php 
    public function getKodePart($kategori_id)
    {
        $kode_part = Part::where('kategori_id', $kategori_id)->get();
        return response()->json($kode_part);
    }

    // public function getSupplier($kategori_id)
    // {
    //     $supplierPart = Part::where('kategori_id', $kategori_id)->get();
    //     if($supplierPart){
    //         $supPart = $supplierPart->nama_supplier;
    //         return response()->json($supplierPart);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori_part = kategoriPart::all();
        $suppliers = Supplier::all();
        
        return view('tambahDataPartIncoming', [
            "title" => "Tambah Data Part Incoming",
            "image" => "{{ url('/img/wima_logo.png') }}",
            "kategori_part" =>  $kategori_part,
            "suppliers" => $suppliers,
            "tanggalSekarang" => $tanggalSekarang  
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoredataPartIncomingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoredataPartIncomingRequest $request)
    {
        // dd($request); 
        
        $validatedData = $request->validate([
            'kategori_id' => ['required'],
            'kode_part' => ['required'],
            'nama_part' => ['required'],
            'supplier_id' => ['required'],
            'supply_date' => ['required'],
            'jumlah_kirim' => ['required'],
            'aql_number' => ['required'],
            'inspection_level' => ['required'],
            // 'jumlah_sample' => ['required']
        ]);
        
        dataPartIncoming::create($validatedData);
        $data = dataPartIncoming::all();
        $dataTerbaru = $data->last();
        $standarPart = StandarPerPartModel::where('kode_part', $dataTerbaru->kode_part)->get();

        $s4Levels = $dataTerbaru->inspection_level == 'S-IV';
        $s3Levels = $dataTerbaru->inspection_level == 'S-III';
        $s2Levels = $dataTerbaru->inspection_level == 'S-II';
        $s1Levels = $dataTerbaru->inspection_level == 'S-I';
        $aqlNumber1 = $dataTerbaru->aql_number == 1;
        
        $cat = new PengecekanController;
        $test = $cat->calculateJumlahTabel($s4Levels, $s3Levels, $s2Levels, $s1Levels, $dataTerbaru, $aqlNumber1);

        // $dataTerbaru->update([
        //     "jumlah_sample" => $test
        // ]);

        for ($i=1; $i <= $test ; $i++) { 
            foreach ($standarPart as $key ) {
                CatatanCekModel::create([
                    'id_part_supply' => $dataTerbaru->id_part_supply,
                    'id_standar_part' => $key->id_standar_part,
                    'urutan_sample' => $i
                ]);
            }
        }

        return redirect('/dataPartIncoming')->with('notify', 'Data Part Incoming Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dataPartIncoming  $dataPartIncoming
     * @return \Illuminate\Http\Response
     */
    public function show(dataPartIncoming $dataPartIncoming)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dataPartIncoming  $dataPartIncoming
     * @return \Illuminate\Http\Response
     */
    public function edit($id_part_supply)
    {
        $kategori_part = kategoriPart::all();

        $suppliers = Supplier::all();

        $dataPartIncoming = dataPartIncoming::find($id_part_supply);
        // dd($dataPartIncoming->part->kategori_part);

        $part = Part::all();

        // @dd($dataPartIncoming);
        return view('editDataPartIncoming', [
            "title" => "Edit Data Part Incoming",
            "image" => "{{ url('img/wima_logo.png') }}",
            "kategori_part" => $kategori_part,
            "suppliers" => $suppliers,
            "dataPartIncoming" => $dataPartIncoming,
            "part" => $part
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatedataPartIncomingRequest  $request
     * @param  \App\Models\dataPartIncoming  $dataPartIncoming
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatedataPartIncomingRequest $request, dataPartIncoming $dataPartIncoming)
    {
        $findDataPartIncoming = dataPartIncoming::find($dataPartIncoming->id_part_supply);
        
        // dd($findDataPartIncoming);
        
        $validatedData = $request->validate([
            'kategori_id' => ['required'],
            'kode_part' => ['required'],
            'nama_part' => ['required'],
            'supplier_id' => ['required'],
            'supply_date' => ['required'],
            'jumlah_kirim' => ['required'],
            'aql_number' => ['required'],
            'inspection_level' => ['required']
        ]);



        dataPartIncoming::where('id_part_supply', $findDataPartIncoming->id_part_supply) 
                        ->update($validatedData);

        // $request->session()->with('success', 'Data Berhasil! Ditambahkan!');

        return redirect('/dataPartIncoming')->with('notify', 'Data Part Incoming Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dataPartIncoming  $dataPartIncoming
     * @return \Illuminate\Http\Response
     */
    // public function destroy(dataPartIncoming $dataPartIncoming)
    // {
    //     $dataPartIncoming->delete();

    //     return redirect('/dataPartIncoming');

    // }

    public function delete($id_part_supply)
    {
        $deletePartIncoming = dataPartIncoming::find($id_part_supply);
        $deletePartIncoming->delete();

        return redirect('/dataPartIncoming')->with('deleteNotify', 'Data Part Incoming Berhasil Dihapus!');

    }

    public function getKodePartEdit($kategori_id)
    {
        $kode_part_edit = Part::where('kategori_id', $kategori_id)->get();
        return response()->json($kode_part_edit);
    }
}
