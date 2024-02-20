@extends('layouts.main')
@section('container')
<div class="container-fluid">
    <form action="/kelola-standarMIL/store" method="post">
        @csrf
        <label for="min_sample" class="form-label mt-1">Minimum Sample</label>
        <div class="form-text">Masukkan Minimum Sample</div>
        <input type="text" class="form-control" name="min_sample" id="min_sample">

        <label for="max_sample" class="form-label mt-1">Maximum Sample</label>
        <div class="form-text">Masukkan Maximum Sample</div>
        <input type="text" class="form-control" name="max_sample" id="max_sample">

        <label for="size_code" class="form-label mt-1">Size Code</label>
        <div class="form-text">Masukkan Size Code</div>
        <input type="text" class="form-control" name="size_code" id="size_code">

        <label for="sample_size" class="form-label mt-1">Sample Size</label>
        <div class="form-text">Masukkan Sample Size</div>
        <input type="text" class="form-control" name="sample_size" id="sample_size">

        {{-- <label for="limit_ng" class="form-label mt-1">Limit NG</label>
        <div class="form-text">Masukkan Limit NG</div>
        <input type="text" class="form-control" name="limit_ng" id="limit_ng"> --}}

        <button type="submit" class="btn btn-success mt-3">Tambah</button>
    </form>
</div>
@endsection