<?php

namespace App\Http\Controllers;

use App\Models\CatatanCekModel;
use Illuminate\Http\Request;
use App\Models\kategoriPart;
use App\Models\Laporan;
use App\Models\Part;
use App\Models\Supplier;
use App\Models\dataPartIncoming;
use App\Models\User;
// use Carbon\Carbon;
// use Barryvdh\DomPDF\Facade\Pdf;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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

        $getIssueDate = Carbon::now()->toDateString();

        return view('tambah-LPP', [
            "title" => "Buat Laporan Penyimpangan Part",
            "model_kategori" => $model_kategori,
            "part" => $part,
            "suppliers" => $suppliers,
            "getIssueDate" => $getIssueDate
        ]);
    }

    public function getPartInfo($model)
    {
        $partInfo = Part::where('kategori_id', $model)->get();
        // dd($partInfo);
        return response()->json($partInfo);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'to' => 'required',
            'attention' => 'required',
            'cc' => 'required',
            'part_name' => 'required',
            'part_code' => 'required',
            'model' => 'required',
            'quantity' => 'required',
            'problem_description' => 'required',
            'found_area' => 'required',
            'found_date' => 'required',
            'issue_date' => 'required',
            'request' => 'required',
            'pic_person' => 'required',
            'gambar_lpp' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        // dd($validatedData);
        $currentDateTime = now()->format('YmdHis');
        $filename = $currentDateTime . '.' . $request->file('gambar_lpp')->getClientOriginalExtension();
        // dd($validatedData['to'], $filename);
        Laporan::create([
            'supplier_id' => $validatedData['to'],
            'attention' => $validatedData['attention'],
            'cc' => $validatedData['cc'],
            'part_name' => $validatedData['part_name'],
            'part_code' => $validatedData['part_code'],
            'model' => $validatedData['model'],
            'quantity' => $validatedData['quantity'],
            'problem_description' => $validatedData['problem_description'],
            'found_area' => $validatedData['found_area'],
            'found_date' => $validatedData['found_date'],
            'issue_date' => $validatedData['issue_date'],
            'request' => $validatedData['request'],
            'pic_person' => $validatedData['pic_person'],
            'gambar_lpp' => $filename,
        ]);

        $request->file('gambar_lpp')->move(public_path('img/img_lpp'), $filename);
        return redirect('/kelola-LPP')->with('success', 'Laporan LPP Berhasil Dibuat!');
    }

    public function show($id)
    {
        $showLaporan = Laporan::find($id);

        return view('show-LPP', [
            "title" => "Laporan Penyimpangan Part",
            "showLaporan" => $showLaporan
        ]);
    }

    public function edit($id)
    {
        $edit_laporan = Laporan::find($id);

        $model_kategori = kategoriPart::all();

        $part = Part::all();

        $suppliers = Supplier::all();

        return view('edit-LPP', [
            "title" => "Edit Laporan Penyimpangan Part",
            "model_kategori" => $model_kategori,
            "part" => $part,
            "edit_laporan" => $edit_laporan,
            "suppliers" => $suppliers
        ]);
    }

    public function getPartInfoEdit($model)
    {
        $partInfoEdit = Part::where('kategori_id', $model)->get();
        // dd($partInfo);
        return response()->json($partInfoEdit);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'to' => 'required',
            'attention' => 'required',
            'cc' => 'required',
            // 'part_name' => 'required',
            'part_code' => 'required',
            'model' => 'required',
            'quantity' => 'required',
            'problem_description' => 'required',
            'found_area' => 'required',
            'found_date' => 'required',
            'issue_date' => 'required',
            'request' => 'required',
            'pic_person' => 'required',
            'gambar_lpp' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->file('gambar_lpp') == null) {
            Laporan::where('id', $id)
                ->update([
                    'supplier_id' => $validatedData['to'],
                    'attention' => $validatedData['attention'],
                    'cc' => $validatedData['cc'],
                    // 'part_name' => $validatedData['part_name'],
                    'part_code' => $validatedData['part_code'],
                    'model' => $validatedData['model'],
                    'quantity' => $validatedData['quantity'],
                    'problem_description' => $validatedData['problem_description'],
                    'found_area' => $validatedData['found_area'],
                    'found_date' => $validatedData['found_date'],
                    'issue_date' => $validatedData['issue_date'],
                    'request' => $validatedData['request'],
                    'pic_person' => $validatedData['pic_person'],
                    // 'gambar_lpp' => $filename,
                ]);
        } else {
            $currentDateTime = now()->format('YmdHis');
            $filename = $currentDateTime . '.' . $request->file('gambar_lpp')->getClientOriginalExtension();

            Laporan::where('id', $id)
                ->update([
                    'supplier_id' => $validatedData['to'],
                    'attention' => $validatedData['attention'],
                    'cc' => $validatedData['cc'],
                    // 'part_name' => $validatedData['part_name'],
                    'part_code' => $validatedData['part_code'],
                    'model' => $validatedData['model'],
                    'quantity' => $validatedData['quantity'],
                    'problem_description' => $validatedData['problem_description'],
                    'found_area' => $validatedData['found_area'],
                    'found_date' => $validatedData['found_date'],
                    'issue_date' => $validatedData['issue_date'],
                    'request' => $validatedData['request'],
                    'pic_person' => $validatedData['pic_person'],
                    'gambar_lpp' => $filename,
                ]);

            $request->file('gambar_lpp')->move(public_path('img/img_lpp'), $filename);
        }


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
        $getSupplier = Supplier::all();
        $getKategori = kategoriPart::all();

        return view('verif-LPP', [
            "title" => "Verifikasi Laporan Penyimpangan Part",
            "verifLaporan" => $verifLaporan,
            "getSupplier" => $getSupplier,
            "getKategori" => $getKategori
        ]);
    }

    public function getDataLPP(Request $request)
    {
        $supplierFilter = $request->input('supplierFilter');
        $kategoriFilter = $request->input('kategoriFilter');

        $getDataLPP = Laporan::query();

        if ($supplierFilter) {
            $getDataLPP->where('to', $supplierFilter)->groupBy($supplierFilter);
        }
        if ($kategoriFilter) {
            $getDataLPP->where('model', $kategoriFilter)->groupBy($kategoriFilter);
        }

        $filteredChart = $getDataLPP->get();

        $data = $getDataLPP->select('part_code', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('part_code')
            ->get();

        // // Mengambil data relasi 'part'
        // $data->load('part');

        // // Mengonversi data ke dalam bentuk array untuk response JSON
        // $data = $data->toArray();

        // Mengumpulkan data yang akan dikirimkan sebagai respons
        $chartInfo = [
            'data' => $data,
            'filteredChart' => $filteredChart
        ];
        dd($chartInfo);

        return response()->json($chartInfo);
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
            'status' => ['required', 'integer']
        ]);

        // dd($validatedData);

        Laporan::where('id', $id)
            ->update($validatedData);

        return redirect('/kelola-LPP/verifLaporan')->with('success', 'Laporan LPP Telah Di Verifikasi!');
    }

    public function printLPP($id)
    {
        $printingLPP = Laporan::find($id);

        return view('print-LPP', [
            "printingLPP" => $printingLPP
        ]);

        // $pdf = Pdf::loadView('print-LPP', ["findLPP" =>$findLPP]);
        // return $pdf->download('LPP.pdf');

    }

    public function grafik($supplier, $kategori, $bulan)
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
        return redirect()->route('grafik', compact('supplier', 'kategori', 'bulan'));
    }

    public function dataGrafik($supplier, $kategori, $bulan)
    {

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        if ($supplier == 0 && $kategori == 0 && $bulan == 0) {
            $AllPart = Part::all()->sortBy('nama_part');
            foreach ($AllPart as $key) {
                // dd($key->part);
                $label[] = $key->nama_part;
                $data1[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 0)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
                $data2[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 1)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
            }
            // dd('pas1');
        } elseif ($supplier != 0 && $kategori == 0 && $bulan == 0) {
            $AllPart = Part::where('supplier_id', $supplier)->orderBy('nama_part')->get();
            foreach ($AllPart as $key) {
                // dd($key->part);
                $label[] = $key->nama_part;
                $data1[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 0)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
                $data2[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 1)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
            }
            // dd('pas2');
        } elseif ($supplier != 0 && $kategori != 0 && $bulan == 0) {
            $AllPart = Part::where('supplier_id', $supplier)->where('kategori_id', $kategori)->orderBy('nama_part')->get();
            foreach ($AllPart as $key) {
                // dd($key->part);
                $label[] = $key->nama_part;
                $data1[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 0)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
                $data2[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 1)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
            }
            // dd('pas3');
        } elseif ($supplier == 0 && $kategori != 0 && $bulan == 0) {
            $AllPart = Part::where('kategori_id', $kategori)->orderBy('nama_part')->get();
            foreach ($AllPart as $key) {
                // dd($key->part);
                $label[] = $key->nama_part;
                $data1[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 0)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
                $data2[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 1)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
            }
            // dd('pas4');
        } elseif ($supplier == 0 && $kategori != 0 && $bulan != 0) {
            $AllPart = Part::where('kategori_id', $kategori)->orderBy('nama_part')->get();
            foreach ($AllPart as $key) {
                // dd($key->part);
                $label[] = $key->nama_part;
                $data1[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 0)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $bulan)
                    ->count();
                $data2[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 1)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $bulan)
                    ->count();
            }
            // dd('pas5');
        } elseif ($supplier != 0 && $kategori == 0 && $bulan != 0) {
            $AllPart = Part::where('kategori_id', $supplier)->orderBy('nama_part')->get();
            // dd($AllPart);
            foreach ($AllPart as $key) {
                // dd($key);
                $label[] = $key->nama_part;
                $data1[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 0)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $bulan)
                    ->count();
                $data2[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 1)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $bulan)
                    ->count();
            }
            // dd('pas6', $label);
        } elseif ($supplier == 0 && $kategori == 0 && $bulan != 0) {
            $AllPart = Part::all()->sortBy('nama_part');
            foreach ($AllPart as $key) {
                // dd($key->part);
                $label[] = $key->nama_part;
                $data1[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 0)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $bulan)
                    ->count();
                $data2[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 1)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $bulan)
                    ->count();
            }
            // dd('pas7');
        } elseif ($supplier != 0 && $kategori != 0 && $bulan != 0) {
            $AllPart = Part::where('supplier_id', $supplier)->where('kategori_id', $kategori)->orderBy('nama_part')->get();
            foreach ($AllPart as $key) {
                // dd($key->part);
                $label[] = $key->nama_part;
                $data1[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 0)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $bulan)
                    ->count();
                $data2[] = CatatanCekModel::where('id_part', $key->kode_part)->where('final_status', 1)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $bulan)
                    ->count();
            }
            // dd('pas8');
        }


        // $data1[] = [12];

        // $data2[] = [12];


        $data = [$label, $data1, $data2];

        return response()->json($data);
    }
}
