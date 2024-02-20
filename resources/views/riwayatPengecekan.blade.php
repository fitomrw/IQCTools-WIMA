@extends ('layouts.main')

@section ('container')
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
                    <th>Status</th>
                    <th>Tanggal Pengiriman</th>
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
                            @if ($item->status_pengecekan != null)
                                <td>Sudah Dicek</td>  
                            @else
                                <td>Belum dicek</td>   
                            @endif        
                            
                            <td>{{ $item->supply_date }}</td>
                            <td><a href="/detailPengecekan/{{ $item->id_part_supply }}/{{ $item->kode_part }}"><button class="btn btn-info"><i class="fas fa-eye"></i></button></a></td>
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