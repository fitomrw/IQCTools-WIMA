<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\kategoriPart;
use App\Models\Supplier;
use App\Models\StandarModel;
use App\Models\StandarPerPartModel;
use PhpParser\PrettyPrinter\Standard;

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
        $standar = StandarModel::paginate(15);

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
        $editStandar = StandarModel::find($id_standar);

        return view ('edit-masterStandar', [
            "title" => "Edit Data Master Standar",
            "editStandar" => $editStandar
        ]);
    }

    public function updateStandar($id_standar, Request $request)
    {
        $validatedData = $request->validate([
            'jenis_standar' => ['required'],
            'alat' => ['required'],
            'uraian' => ['required'],
        ]);

        StandarModel::where('id_standar', $id_standar)
                    ->update($validatedData);

        return redirect('/kelola-masterStandar')->with('success', 'Data Standar Berhasil Diubah!');
    }

    public function deleteStandar($id_standar)
    {
        $delStandar = StandarModel::find($id_standar);
        $delStandar->delete();

        return redirect('/kelola-masterStandar')->with('delete', 'Data Berhasil Di Hapus!');
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
        //  dd($dataStandar);
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
            'rincian_standar' => $request->rincian_standar,
            'spesifikasi' => $request->spesifikasi,
            'point' => $request->point,
            'max' => $request->max,
            'min' => $request->min
        ]);
    
         return redirect('/kelola-masterStandarPart/edit/'.$part)->with('success', 'Data Standar Per Part Berhasil Ditambahkan!');
     }
     public function deletePengaturanStandar($id_standar_part, $part)
     {
        $part = Part::where('kode_part',$part)->first();
        $delStandarPerPart = StandarPerPartModel::where('id_standar_part', $id_standar_part);
        $delStandarPerPart->delete();

        return redirect ('/kelola-masterStandarPart/edit/'.$part->kode_part)->with('danger', 'Data Standar Per Part Berhasil Dihapus!');
        // return redirect ('/kelola-masterStandarPart/edit/'.$id_standar_part )->with('danger', 'Data Standar Per Part Berhasil Dihapus!');
     }

}
