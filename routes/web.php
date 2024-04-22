<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DataPartIncomingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PengecekanController;
use App\Http\Controllers\SupplierController;
use App\Models\Pengecekan;
use App\Models\Supplier;
use App\Models\kategoriPart;

/*
|--------------------------------------------------------------------------
| Web Routes
| Here is where you can register web routes for your application. These
|--------------------------------------------------------------------------
|
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $getSupplier = Supplier::all();
    $getKategori = kategoriPart::all();

    return view('home', [
        "title" => "Home",
        "image" => "img/wima_logo.png",
        "getSupplier" => $getSupplier,
        "getKategori" => $getKategori
    ]);
})->middleware(['auth']);

Route::get('/kelolaDataMaster', function () {
    return view('kelolaDataMaster', [
        "title" => "Kelola Data Master",
        "image" => "img/wima_logo.png"
    ]);
})->middleware(['auth']);

// Route::get('/riwayatPengecekan', function (){
//     return view('riwayatPengecekan', [
//         "title" => "Riwayat Pengecekan",
//            "image" => "img/wima_logo.png"
//     ]);
// });


//login logout
Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::middleware(['auth', 'CekJabatan:Admin QC'])->group(function () {
    //register
    Route::get('/register', [RegisterController::class, 'index']);
    Route::get('/register/create', [RegisterController::class, 'create']);
    Route::post('/register/store', [RegisterController::class, 'store']);
    Route::get('/register/edit/{id}', [RegisterController::class, 'edit']);
    Route::put('/register/update/{id}', [RegisterController::class, 'update']);
    Route::get('/register/destroy/{id}', [RegisterController::class, 'destroy']);



    //Master Data MIL STD 105 E
    Route::get('/kelola-standarMIL', [PengecekanController::class, 'indexMIL']);
    Route::get('/kelola-standarMIL/create', [PengecekanController::class, 'createMIL']);
    Route::post('/kelola-standarMIL/store', [PengecekanController::class, 'storeMIL']);
    Route::get('/kelola-standarMIL/edit/{id}', [PengecekanController::class, 'editMIL']);
    Route::put('/kelola-standarMIL/update/{id}', [PengecekanController::class, 'updateMIL']);
    Route::get('/kelola-standarMIL/destroy/{id}', [PengecekanController::class, 'deleteMIL']);
});

//data part incoming
Route::middleware(['auth', 'CekJabatan:Staff QC'])->group(function () {
    Route::resource('/dataPartIncoming', DataPartIncomingController::class);
    Route::get('/dataPartIncoming/delete/{id_part_supply}', [DataPartIncomingController::class, 'delete']);
    Route::get('/dataPartIncoming/getBarang/{kategori_id}', [DataPartIncomingController::class, 'getKodePart']);
    Route::get('/dataPartIncoming/getNamaPart/{kode_part}', [DataPartIncomingController::class, 'getNamaPart']);
    Route::get('/dataPartIncoming/getSupplier/{kode_part}', [DataPartIncomingController::class, 'getSupplier']);
    Route::get('/dataPartIncoming/getBarangEdit/{kategori_id}', [DataPartIncomingController::class, 'getKodePartEdit']);
});


//data pengecekan
Route::middleware(['auth', 'CekJabatan:Staff QC'])->group(function () {
    // Route::get('/kelola-pengecekan', [PengecekanController::class, 'index'])->middleware('auth');
    Route::get('/detailPengecekan/{id}/{kode_part}', [PengecekanController::class, 'detailPengecekan'])->middleware('auth');
    Route::post('/submit-cek', [PengecekanController::class, 'cekPerPoint']);
    Route::post('/submit-pengecekan/{id}', [PengecekanController::class, 'submitPengecekan']);
});

//data part Kepala Seksi
Route::get('/riwayatPengecekan', [PengecekanController::class, 'riwayatPengecekan'])->middleware('auth');
Route::middleware(['auth', 'CekJabatan:Kepala Seksi QC'])->group(function () {
    Route::get('/verifikasi-pengecekan/{supplier}/{kategori}/{bulan}', [PengecekanController::class, 'verifikasiPengecekan'])->name('grafikVerif');
    Route::post('/verifikasi-pengecekan/filterGrafik', [PengecekanController::class, 'filterGrafik']);
    // Route::get('/api/kelola-LPP/grafik/{supplier}/{kategori}/{bulan}', [PengecekanController::class, 'dataGrafik']);
    Route::get('/verifikasi-pengecekan/verifPengecekanShow/{id}/{kode_part}', [PengecekanController::class, 'verifPengecekanShow']);
    Route::post('/verifikasi-pengecekan/storeVerifikasiPengecekan/{id}', [PengecekanController::class, 'storeVerifikasiPengecekan']);
    Route::get('/verifikasi-pengecekan/getData', [PengecekanController::class, 'storeVerifikasiPengecekan']);
});

//laporan
Route::middleware(['auth', 'CekJabatan:Staff QC'])->group(function () {
    Route::get('/kelola-LPP', [LaporanController::class, 'index']);
    Route::get('/kelola-LPP/create', [LaporanController::class, 'create']);
    Route::get('/kelola-LPP/getPartInfo/{model}', [LaporanController::class, 'getPartInfo']);
    Route::post('/kelola-LPP/store', [LaporanController::class, 'store']);
    Route::get('/kelola-LPP/laporanShow/{id}', [LaporanController::class, 'show']);
    Route::get('/kelola-LPP/getPartInfoEdit/{model}', [LaporanController::class, 'getPartInfoEdit']);
    Route::get('/kelola-LPP/edit/{id}', [LaporanController::class, 'edit']);
    Route::put('/kelola-LPP/update/{id}', [LaporanController::class, 'update']);
    Route::get('/kelola-LPP/destroy/{id}', [LaporanController::class, 'destroy']);
});

Route::middleware(['auth', 'CekJabatan:Staff QA'])->group(function () {
    //master part
    Route::get('/kelola-masterPart', [PartController::class, 'index']);
    Route::get('/kelola-masterPart/create', [PartController::class, 'create']);
    Route::post('/kelola-masterPart/store', [PartController::class, 'store']);
    Route::get('/kelola-masterPart/edit/{kode_part}', [PartController::class, 'edit']);
    Route::put('/kelola-masterPart/update/{kode_part}', [PartController::class, 'update']);
    Route::get('/kelola-masterPart/destroy/{kode_part}', [PartController::class, 'destroy']);


    //master kategori
    Route::get('/kelola-masterKategori', [KategoriController::class, 'index']);
    Route::get('/kelola-masterKategori/create', [KategoriController::class, 'create']);
    Route::post('/kelola-masterKategori/store', [KategoriController::class, 'store']);
    Route::get('/kelola-masterKategori/edit/{id_kategori}', [KategoriController::class, 'edit']);
    Route::put('/kelola-masterKategori/update/{id_kategori}', [KategoriController::class, 'update']);
    Route::get('/kelola-masterKategori/destroy/{id_kategori}', [KategoriController::class, 'destroy']);

    //master supplier
    Route::get('/kelola-masterSupplier', [SupplierController::class, 'index']);
    Route::get('/kelola-masterSupplier/create', [SupplierController::class, 'create']);
    Route::post('/kelola-masterSupplier/store', [SupplierController::class, 'store']);
    Route::get('/kelola-masterSupplier/edit/{id_supplier}', [SupplierController::class, 'edit']);
    Route::put('/kelola-masterSupplier/update/{id_supplier}', [SupplierController::class, 'update']);
    Route::get('/kelola-masterSupplier/destroy/{id_supplier}', [SupplierController::class, 'destroy']);

    //Master Standar
    Route::get('/kelola-masterStandar', [PartController::class, 'indexStandar']);
    Route::get('/kelola-masterStandar/create', [PartController::class, 'createStandar']);
    Route::post('/kelola-masterStandar/store', [PartController::class, 'storeStandar']);
    Route::get('/kelola-masterStandar/edit/{id_standar}', [PartController::class, 'editStandar']);
    Route::post('/kelola-masterStandar/update/{id_standar}', [PartController::class, 'updateStandar']);
    Route::get('/kelola-masterStandar/delete/{id_standar}', [PartController::class, 'deleteStandar']);

    //Master Standar Per Part
    Route::get('/kelola-masterStandarPart', [PartController::class, 'indexPengaturanStandar']);
    Route::get('/kelola-masterStandarPart/edit/{part}', [PartController::class, 'editStandarPart']);
    Route::get('/kelola-masterStandarPart/getJenisStandarPart/{jenis_standar}', [PartController::class, 'getJenisStandarPart']);
    Route::post('/tambahStandarPart/{part}', [PartController::class, 'storePengaturanStandar']);
    Route::get('/kelola-masterStandarPart/delete/{id_standar_part}/{kode_part}', [PartController::class, 'deletePengaturanStandar']);

    //Verifikasi Laporan
    Route::get('/kelola-LPP/verifLaporan', [LaporanController::class, 'verifIndex']);
    Route::get('/kelola-LPP/getDataLPP', [LaporanController::class, 'getDataLPP']);
    Route::get('/kelola-LPP/verifLaporanShow/{id}', [LaporanController::class, 'verifShow']);
    Route::post('/kelola-LPP/executeVerif/{id}', [LaporanController::class, 'executeVerif']);
    Route::get('/kelola-LPP/printLPP/{id}', [LaporanController::class, 'printLPP']);
    Route::get('/kelola-LPP/grafik/{supplier}/{kategori}/{bulan}', [LaporanController::class, 'grafik'])->name('grafik');
    Route::post('/filterGrafik', [LaporanController::class, 'filterGrafik']);
});

Route::get('/api/kelola-LPP/grafik/{supplier}/{kategori}/{bulan}', [LaporanController::class, 'dataGrafik']);
