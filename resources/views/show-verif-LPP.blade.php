@extends('layouts.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5 d-inline-block ml-2">
            <p><b>To :</b> {{ $showVerifLaporan->to }}</p>
            <p><b>Attention :</b> {{ $showVerifLaporan->attention }}</p>
            <p><b>CC :</b> {{ $showVerifLaporan->cc }}</p>
            <p><b>Model :</b> {{ $showVerifLaporan->kategori_part->nama_kategori }}</p>
            <p><b>Part Name :</b> {{ $showVerifLaporan->part->nama_part }}</p>
            <p><b>Part Code :</b> {{ $showVerifLaporan->part_code}}</p>
        </div>

        <div class="col-lg-5 d-inline-block ml-2">
            <p><b>Quantity : </b> {{ $showVerifLaporan->quantity }}</p>
            <p><b>Problem Description : </b> {{ $showVerifLaporan->problem_description }}</p>
            <p><b>Request : </b> {{ $showVerifLaporan->request }}</p>
            <form action="/kelola-LPP/executeVerif/{{ $showVerifLaporan->id }}" method="post">
                @csrf
                <input type="hidden" name="status" id="status" value="1" id="successVerif">
                <button type="submit" class="btn btn-success" id="buttonVerif" onclick="delDataButtonPeriksa()">Verifikasi</button>
            </form>
        </div>
    </div>
</div>

<script>
    function delDataButtonPeriksa() {
        var buttonPeriksa = document.getElementById("successVerif").value;
        localStorage.setItem("successVerif", successVerif);
        window.location.href = "verif-LPP.blade.php";
    }
</script>
@endsection