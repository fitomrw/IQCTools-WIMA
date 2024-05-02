@extends ('layouts.main')

@section('container')
    {{-- Cards --}}
    @if (auth()->user()->jabatan == 'Staff QC')
        <div class="row row-cols-md-3  gx-1  mx-auto">
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
        </div>
    @endif

    {{-- @if (auth()->user()->jabatan == 'Kepala Seksi QC')
            
        @endif --}}

    @if (auth()->user()->jabatan == 'Staff QA')
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
    @endif
@endsection
