@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <form action="/kelola-masterSupplier/store" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-5 d-inline-block ml-2">
                    <label for="nama_supplier" class="form-label">Nama Supplier</label>
                    <div class="form-text mt-1">Masukkan Nama Supplier</div>
                    <input type="text" class="form-control @error ('nama_supplier') is-invalid @enderror" name="nama_supplier" id="nama_supplier" value="{{ old('nama_supplier') }}">                    
                    @error ('nama_supplier')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="no_telepon" class="form-label mt-2">Nomor Telepon</label>
                    <div class="form-text mt-1">Masukkan Nomor Telepon</div>
                    <input type="text" class="form-control @error ('no_telepon') is-invalid @enderror" name="no_telepon" id="no_telepon" value="{{ old('nama_supplier') }}">                    
                    @error ('no_telepon')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
        
                <div class="col-lg-5 d-inline-block ml-2">
                    <label for="email" class="form-label">Email Supplier</label>
                    <div class="form-text mt-1">Masukkan Email Supplier</div>
                    <input type="email" class="form-control @error ('email') is-invalid @enderror" name="email" id="email" value="{{ old('nama_supplier') }}">
                    @error ('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="alamat" class="form-label mt-2">Alamat Supplier</label>
                    <textarea class="form-control @error ('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" value="{{ old('nama_supplier') }}"></textarea>                   
                    @error ('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-block">
                    <button type="submit" class="btn btn-primary mt-3 ml-2">Simpan</button>
                </div>
                
        </form>
        </div>
            </div>
        </div>
    </div>
@endsection