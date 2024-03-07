<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $user = User::paginate(5);

        return view('kelola-user', [
            "title" => "User",
            "image" => "img/wima_logo.png",
            "user" => $user
        ]);
    }

    public function create()
    {
        return view('tambah-user-register', [
            "title" => "Tambah Data User",
            "image" => "img/wima_logo.png"
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'jabatan' => ['required'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'min:5', 'max:255']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/register')->with("success", 'User berhasil ditambahkan!');

    }

    public function edit($id)
    {
        $editUser = User::find($id);

        return view('edit-user-register', [
            "title" => "Edit Data User",
            "image" => "img/wima_logo.png",
            "editUser" => $editUser
        ]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'username' => ['required', 'min:3', 'max:255'],
            'jabatan' => ['required'],
            'email' => ['required', 'email:dns'],
            'password' => ['required', 'min:5', 'max:255']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::where('id', $id)
            ->update($validatedData);

        return redirect('/register')->with("success", 'User berhasil diubah!');
    }

    public function destroy($id)
    {
        $deleteUser = User::find($id);
        $deleteUser->delete();

        return redirect('/register')->with("deleteNotify", 'Data user berhasil dihapus!');
    }
}
