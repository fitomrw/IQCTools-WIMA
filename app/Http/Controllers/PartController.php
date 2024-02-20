<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\kategoriPart;
use App\Models\Supplier;
use App\Models\StandarModel;
use App\Models\StandarPerPartModel;


class PartController extends Controller
{
    public function index()
    {
        $part = Part::all();

        return view('kelola-masterPart', [
            "title" => "Kelola Data Master Part",
            "part" => $part
        ]);
    }

    public function create()
    {
        $kategoris = kategoriPart::all();
        $suppliers = Supplier::all();

        return view('tambah-masterPart', [
            "title" => "Tambah Data Part",
            "kategoris" => $kategoris,
            "suppliers" => $suppliers
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama_part' => 'required',
            'kode_part' => 'required',
            'supplier_id' => 'required',
            'gambar_part' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);
        $currentDateTime = now()->format('YmdHis');
        $filename = $validatedData['kode_part']. $currentDateTime . '.' . $request->file('gambar_part')->getClientOriginalExtension();

        Part::create([
            'kategori_id' => $validatedData['kategori_id'],
            'nama_part' =>  $validatedData['nama_part'],
            'kode_part' =>  $validatedData['kode_part'],
            'supplier_id' =>  $validatedData['supplier_id'],
            'gambar_part' => $filename
        ]);
        $request->file('gambar_part')->move(public_path('img/img_part'), $filename);
        return redirect('/kelola-masterPart')->with('success', 'Data Master Part Berhasil Ditambahkan!');
    }

    public function edit($kode_part)
    {
        $kategoris = kategoriPart::all();
        $suppliers = Supplier::all();
        $k_part = Part::find($kode_part);

        return view('edit-masterPart',[
            "title" => "Edit Master Part",
            "k_part" => $k_part,
            "kategoris" => $kategoris,
            "suppliers" => $suppliers
        ]);


    }

    public function update($kode_part, Request $request)
    {
        // dd($request->gambar_part);
        $validatedData = $request->validate([
            'kategori_id' => ['required'],
            'nama_part' => ['required'],
            'kode_part' => ['required'],
            'supplier_id' => ['required'],
        ]);

        Part::where('kode_part', $kode_part)
             ->update($validatedData);
        
        if ($request->gambar_part != null) {
            $validasiGambar = $request->validate([
                'gambar_part' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]);

            $currentDateTime = now()->format('YmdHis');
        $filename = $validatedData['kode_part']. $currentDateTime . '.' . $request->file('gambar_part')->getClientOriginalExtension();

        Part::where('kode_part', $kode_part)
        ->update([
            'gambar_part' => $filename
        ]);
        $request->file('gambar_part')->move(public_path('img/img_part'), $filename);
        }
        return redirect('/kelola-masterPart')->with('success', 'Data Master Part Berhasil Diubah!');
    }

    public function destroy($kode_part)
    {
        $delPart = Part::find($kode_part);
        $delPart->delete();

        return redirect('/kelola-masterPart')->with('delete', 'Data Master Part Berhasil Dihapus!');
    }


    //<<<< Master Standar >>>//
    public function indexStandar()
    {
        $standar = StandarModel::all();

        return view('kelola-masterStandar', [
            "title" => "Kelola Data Master Standar",
            "standar" => $standar
        ]);
    }

    public function createStandar()
    {
        // $part = Part::all();

        return view('tambah-masterStandar', [
            "title" => "Tambah Data Master Standar",
            // "part" => $part
        ]);
    }

    public function storeStandar(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_standar' => ['required'],
            'alat' => ['required'],
            'uraian' => ['required'],
        ]);

        StandarModel::create($validatedData);

        return redirect('/kelola-masterStandar')->with('success', 'Data Standar Berhasil Ditambahkan!');
    }

    public function editStandar ($id_standar)
    {
        $editStandar = StandarModel::all();
        return view ('edit-masterStandar', [
            "title" => "Edit Data Master Standar",
            "editStandar" => $editStandar
        ]);
    }

     //<<<< Pengaturan Standar Per Part >>>//
     public function indexPengaturanStandar()
     {
         $part = Part::all();
         $standar = StandarModel::all();
         $title =  "Kelola Data Master Pengaturan Standar";
 
         return view('kelola-masterStandarPart', compact('part','standar', 'title'));
     }

     public function getJenisStandarPart($jenis_standar)
     {
        $jenisStandar = StandarModel::where('jenis_standar', $jenis_standar)->get();
        return response()->json($jenisStandar);
     }

     public function editStandarPart($part)
     {
        $standar = StandarPerPartModel::where('kode_part',$part)->get();
         $part = Part::where('kode_part',$part)->first();
         
        //  dd($standar, $part);
         $dataStandar = StandarModel::all();
         $title =  "Kelola Data Master Pengaturan Standar";
 
         return view('edit-standar-part', compact('part','standar', 'title','dataStandar'));
     }
     public function storePengaturanStandar(Request $request,$part)
     {
        // $validatedData = $request->validate([
        //     'jenis_standar' => ['required'],
        //     'alat' => ['required'],
        //     'uraian' => ['required'],
        // ]);
        
        StandarPerPartModel::create([
            'id_standar' => $request->jenis_standar,
            'kode_part' => $part,
            'rincian_standar' => $request->rincian_standar
        ]);
    
         return redirect('/kelola-masterStandarPart/edit/'.$part)->with('success', 'Data Standar Per Part Berhasil Ditambahkan!');
     }

}
