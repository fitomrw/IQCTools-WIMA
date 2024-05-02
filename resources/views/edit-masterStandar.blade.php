@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <div class="row">
            <form action="/kelola-masterStandar/update/{{ $editStandar->id_standar }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-lg-5 d-inline-block ml-2">
                    <label for="jenis_standar" class="form-label">Jenis Standar</label>
                    <div class="form-text mt-1">Masukkan Jenis Standar</div>
                    <select class="form-select" id="jenis_standar" name="jenis_standar" value="{{ old('jenis_standar')}}">
                        <option selected></option>
                        <option value="VISUAL"{{ ($editStandar->jenis_standar == 'VISUAL') ? 'selected' : '' }}>Visual</option>
                        <option value="DIMENSI" {{ ($editStandar->jenis_standar == 'DIMENSI') ? 'selected' : '' }}>Dimensi</option>
                        <option value="FUNCTION" {{ ($editStandar->jenis_standar == 'FUNCTION') ? 'selected' : '' }}>Function</option>
                    </select>

                    <label for="kategori_id" class="form-label">Alat</label>
                    <div class="form-text mt-1">Masukkan Alat</div>
                    <select class="form-select" id="alat" name="alat">
                        <option selected></option>
                        <option value="VISUAL/MATA" {{ ($editStandar->alat == 'VISUAL/MATA') ? 'selected' : '' }}>VISUAL/MATA</option>
                        <option value="CALIPER" {{ ($editStandar->alat == 'CALIPER') ? 'selected' : '' }}>CALIPER</option>
                        <option value="FUNCTION" {{ ($editStandar->alat == 'FUNCTION') ? 'selected' : '' }}>FUNCTION</option>
                    </select>
                </div>

                <div class="col-lg-5 d-inline-block ml-2">
                    <label for="uraian" class="form-label">Uraian</label>
                    <div class="form-text mt-1">Masukkan Uraian</div>
                    <input type="text" class="form-control @error('uraian') is-invalid @enderror" name="uraian" id="uraian" value="{{ $editStandar->uraian }}">
                    @error('uraian')
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
