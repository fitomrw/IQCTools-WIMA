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


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home', [
        "title" => "Home",
        "image" => "img/wima_logo.png"
    ]);
})->middleware(['auth']);

Route::get('/riwayatPengecekan', function (){
    return view('riwayatPengecekan', [
        "title" => "Riwayat Pengecekan",
           "image" => "img/wima_logo.png"
    ]);
});


//login logout
Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

//register
Route::middleware(['auth', 'CekJabatan:Admin QC'])->group(function () {
    Route::get('/register', [RegisterController::class, 'index']);
    Route::get('/register/create', [RegisterController::class, 'create']);
    Route::post('/register/store', [RegisterController::class, 'store']);
    Route::get('/register/edit/{id}', [RegisterController::class, 'edit']);
    Route::put('/register/update/{id}', [RegisterController::class, 'update']);
    Route::get('/register/destroy/{id}', [RegisterController::class, 'destroy']);

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
    Route::put('/kelola-masterKategori/update/{id_kategori}',[KategoriController::class, 'update']);
    Route::get('/kelola-masterKategori/destroy/{id_kategori}', [KategoriController::class, 'destroy']);
    
    //master supplier
    Route::get('/kelola-masterSupplier', [SupplierController::class, 'index']);
    Route::get('/kelola-masterSupplier/create', [SupplierController::class, 'create']);
    Route::post('/kelola-masterSupplier/store', [SupplierController::class, 'store']);
    Route::get('/kelola-masterSupplier/edit/{id_supplier}', [SupplierController::class, 'edit']);
    Route::put('/kelola-masterSupplier/update/{id_supplier}',[SupplierController::class, 'update']);
    Route::get('/kelola-masterSupplier/destroy/{id_supplier}', [SupplierController::class, 'destroy']); 
});

//data part incoming
Route::middleware(['auth','CekJabatan:Staff QC'])->group(function () {
    Route::resource('/dataPartIncoming', DataPartIncomingController::class);
    Route::get('/dataPartIncoming/getBarang/{kategori_id}', [DataPartIncomingController::class, 'getKodePart']);
    Route::get('/dataPartIncoming/getBarangEdit/{kategori_id}', [DataPartIncomingController::class, 'getKodePartEdit']);
});


//data pengecekan
Route::middleware(['auth','CekJabatan:Staff QC'])->group(function () {
    Route::get('/kelola-pengecekan', [PengecekanController::class, 'index'])->middleware('auth');
});

//laporan
Route::middleware(['auth','CekJabatan:Staff QC'])->group(function () {
    Route::get('/kelola-LPP', [LaporanController::class, 'index']);
    Route::get('/kelola-LPP/create', [LaporanController::class, 'create']);
    Route::post('/kelola-LPP/store', [LaporanController::class, 'store']);
    Route::get('/kelola-LPP/edit/{id}', [LaporanController::class, 'edit']);
    Route::put('/kelola-LPP/update/{id}', [LaporanController::class, 'update']);
    Route::get('/kelola-LPP/destroy/{id}', [LaporanController::class, 'destroy']);
});

Route::middleware(['auth','CekJabatan:Staff QA'])->group(function () {
    Route::get('/kelola-LPP/verifLaporan', [LaporanController::class, 'verifIndex']);
    Route::get('/kelola-LPP/verifLaporanShow/{id}', [LaporanController::class, 'verifShow']);
    Route::post('/kelola-LPP/executeVerif/{id}', [LaporanController::class, 'executeVerif']);
    Route::get('/kelola-LPP/printLPP/{id}', [LaporanController::class, 'printLPP']);
});






