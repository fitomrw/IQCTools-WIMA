<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login', [
            "title" => "Login",
            "image" => "img/wima_logo.png"
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required', 'min:3']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            // return redirect()->intended('/');
            if (auth()->user()->jabatan == 'Kepala Seksi QC') {
                return redirect()->intended('/verifikasi-pengecekan');
            } else if (auth()->user()->jabatan == 'Staff QA') {
                return redirect()->intended('/kelola-LPP/verifLaporan');
            }         
        }

        return back()->with('loginError', 'Login gagal! Username atau password salah!');
    }

    public function logout (Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/login');
    }
}
