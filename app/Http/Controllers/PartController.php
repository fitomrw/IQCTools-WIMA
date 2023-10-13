<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\kategoriPart;
use App\Models\Supplier;

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
            'kategori_id' => ['required'],
            'nama_part' => ['required'],
            'kode_part' => ['required'],
            'supplier_id' => ['required'],
        ]);

        Part::create($validatedData);

        return redirect('/kelola-masterPart')->with('success', 'Data Kategori Berhasil Ditambahkan!');
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
        $validatedData = $request->validate([
            'kategori_id' => ['required'],
            'nama_part' => ['required'],
            'kode_part' => ['required'],
            'supplier_id' => ['required'],
        ]);

        Part::where('kode_part', $kode_part)
             ->update($validatedData);

        return redirect('/kelola-masterPart')->with('success', 'Data Master Part Berhasil Diubah!');
    }

    public function destroy($kode_part)
    {
        $delPart = Part::find($kode_part);
        $delPart->delete();

        return redirect('/kelola-masterPart')->with('delete', 'Data Master Part Berhasil Dihapus!');
    }
}
