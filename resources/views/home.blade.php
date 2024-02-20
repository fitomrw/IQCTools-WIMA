@extends ('layouts.main')

@section('container')

{{-- Cards --}}
<div class="row row-cols-md-3 row-cols-2 gx-1 justify-content-center mx-auto">
    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Part Incoming</h5>
                <div class="container bg-success rounded-3">
                    <a href="/dataPartIncoming" class="text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Pengecekan</h5>
                <div class="container bg-success rounded-3">
                    <a href="/riwayatPengecekan" class="card-text text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Laporan Penyimpangan Part</h5>
                <div class="container bg-success rounded-3">
                    <a href="kelola-LPP" class="card-text text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Kelola Data Master</h5>
                <div class="container bg-success rounded-3">
                    <a href="/kelolaDataMaster" class="card-text text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Kelola User</h5>
                <div class="container bg-success rounded-3">
                    <a href="/register" class="card-text text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Kelola Standar Per Part</h5>
                <div class="container bg-success rounded-3">
                    <a href="/kelola-masterStandarPart" class="card-text text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Kelola Data Standar MIL 105 STD E</h5>
                <div class="container bg-success rounded-3">
                    <a href="/kelola-standarMIL" class="card-text text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Verifikasi Pengecekan</h5>
                <div class="container bg-success rounded-3">
                    <a href="/verifikasi-pengecekan" class="card-text text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-primary" style="width: 18rem; height: 10rem;">
            <div class="card-body text-center">
                <h5 class="fs-5">Verifikasi LPP</h5>
                <div class="container bg-success rounded-3">
                    <a href="/kelola-LPP/verifLaporan" class="card-text text-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

</div>



@endsection