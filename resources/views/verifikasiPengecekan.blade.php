@extends ('layouts.main')

@section('container')
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
                                            <p class="bg-primary p-1 rounded-1 text-center"><b>Menunggu Verifikasi</b></p>
                                        </td>
                                    @elseif($item->status_pengecekan == 2)
                                        <td>
                                            <p class="bg-success p-1 rounded-1 text-center"><b>Sudah Verifikasi</b></p>
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
    {{-- @push('scripts') --}}
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
            document.addEventListener("DOMContentLoaded", function() {
                const supplierFilter = document.getElementById('supplierFilter');
                const kategoriFilter = document.getElementById('kategoriFilter');
                const ctx = document.getElementById('KSChart').getContext('2d');

                function fetchDataWithFilter() {
                    const selectedSupplier = supplierFilter.value;
                    const selectedKategori = kategoriFilter.value;
                    fetch(
                            `/kelola-LPP/getDataLPP?supplier=${selectedSupplier}&kategori=${selectedKategori}`
                        )
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal mengambil data dari server');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data);
                            let labels;
                            if (selectedSupplier) {
                                labels = data.map(lpp => lpp.part_code)
                            } else if (selectedKategori) {
                                labels = data.map(lpp => lpp.model.kategori_part.nama_kategori)
                            }
                            const amounts = data.map(lpp => parseInt(lpp.quantity));

                            updateChart(labels, amounts);
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                            // Tampilkan pesan kesalahan kepada pengguna
                            // Misalnya, dengan menambahkan elemen HTML atau memperbarui elemen yang sudah ada di tampilan
                        });
                }

                function updateChart(labels, amounts) {
                    if (window.myChart) {
                        window.myChart.destroy();
                    }

                    window.myChart = new Chart(KSChart, {
                        type: "bar",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Laporan Penyimpangan Part',
                                data: amounts,
                                backgroundColor: '#EA8F28',
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        stepSize: 1
                                    }
                                }]
                            }
                        }
                    });
                }

                supplierFilter.addEventListener('change', fetchDataWithFilter);
                kategoriFilter.addEventListener('change', fetchDataWithFilter);

                fetchDataWithFilter();
            });
        });
    </script>
    {{-- @endpush --}}
@endsection
