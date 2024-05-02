@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <table class="table" id="table-verif">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Problem</th>
                    <th scope="col" class="text-center">Kode Part</th>
                    <th scope="col" class="text-center">Nama Part</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">PIC</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($verifLaporan as $verif)
                    <tr>
                        <td scope="row" class="text-center">{{ $loop->iteration }}</th>
                        <td class="text-center">{{ $verif->problem_description }}</td>
                        <td class="text-center">{{ $verif->part_code }}</td>
                        <td class="text-center">{{ $verif->part->nama_part }}</td>
                        <td class="text-center">
                            <label
                                class="{{ $verif->status == 0 ? 'bg-danger p-2 m-1 rounded-1' : 'bg-success p-2 m-1 rounded-1' }}">
                                {{ $verif->status == 0 ? 'Belum Verifikasi' : 'Sudah Verifikasi' }}
                            </label>
                        </td>
                        <td class="text-center">{{ auth()->user()->name }}</td>
                        <td class="text-center">
                            <div class="container-sm">
                                <form action="/kelola-LPP/verifLaporanShow/{{ $verif->id }}" method="post"
                                    class="d-block">
                                    <a class="btn btn-warning" href="/kelola-LPP/verifLaporanShow/{{ $verif->id }}"
                                        role="button">Periksa</a>
                                </form>
                                <a href="/kelola-LPP/printLPP/{{ $verif->id }}" class="btn btn-primary mt-2"
                                    role="button">Print</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <script>
            // $(document).ready(function() {
            //     $('.datatable').DataTable();
            // });

            // document.addEventListener("DOMContentLoaded", function() {
            //     const supplierFilter = document.getElementById('supplierFilter');
            //     const kategoriFilter = document.getElementById('kategoriFilter');
            //     const ctx = document.getElementById('LPPChart').getContext('2d');

            //     function fetchDataWithFilter() {
            //         const selectedSupplier = supplierFilter.value;
            //         const selectedKategori = kategoriFilter.value;
            //         fetch(
            //                 `/kelola-LPP/getDataLPP?supplier=${selectedSupplier}&kategori=${selectedKategori}`
            //             )
            //             .then(response => {
            //                 if (!response.ok) {
            //                     throw new Error('Gagal mengambil data dari server');
            //                 }
            //                 return response.json();
            //             })
            //             .then(filteredChart => {
            //                 console.log(data);
            //                 let labels;
            //                 if (selectedSupplier) {
            //                     labels = filteredChart.filter(lpp => lpp.to === selectedSupplier).map(lpp => lpp.to
            //                         .nama_part)
            //                 } else if (selectedKategori) {
            //                     labels = filteredChart.filter(lpp => lpp.model === selectedKategori).map(lpp => lpp
            //                         .part
            //                         .nama_part)
            //                 }
            //                 // console.log(total_quantity);
            //                 // let amounts = data.map(lpp => lpp.total_quantity);
            //                 let amounts;
            //                 if (selectedSupplier) {
            //                     amounts = data.filter(lpp => lpp.to === selectedSupplier).map(lpp => parseInt(lpp
            //                         .total_quantity))
            //                 } else if (selectedKategori) {
            //                     amounts = data.filter(lpp => lpp.model === selectedKategori).map(lpp => parseInt(lpp
            //                         .total_quantity))
            //                 }

            //                 updateChart(labels, amounts);
            //             })
            //             .catch(error => {
            //                 console.error('Error fetching data:', error);
            //                 // Tampilkan pesan kesalahan kepada pengguna
            //                 // Misalnya, dengan menambahkan elemen HTML atau memperbarui elemen yang sudah ada di tampilan
            //             });
            //     }

            //     function updateChart(labels, amounts) {
            //         if (window.myChart) {
            //             window.myChart.destroy();
            //         }

            //         window.myChart = new Chart(LPPChart, {
            //             type: "bar",
            //             data: {
            //                 labels: labels,
            //                 datasets: [{
            //                     label: 'Jumlah Laporan Penyimpangan Part',
            //                     data: amounts,
            //                     backgroundColor: '#EA8F28',
            //                 }]
            //             },
            //             options: {
            //                 legend: {
            //                     display: false
            //                 }
            //                 // scales: {
            //                 //     yAxes: [{
            //                 //         ticks: {
            //                 //             beginAtZero: true,
            //                 //             stepSize: 1
            //                 //         }
            //                 //     }]
            //                 // }
            //             }
            //         });
            //     }

            //     supplierFilter.addEventListener('change', fetchDataWithFilter);
            //     kategoriFilter.addEventListener('change',
            //         fetchDataWithFilter);

            //     fetchDataWithFilter();
            // });
        </script>
    @endsection
