@extends('layouts.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <form action="/kelola-masterStandar/" method="post">
            @csrf
            @method('PUT')
            <div class="col-lg-5 d-inline-block ml-2">
                <label for="jenis_standar" class="form-label">Jenis Standar</label>
                <div class="form-text mt-1">Masukkan Jenis Standar</div>
                <select class="form-select" id="jenis_standar" name="jenis_standar">
                    @foreach ($editStandar as $e)
                        <option value="{{ $e->id_standar }}" {{ old('jenis_standar', $e->id_standar) == $e->id_standar ? 'selected' : '' }}>
                            {{ $e->jenis_standar }}
                </option>
            @endforeach
        </select>
                </select>
                
                <label for="kategori_id" class="form-label">Alat</label>
                <div class="form-text mt-1">Masukkan Alat</div>
                <select class="form-select" id="alat" name="alat">
                    <option selected></option>
                    <option value="VISUAL/MATA">VISUAL/MATA</option>
                    <option value="CALIPER">CALIPER</option>
                    <option value="FUNCTION">FUNCTION</option>
                </select>
            </div>

            <div class="col-lg-5 d-inline-block ml-2">
                <label for="uraian" class="form-label">Uraian</label>
                <div class="form-text mt-1">Masukkan Uraian</div>
                <input type="text" class="form-control @error ('uraian') is-invalid @enderror" name="uraian" id="uraian">
                @error ('uraian')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 ml-3 d-block">Simpan</button>
        </form>
    </div>
</div>
@endsection