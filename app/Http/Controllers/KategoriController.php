<?php

namespace App\Http\Controllers;

use App\Models\kategoriPart;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategories = kategoriPart::all();

        return view('kelola-masterKategori',[
            "title" => "Kelola Data Master Kategori",
            "kategories" => $kategories
        ]);
    }

    public function create()
    {
        return view('tambah-masterKategori', [
            "title" => "Tambah Data Kategori"
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => ['required']
        ]);

        kategoriPart::create($validatedData);

        return redirect('/kelola-masterKategori')->with('success', 'Data Kategori Berhasil Ditambahkan!');
    }

    public function edit($id_kategori)
    {
        $katPart = kategoriPart::find($id_kategori);

        return view('edit-masterKategori', [
            "title" => "Edit Data Kategori",
            "katPart" => $katPart
        ]);
        // $suppliers = Supplier::find($supplier);
        // dd($supplier);
    }

    public function update($id_kategori, Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => ['required']
        ]);

        kategoriPart::where('id_kategori', $id_kategori)
                    ->update($validatedData);

        return redirect('/kelola-masterKategori')->with('success', 'Data Kategori Berhasil Diubah!');
    }

    public function destroy($id_kategori)
    {
        $katDelete = kategoriPart::find($id_kategori);
        $katDelete->delete();

        return redirect('/kelola-masterKategori')->with('danger', 'Data Kategori Berhasil Dihapus!');
    }
}
