@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <div class="row">
            <form action="/kelola-masterStandar/store" method="post">
                @csrf
                <div class="col-lg-5 d-inline-block ml-2">
                    <label for="kategori_id" class="form-label">Jenis Standar</label>
                    <div class="form-text mt-1">Masukkan Jenis Standar</div>
                    <select class="form-select" id="jenis_standar" name="jenis_standar">
                        <option selected></option>
                        <option value="VISUAL">Visual</option>
                        <option value="DIMENSI">Dimensi</option>
                        <option value="FUNCTION">Function</option>
                    </select>

                    <label for="kategori_id" class="form-label">Alat</label>
                    <div class="form-text mt-1">Masukkan Alat</div>
                    <select class="form-select" id="alat" name="alat">
                        <option selected></option>
                        <option value="VISUAL/MATA">VISUAL/MATA</option>
                        <option value="SOUND LEVEL METER">SOUND LEVEL METER</option>
                        <option value="CHECKER DAN TELINGA">CHECKER DAN TELINGA</option>
                        <option value="TANGAN">TANGAN</option>
                        <option value="CALIPER">CALIPER</option>
                        <option value="FUNCTION">FUNCTION</option>
                        <option value="RING GAUGE">RING GAUGE</option>
                        <option value="THREAD GAUGE">THREAD GAUGE</option>
                        <option value="FILLER GAUGE">FILLER GAUGE</option>
                        <option value="MISTAR BAJA">MISTAR BAJA</option>
                    </select>
                </div>

                <div class="col-lg-5 d-inline-block ml-2">
                    <label for="uraian" class="form-label">Uraian</label>
                    <div class="form-text mt-1">Masukkan Uraian</div>
                    <input type="text" class="form-control @error('uraian') is-invalid @enderror" name="uraian"
                        id="uraian">
                    @error('uraian')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3 ml-3 d-block">Tambah</button>
            </form>
        </div>
    </div>
@endsection
