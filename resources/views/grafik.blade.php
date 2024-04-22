@extends('layouts.main')

@section('container')
    <div class="container">
        @if (auth()->user()->jabatan == "Kepala Seksi QC")
            <form action="/verifikasi-pengecekan/filterGrafik" method="post">
        @else
            <form action="/filterGrafik" method="post">
        @endif
            @csrf
            <div class="row mb-5 w-75 flow-reverse">

                <div class="col">
                    <label for="supplierFilter" class="form-label">Supplier</label>
                    <select class="form-select border border-dark" id="supplierFilter" name="supplierFilter">
                        <option selected></option>
                        @foreach ($getSupplier as $getSupp)
                            <option value="{{ $getSupp->id_supplier }}">{{ $getSupp->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="kategoriFilter" class="form-label">Kategori</label>
                    <select class="form-select border border-dark" id="kategoriFilter" name="kategoriFilter">
                        <option selected></option>
                        @foreach ($getKategori as $getKate)
                            <option value="{{ $getKate->id_kategori }}">{{ $getKate->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="bulanFilter" class="form-label">Bulan</label>
                    <select class="form-select border border-dark" id="bulanFilter" name="bulanFilter">
                        <option selected></option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col d-flex align-items-center">
                    <button class="btn btn-info mt-4">Filter</button>
                </div>
            </div>
        </form>
        <div class="row">
            @if ($supplier != 0 || $kategori != 0 || $bulan != 0)
                @php
                    $dataSupp = $getSupplier->where('id_supplier', $supplier)->first();
                    $dataKat = $getKate->where('id_kategori', $kategori)->first();
                @endphp
                @if ($supplier != 0 && $kategori == 0)
                    <span> <strong>Supplier :</strong> {{ $dataSupp->nama_supplier }} | <strong>Kategori :</strong>
                        {{ $dataKat }} |
                        <strong>Bulan
                            :</strong> {{ $bulanForView }}
                    </span>
                @elseif($supplier == 0 && $kategori != 0)
                    <span> <strong>Supplier :</strong> {{ $dataSupp }} | <strong>Kategori :</strong>
                        {{ $dataKat->nama_kategori }} |
                        <strong>Bulan
                            :</strong> {{ $bulanForView }}
                    </span>
                @elseif($supplier != 0 && $kategori != 0)
                    <span> <strong>Supplier :</strong> {{ $dataSupp->nama_supplier }} | <strong>Kategori :</strong>
                        {{ $dataKat->nama_kategori }} |
                        <strong>Bulan
                            :</strong> {{ $bulanForView }}
                    </span>
                @endif
            @else
                <span> <strong>Supplier :</strong> 0 | <strong>Kategori :</strong> 0 | <strong>Bulan
                        :</strong> {{ $bulanForView }}
                </span>
            @endif
        </div>
        <div class="row w-100"><canvas id="myChart" width="400" height="400"></canvas></div>
    </div>
    @if (auth()->user()->jabatan == 'Kepala Seksi QC')
        <div class="container-fluid">
            @if (session('notify'))
                <div class="alert alert-success">
                    {{ session('notify') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th rowspan="3">No</th>
                                    <th rowspan="3">Kode Part</th>
                                    <th rowspan="3">Nama Part</th>
                                    <th rowspan="3">Jumlah Pengiriman</th>
                                    <th rowspan="3">Tanggal Pengiriman</th>
                                    <th rowspan="3">Status Verifikasi</th>
                                    <th rowspan="1" colspan="2" class="text-center">Hasil Cek</th>
                                    <th rowspan="3">Aksi</th>
                                </tr>
                                <tr>
                                    <th rowspan="1">OK</th>
                                    <th rowspan="1">NG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->kode_part }}</td>
                                        <td>{{ $item->part->nama_part }}</td>
                                        <td>{{ $item->jumlah_kirim }}</td>
                                        @if ($item->status_pengecekan == 1)
                                            <td>
                                                <p class="bg-primary p-1 rounded-1 text-center"><b>Menunggu
                                                        Verifikasi</b></p>
                                            </td>
                                        @elseif($item->status_pengecekan == 2)
                                            <td>
                                                <p class="bg-success p-1 rounded-1 text-center"><b>Sudah Verifikasi</b>
                                                </p>
                                            </td>
                                        @endif
                                        <td>{{ $item->supply_date }}</td>
                                        <td>{{ $countedNG }}</td>
                                        <td>{{ $countedOK }}</td>
                                        <td><a
                                                href="/verifikasi-pengecekan/verifPengecekanShow/{{ $item->id_part_supply }}/{{ $item->kode_part }}"><button
                                                    class="btn btn-info"><i class="fas fa-eye"></i></button></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- @if (auth()->user()->jabatan == 'Kepala Seksi QC')
        @include('verifikasiPengecekan');    
    @endif --}}

    <script>
        $.ajax({
            url: '/api/kelola-LPP/grafik/{{ $supplier }}/{{ $kategori }}/{{ $bulan }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Handle the data returned from the server
                console.log(response);
                console.log(response[0]);
                console.log(response[1][0]);
                console.log(response[2][0]);
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response[0],
                        datasets: [{
                            label: 'NG Part',
                            // data: [12, 19, 3, 5, 2, 3],
                            data: response[1],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                // 'rgba(54, 162, 235, 0.2)',
                                // 'rgba(255, 206, 86, 0.2)',
                                // 'rgba(75, 192, 192, 0.2)',
                                // 'rgba(153, 102, 255, 0.2)',
                                // 'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                // 'rgba(54, 162, 235, 1)',
                                // 'rgba(255, 206, 86, 1)',
                                // 'rgba(75, 192, 192, 1)',
                                // 'rgba(153, 102, 255, 1)',
                                // 'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }, {
                            label: 'OK Part',
                            // data: [12, 19, 3, 5, 2, 3],
                            data: response[2],
                            backgroundColor: [
                                // 'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                // 'rgba(255, 206, 86, 0.2)',
                                // 'rgba(75, 192, 192, 0.2)',
                                // 'rgba(153, 102, 255, 0.2)',
                                // 'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                // 'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                // 'rgba(255, 206, 86, 1)',
                                // 'rgba(75, 192, 192, 1)',
                                // 'rgba(153, 102, 255, 1)',
                                // 'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    // beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    </script>
@endsection
