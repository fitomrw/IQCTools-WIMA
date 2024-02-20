@extends('layouts.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <form action="/kelola-masterPart/update/{{ $k_part->kode_part }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-lg-5 d-inline-block ml-2">
                <label for="kategori_id" class="form-label">Kategori Part</label>
                <div class="form-text mt-1">Masukkan Kategori Part</div>
                <select class="form-select" id="kategori_id" name="kategori_id">
                    <option selected></option>
                    @foreach ($kategoris as $kat)
                    <option value="{{ $kat->id_kategori }}" @if($kat->id_kategori == $k_part->kategori_id) selected @endif>
                        {{ $kat->nama_kategori }}</option> 
                    @endforeach
                </select>
                
                <label for="nama_part" class="form-label mt-2">Nama Part</label>
                <div class="form-text mt-1">Masukkan Nama Part</div>
                <input type="text" class="form-control @error ('nama_part') is-invalid @enderror" name="nama_part" id="nama_part" value="{{ $k_part->nama_part }}">
                @error ('nama_part')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </select>

                <label for="kode_part" class="form-label">Kode Part</label>
                <div class="form-text mt-1">Masukkan Kode Part</div>
                <input type="text" class="form-control @error ('kode_part') is-invalid @enderror" name="kode_part" id="kode_part" value="{{ $k_part->kode_part }}">
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
                    <option value="{{ $supply->id_supplier }}" @if($supply->id_supplier == $k_part->supplier_id) selected @endif>
                        {{ $supply->nama_supplier }}</option>
                    @endforeach
                </select>
                <div class="mt-2" id="gantiGambar">
                    <label for="formFile" class="form-label">Input Gambar</label>
                    <input class="form-control" type="file" id="formFile" name="gambar_part" >
                </div>
            </div>
            <div class="col-lg-5 d-inline-block ml-2">
                <img src="/img/img_part/{{ $k_part->gambar_part }}" class="img-fluid">
                <button id="buttonGambar" type="button" class="btn btn-primary mt-3 ml-3 d-block" onclick="ubahGambar()">Ubah Gambar</button>
                {{-- <button id="gkJadi" type="button" class="btn btn-danger mt-3 ml-3 d-block" onclick="GkJadiUbahGambar()">Batal Ganti</button> --}}
            </div>
            <div class="col-lg-5 d-inline-block ml-2">
                {{-- <img src="/img/img_part/{{ $k_part->gambar_part }}" class="img-fluid"> --}}
                <button type="submit" class="btn btn-primary mt-3 ml-3 d-block">Simpan</button>
            </div>
           
        </form>
    </div>
</div>
<script>
    let ganti = document.getElementById('gantiGambar');
    let tombolGanti = document.getElementById('buttonGambar');
    // let tombolGkJadiGanti = document.getElementById('gkJadi');
    ganti.hidden = true;
    // tombolGkJadiGanti.hidden = true;
    tombolGanti.hidden = false;
    function ubahGambar() {
        ganti.hidden = false;
        // tombolGkJadiGanti.hidden = false;
        tombolGanti.hidden = true;
    }

    function GkJadiUbahGambar() {
        ganti.hidden = true;
        // tombolGkJadiGanti.hidden = true;
        tombolGanti.hidden = false;
    }
</script>
@endsection