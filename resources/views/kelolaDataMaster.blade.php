@extends('layouts.main')
@section('container')
    <div class="row ml-2">
        <div class="col">
            <div class="card bg-primary" style="width: 18rem; height: 10rem;">
                <div class="card-body text-center">
                    <h5 class="fs-5">Kelola Data Supplier</h5>
                    <div class="container bg-success rounded-3">
                        <a href="/kelola-masterSupplier" class="card-text text-warning">Go</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card bg-primary" style="width: 18rem; height: 10rem;">
                <div class="card-body text-center">
                    <h5 class="fs-5">Kelola Data Kategori</h5>
                    <div class="container bg-success rounded-3">
                        <a href="/kelola-masterKategori" class="card-text text-warning">Go</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card bg-primary" style="width: 18rem; height: 10rem;">
                <div class="card-body text-center">
                    <h5 class="fs-5">Kelola Data Part</h5>
                    <div class="container bg-success rounded-3">
                        <a href="/kelola-masterPart" class="card-text text-warning">Go</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card bg-primary" style="width: 18rem; height: 10rem;">
                <div class="card-body text-center">
                    <h5 class="fs-5">Kelola Data Standar</h5>
                    <div class="container bg-success rounded-3">
                        <a href="/kelola-masterStandar" class="card-text text-warning">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
