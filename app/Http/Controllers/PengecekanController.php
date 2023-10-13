<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengecekanController extends Controller
{
    public function index()
    {
        return view ('kelola-pengecekan',[
            "title" => "Pengecekan"
        ]);
    }

    public function create()
    {
        return view('tambahdata-pengecekan', [
            "title" => "Tambah Pengecekan",
               "image" => "img/wima_logo.png"
        ]);
    }
}
