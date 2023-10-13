@extends('layouts.main')
@section('container')
<div class="container-fluid">
    <a href="/register/create">
        <button type="button" class="btn btn-primary d-inline-block mb-3">Tambah User</button>
    </a>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Jabatan</th>  
            <th scope="col">Aksi</th>  
        </tr>
        </thead>
        <tbody>
        @foreach ($user as $u)   
        <tr>
            <th scope="row"> {{ $loop->iteration }}</th>
            <td>{{ $u->name }}</td>
            <td>{{ $u->username }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->jabatan }}</td>
            <td>
                <a class="btn btn-warning" href="/register/edit/{{ $u->id }}" role="button">Edit</a>
                <form action="/register/destroy/{{ $u->id }}" method="post" class="d-inline"> 
                  @csrf
                  @method('DELETE')
                  <a class="btn btn-danger" href="/register/destroy/{{ $u->id }}" role="button" onclick="alert('Apakah anda yakin untuk menghapus user ini?')">Delete</a>
                </form>
            </td>
            @endforeach
        </tr>
        </tbody>
    </table>
    {{ $user->links() }}
</div>
@endsection