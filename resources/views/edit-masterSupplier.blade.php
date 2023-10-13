@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <form action="/kelola-masterSupplier/update/{{ $supply->id_supplier }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-5 d-inline-block ml-2">

                    <label for="nama_supplier" class="form-label">Nama Supplier</label>
                    <div class="form-text mt-1">Masukkan Nama Supplier</div>
                    <input type="text" class="form-control" name="nama_supplier" id="nama_supplier" value="{{ $supply->nama_supplier }}">
                    <label for="no_telepon" class="form-label mt-2">Nomor Telepon</label>
                    <div class="form-text mt-1">Masukkan Nomor Telepon</div>
                    <input type="text" class="form-control" name="no_telepon" id="no_telepon" value="{{ $supply->no_telepon }}">
                </div>
        
                <div class="col-lg-5 d-inline-block ml-2">
                    <label for="email" class="form-label">Email Supplier</label>
                    <div class="form-text mt-1">Masukkan Email Supplier</div>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $supply->email }}">
                    <label for="alamat" class="form-label mt-2">Alamat Supplier</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $supply->alamat }}</textarea>
                </div>

            
                <div class="d-block"><button type="submit" class="btn btn-primary mt-3 ml-2">Simpan</button>
                </div>
                
        </form>
        </div>
            </div>
        </div>
    </div>
@endsection