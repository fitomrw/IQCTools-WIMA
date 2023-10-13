<?php

namespace App\Http\Controllers;

use App\Models\dataPartIncoming;
use App\Models\Part;
use App\Models\kategoriPart;
use App\Models\Supplier;
use App\Http\Requests\StoredataPartIncomingRequest;
use App\Http\Requests\UpdatedataPartIncomingRequest;

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
// php 
    public function getKodePart($kategori_id)
    {
        $kode_part = Part::where('kategori_id', $kategori_id)->get();
        return response()->json($kode_part);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori_part = kategoriPart::all();
        // $parts = Part::all();
        
        $suppliers = Supplier::all();
        // dd($parts);
        

        return view('tambahDataPartIncoming', [
            "title" => "Tambah Data Part Incoming",
            "image" => "{{ url('/img/wima_logo.png') }}",
            "kategori_part" =>  $kategori_part,
            "suppliers" => $suppliers   
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
            'jumlah_cek' => ['required'],
            'checksheet_supplier' => ['required']
        ]);
        // if ( $validatedData['checksheet_supplier'] == 'on') {
        //     $validatedData['checksheet_supplier'] = 'Ada';
        // } else{
        //     $validatedData['checksheet_supplier'] = 'Tidak Ada';
        // }
        // dd( $validatedData['checksheet_supplier']);
        dataPartIncoming::create($validatedData);

        // $request->session()->with('success', 'Data Berhasil! Ditambahkan!');

        return redirect('/dataPartIncoming');
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
            'jumlah_cek' => ['required'],
            'checksheet_supplier' => ['required']
        ]);

        
        // $findDataPartIncoming->kategori_id = $request->input('kategori_id');
        // $findDataPartIncoming->kode_part = $request->input('kode_part');
        // // $findDataPartIncoming->part->nama_part = $request->input('nama_part');
        // $findDataPartIncoming->supply_date = $request->input('supply_date');
        // $findDataPartIncoming->supplier_id = $request->input('supplier_id');
        // $findDataPartIncoming->jumlah_kirim = $request->input('jumlah_kirim');
        // $findDataPartIncoming->jumlah_cek = $request->input('jumlah_cek');
        // $findDataPartIncoming->checksheet_supplier = $request->input('checksheet_supplier');
        // // $findDataPartIncoming->save();


        dataPartIncoming::where('id_part_supply', $findDataPartIncoming->id_part_supply) 
                        ->update($validatedData);

        // $request->session()->with('success', 'Data Berhasil! Ditambahkan!');

        return redirect('/dataPartIncoming');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dataPartIncoming  $dataPartIncoming
     * @return \Illuminate\Http\Response
     */
    public function destroy(dataPartIncoming $dataPartIncoming)
    {
        dataPartIncoming::destroy($dataPartIncoming->id_part_supply);

        return redirect('/dataPartIncoming');

    }

    public function getKodePartEdit($kategori_id)
    {
        $kode_part_edit = Part::where('kategori_id', $kategori_id)->get();
        return response()->json($kode_part_edit);
    }
}
