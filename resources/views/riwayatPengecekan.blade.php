@extends ('layouts.main')

@section('container')
    <div class="container-fluid">
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
                                <th rowspan="3">Inspection Level</th>
                                <th rowspan="3">Status Verifikasi</th>
                                <th rowspan="1" colspan="2" class="text-center">Hasil Cek</th>
                                <th rowspan="3">Keputusan</th>
                                <th rowspan="3">Aksi</th>
                            </tr>
                            <tr>
                                <th rowspan="1" class="bg-success">OK</th>
                                <th rowspan="1" class="bg-danger">NG</th>
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
                                    <td>{{ $item->supply_date }}</td>
                                    <td>{{ $item->inspection_level }}</td>
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
                                        
                                    @if (isset($countedOK[$item->id_part_supply]) && $countedOK[$item->id_part_supply]->where('final_status', 0) !== null)
                                        <td>{{ $countedOK[$item->id_part_supply]->where('final_status', 0)->count() }}</td>
                                    @else
                                        <td>0</td>
                                    @endif
                                    
                                    @if (isset($countedNG[$item->id_part_supply]) && $countedNG[$item->id_part_supply]->where('final_status', 1) !== null)
                                        <td>{{ $countedNG[$item->id_part_supply]->where('final_status', 1)->count() }}</td>
                                    @else
                                        <td>0</td>
                                    @endif

                                    @if (isset($keputusanDiterima[$item->id_part_supply]) && !$keputusanDiterima[$item->id_part_supply]->where('keputusan', 'Diterima')->isEmpty())
                                        <td>
                                            <p class="bg-success p-1 rounded-1 text-center"><b>Diterima</b></p>
                                        </td>
                                    @elseif(isset($keputusanDitolak[$item->id_part_supply]) && !$keputusanDitolak[$item->id_part_supply]->where('keputusan', 'Ditolak')->isEmpty())
                                        <td>
                                            <p class="bg-danger p-1 rounded-1 text-center"><b>Ditolak</b></p>
                                        </td>
                                    @else
                                        <td>
                                            <p class="bg-warning p-1 rounded-1 text-center"><b>Belum Diputuskan</b></p>
                                        </td>
                                    @endif
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
