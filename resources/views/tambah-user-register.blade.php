@extends('layouts.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        @if(session()->has('success'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

            <form action="/register/store" method="post">
                @csrf
                <h2 class="text-center mb-3">Silahkan Registrasi</h3>
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" class="form-control @error ('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan Nama Lengkap" value="{{ old('name') }}" required>
                    
                    @error ('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <select class="form-control @error ('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required> 
                        <option></option>
                        <option value="Staff QC">Staff QC</option>
                        <option value="Admin QC">Admin QC</option>
                        <option value="Kepala Seksi QC">Kepala Seksi QC</option>
                        <option value="Staff QA">Staff QA</option>
                    </select>
                </div>

                @error ('jabatan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror


                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error ('username') is-invalid @enderror" id="username" name="username" placeholder="Masukkan Username"  value="{{ old('name') }}" required>
                    @error ('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error ('email') is-invalid @enderror" id="email" name="email" sd placeholder="Masukkan Email" value="{{ old('email') }}" required>
                    @error ('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror  
                </div>

                

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error ('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password" value="{{ old('password') }}" required>
                    @error ('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="w-100 btn btn-primary">Register</button>
            </form>
    </div>
</div>

@endsection