@extends('layouts.main')

@section('container')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-secondary"></div>
        <div class="card-body">
            <form action="/kelola-LPP/update/{{ $edit_laporan->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="to" class="form-label">To</label>
                    <input type="text" class="form-control" name="to" id="to" value="{{ $edit_laporan->to }}" required>
                </div>
                <div class="mb-3">
                    <label for="attention" class="form-label">Attention</label>
                    <input type="text" class="form-control" name="attention" id="attention" value="{{ $edit_laporan->attention }}" required>
                </div> 
                <div class="mb-3">
                    <label for="cc" class="form-label">CC</label>
                    <input type="text" class="form-control" name="cc" id="cc" value="{{ $edit_laporan->cc }}" required>
                </div>
                <div class="mb-3">
                    <label for="model" class="form-label">Model</label>
                    <select class="form-select" name="model" id="model" required>
                        @foreach ($model_kategori as $mk)
                        <option selected></option>
                        <option value="{{ $mk->id_kategori }}" {{ ($edit_laporan->model == $mk->id_kategori) ? 'selected' : '' }}>{{ $mk->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="part_name" class="form-label">Part Name</label>
                    <select class="form-select" name="part_name" id="part_name" required>
                        @foreach($part as $p)
                        <option selected></option>
                        <option value="{{ $p->nama_part }}" {{ ($edit_laporan->part->nama_part == $p->nama_part) ? 'selected' : '' }}>{{ $p->nama_part }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="part_code" class="form-label">Part code</label>
                <select class="form-select" name="part_code" id="part_code" required>
                        @foreach($part as $p)
                        <option selected></option>
                        <option value="{{ $p->kode_part }}" {{ ($edit_laporan->part_code == $p->kode_part) ? 'selected' : '' }}>{{ $p->kode_part }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="text" class="form-control" name="quantity" id="quantity" value="{{ $edit_laporan->quantity }}" required>
                </div>
                <div class="mb-3">
                    <label for="problem_description" class="form-label">Problem Description</label>
                    <textarea class="form-control" id="problem_description" rows="5" name="problem_description" required>{{ $edit_laporan->problem_description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="found_area" class="form-label">Found Area</label>
                    <select class="form-select" name="found_area" id="found_area" required>
                        <option selected></option>
                        <option value="On Customer" {{ ($edit_laporan->found_area == 'On Customer') ? 'selected' : '' }}>On Customer</option>
                        <option value="On Factory" {{ ($edit_laporan->found_area == 'On Factory') ? 'selected' : '' }}>On Factory</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="request" class="form-label">Request</label>
                    <textarea class="form-control" id="request" rows="5" name="request" required>{{ $edit_laporan->request }}
                    </textarea>
                </div> 
                <div class="mb-3">
                    <label for="problem_description" class="form-label">Gambar Temuan</label>
                    <img src="/img/img_lpp/" alt="">
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
    </form>
</div>

@endsection