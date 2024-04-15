@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 d-inline-block ml-2">
                <p><b>To :</b> {{ $showLaporan->supplier->nama_supplier }}</p>
                <p><b>Attention :</b> {{ $showLaporan->attention }}</p>
                <p><b>CC :</b> {{ $showLaporan->cc }}</p>
                <p><b>Model :</b> {{ $showLaporan->kategori_part->nama_kategori }}</p>
                <p><b>Part Name :</b> {{ $showLaporan->part->nama_part }}</p>
                <p><b>Part Code :</b> {{ $showLaporan->part_code }}</p>
            </div>

            <div class="col-lg-5 d-inline-block ml-2">
                <p><b>Quantity : </b> {{ $showLaporan->quantity }}</p>
                <p><b>Problem Description : </b> {{ $showLaporan->problem_description }}</p>
                <p><b>Request : </b> {{ $showLaporan->request }}</p>
                <p><b>Found Area : </b> {{ $showLaporan->found_area }}</p>
                <p><b>Found Date : </b> {{ $showLaporan->found_date }}</p>
                <p><b>Issue Date : </b> {{ $showLaporan->issue_date }}</p>
                <p><b>Illustration : </b>
                    <br>
                    <img src="/img/img_lpp/{{ $showLaporan->gambar_lpp }}" alt="illustration" style="max-width:300px"
                        class="mt-3">
                </p>
            </div>
        </div>
    </div>
@endsection
