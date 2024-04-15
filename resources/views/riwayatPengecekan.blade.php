@extends ('layouts.main')

@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <th>No</th>
                            <th>Kode Part</th>
                            <th>Nama Part</th>
                            <th>Jumlah Pengiriman</th>
                            <th>Tanggal Pengiriman</th>
                            <th>Status Verifikasi</th>
                            <th colspan="2">Status Penerimaan</th>
                            <th>Aksi</th>
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
                                    <td>{{ $item->supply_date }}</td>
                                    @if ($item->status_pengecekan == 1)
                                        <td>
                                            <p class="bg-primary p-1 rounded-1 text-center"><b>Menunggu Verifikasi</b></p>
                                        </td>
                                    @elseif($item->status_pengecekan == 0)
                                        <td>
                                            <p class="bg-danger p-1 rounded-1 text-center"><b>Belum Dicek</b></p>
                                        </td>
                                    @elseif($item->status_pengecekan == 2)
                                        <td>
                                            <p class="bg-success p-1 rounded-1 text-center"><b>Sudah Verifikasi</b></p>
                                        </td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    <td><a href="/detailPengecekan/{{ $item->id_part_supply }}/{{ $item->kode_part }}"><button
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
        });
    </script>
    {{-- @endpush --}}
@endsection
