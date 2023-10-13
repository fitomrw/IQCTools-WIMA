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

            <form action="/register/update/{{ $editUser->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" class="form-control @error ('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan Nama Lengkap" value="{{ old('name', $editUser->name) }}" required>
                    
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
                        <option value="Staff QC" {{ ($editUser->jabatan == 'Staff QC') ? 'selected' : '' }}>Staff QC</option>
                        <option value="Admin QC" {{ ($editUser->jabatan == 'Admin QC') ? 'selected' : '' }}>Admin QC</option>
                        <option value="Kepala Seksi QC" {{ ($editUser->jabatan == 'Kepala Seksi QC') ? 'selected' : '' }}>Kepala Seksi QC</option>
                        <option value="Staff QA" {{ ($editUser->jabatan == 'Staff QA') ? 'selected' : '' }}>Staff QA</option>
                    </select>
                </div>

                @error ('jabatan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror


                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error ('username') is-invalid @enderror" id="username" name="username" placeholder="Masukkan Username"  value="{{ old('username', $editUser->username) }}" required>
                    @error ('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error ('email') is-invalid @enderror" id="email" name="email" sd placeholder="Masukkan Email" value="{{ old('email', $editUser->email) }}" required>
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

                <button type="submit" class="w-100 btn btn-primary">Edit</button>
            </form>
    </div>
</div>

@endsection