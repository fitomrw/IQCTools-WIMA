@extends('layouts.main')

@section('container')

<div class="container-fluid">
    <div class="row">
        <form action="/kelola-masterKategori/update/{{ $katPart->id_kategori }}" method="post">
            @csrf
            @method('PUT')
            <div class="col-lg-5 d-inline-block ml-2">
                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                <div class="form-text mt-1">Masukkan Nama Kategori</div>
                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="{{ $katPart->nama_kategori }}">
            </div>
            <div class="d-block"><button type="submit" class="btn btn-primary mt-3 ml-3">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection