<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return view('kelola-masterSupplier', [
            "title" => "Kelola Data Master Supplier",
            "suppliers" => $suppliers
        ]);
    }

    public function create()
    {
        return view('tambah-masterSupplier', [
            "title" => "Tambah Data Supplier"
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_supplier' => ['required'],
            'no_telepon' => ['required'],
            'email' => ['required'],
            'alamat' => ['required']
        ]);

        Supplier::create($validatedData);

        return redirect('/kelola-masterSupplier')->with('success', 'Data Supplier Berhasil Ditambahkan!');
    }

    public function edit($id_supplier)
    {
        $supply = Supplier::find($id_supplier);


        return view('edit-masterSupplier', [
            "title" => "Edit Data Supplier",
            "supply" => $supply
        ]);
    }

    public function update($id_supplier, Request $request)
    {
        $validatedData = $request->validate([
            'nama_supplier' => ['required'],
            'no_telepon' => ['required'],
            'email' => ['required'],
            'alamat' => ['required']
        ]);

        Supplier::where('id_supplier', $id_supplier)
                ->update($validatedData);

        return redirect('/kelola-masterSupplier')->with('success', 'Data Supplier Berhasil Diubah!');
    }

    public function destroy($id_supplier)
    {
        $suppDelete = Supplier::find($id_supplier);
        $suppDelete->delete();

        return redirect('/kelola-masterSupplier')->with('deleteNotify', 'Data Supplier Dihapus!');
    }
}
