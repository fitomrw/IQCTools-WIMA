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
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="form-text mt-1">Masukkan Nama Lengkap</div>
                    <input type="text" class="form-control @error ('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    
                    @error ('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <div class="form-text mt-1">Masukkan Jabatan</div>
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
                    <div class="form-text mt-1">Masukkan Username</div>
                    <input type="text" class="form-control @error ('username') is-invalid @enderror" id="username" name="username" value="{{ old('name') }}" required>
                    @error ('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="form-text mt-1">Masukkan Email</div>
                    <input type="email" class="form-control @error ('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error ('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror  
                </div>

                

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="form-text mt-1">Masukkan Password</div>
                    <input type="password" class="form-control @error ('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required>
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