@extends('layouts.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <form action="/kelola-masterPart/store" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-5 d-inline-block ml-2">
                <label for="kategori_id" class="form-label">Kategori Part</label>
                <div class="form-text mt-1">Masukkan Kategori Part</div>
                <select class="form-select" id="kategori_id" name="kategori_id">
                    <option selected></option>
                    @foreach ($kategoris as $kat)
                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option> 
                    @endforeach
                </select>
                
                <label for="nama_part" class="form-label">Nama Part</label>
                <div class="form-text mt-1">Masukkan Nama Part</div>
                <input type="text" class="form-control @error ('nama_part') is-invalid @enderror" name="nama_part" id="nama_part">
                @error ('nama_part')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </select>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Input Gambar</label>
                    <div class="form-text mt-1">Masukkan Gambar Part</div>
                    <input class="form-control" type="file" id="formFile" name="gambar_part" required>
                </div>
            </div>

            <div class="col-lg-5 d-inline-block ml-2">
                <label for="kode_part" class="form-label">Kode Part</label>
                <div class="form-text mt-1">Masukkan Kode Part</div>
                <input type="text" class="form-control @error ('kode_part') is-invalid @enderror" name="kode_part" id="kode_part">
                @error ('kode_part')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

                <label for="supplier_id" class="form-label mt-2">Supplier</label>
                <div class="form-text mt-1">Masukkan Supplier</div>
                <select class="form-select" id="supplier_id" name="supplier_id">
                    <option selected></option>
                    @foreach ($suppliers as $supply)
                    <option value={{ $supply->id_supplier }}>{{ $supply->nama_supplier }}</option>
                    @endforeach
                </select>
               
            </div>
            <button type="submit" class="btn btn-primary mt-3 ml-3 d-block">Tambah</button>
        </form>
    </div>
</div>
@endsection