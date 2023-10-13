<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategoriPart;
use App\Models\Laporan;
use App\Models\Part;
use App\Models\Supplier;
// use Barryvdh\DomPDF\Facade\Pdf;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::all();

        return view('kelola-LPP', [
            "title" => "Laporan Penyimpangan Part",
            "laporan" => $laporan
        ]);
    }

    public function create()
    {
        $model_kategori = kategoriPart::all();

        $part = Part::all();

        $suppliers = Supplier::all();

        return view('tambah-LPP', [
            "title" => "Buat Laporan Penyimpangan Part",
            "model_kategori" => $model_kategori,
            "part" => $part,
            "suppliers" => $suppliers
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'to' => ['required'],
            'attention' => ['required'],
            'cc' => ['required'],
            'part_name' => ['required'],
            'part_code' => ['required'],
            'model' => ['required'],            
            'quantity' => ['required'],           
            'problem_description' => ['required'],            
            'found_area' => ['required'],
            'request' => ['required']            
        ]);
        // dd($validatedData);

        Laporan::create($validatedData);
        
        return redirect('/kelola-LPP')->with('success', 'Laporan LPP Berhasil Dibuat!');
    }

    public function edit($id)
    {
        $edit_laporan = Laporan::find($id);

        $model_kategori = kategoriPart::all();

        $part = Part::all();

        return view('edit-LPP', [
            "title" => "Buat Laporan Penyimpangan Part",
            "model_kategori" => $model_kategori,
            "part" => $part,
            "edit_laporan" => $edit_laporan
        ]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'to' => ['required'],
            'attention' => ['required'],
            'cc' => ['required'],
            // 'part_name' => ['required'],
            'part_code' => ['required'],
            'model' => ['required'],            
            'quantity' => ['required'],           
            'problem_description' => ['required'],            
            // 'found_area' => ['required'],
            'request' => ['required']            
        ]);

        // dd($validatedData);

        Laporan::where('id', $id)
                ->update($validatedData);
        
        return redirect('/kelola-LPP')->with('success', 'Laporan LPP Berhasil Diubah!');
    }

    public function destroy($id)
    {
        $delete_laporan = Laporan::find($id);
        $delete_laporan->delete();

        return redirect('/kelola-LPP')->with('danger', 'Laporan LPP Berhasil Dihapus!');
    }

    public function verifIndex()
    {
        $verifLaporan = Laporan::all();

        return view('verif-LPP', [
            "title" => "Verifikasi Laporan Penyimpangan Part",
            "verifLaporan" => $verifLaporan
        ]);
    }

    public function verifShow($id)
    {
        $showVerifLaporan = Laporan::find($id);

        return view('show-verif-LPP', [
            "title" => "Laporan Penyimpangan Part",
            "showVerifLaporan" => $showVerifLaporan
        ]);
    }

    public function executeVerif($id, Request $request)
    {
        $validatedData = $request->validate([
            'status'=> ['required', 'integer']
        ]);

        // dd($validatedData);

        Laporan::where('id', $id)
                ->update($validatedData);
        
        return redirect('/kelola-LPP/verifLaporan')->with('success', 'Laporan LPP Telah Di Verifikasi!');
    }

    public function printLPP($id)
    {
        $printingLPP = Laporan::find($id);

        return view('print-LPP',[
            "printingLPP" => $printingLPP
        ]);

        // $pdf = Pdf::loadView('print-LPP', ["findLPP" =>$findLPP]);
        // return $pdf->download('LPP.pdf');

    }

}
