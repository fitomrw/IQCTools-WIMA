@extends ('layouts.main')

@section ('container')


        <!-- @if(session()->has('success'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif -->

<div class="container-fluid">
    <a href="dataPartIncoming/create">
        <button type="button" class="btn btn-primary d-block mb-3"> Tambah Part Incoming</button>
    </a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode Part</th>
                <th scope="col">Nama Part</th>
                <th scope="col">Kategori Part</th>
                <th scope="col">Supplier</th>
                <th scope="col">Jumlah Barang Masuk</th>
                <th scope="col">Jumlah Pengecekan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($dataPartIncomings as $data_barang)    
        <tr>
            
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $data_barang->kode_part }}</td>
                <td>{{ $data_barang->part->nama_part }}</td>
                <td>{{ $data_barang->part->kategori_part->nama_kategori }}</td>
                <td>{{ $data_barang->part->supplier->nama_supplier }}</td>
                <td>{{ $data_barang->jumlah_kirim }}</td>
                <td>{{ $data_barang->jumlah_cek }}</td>
                <td>
                        <div class="btn-group btn-group-sm">
                            <a href="/dataPartIncoming/{{ $data_barang->id_part_supply }}/edit" class="btn btn-info"><i class="fas fa-eye"></i></a>
                            <form action="/dataPartIncoming/{{ $data_barang->id_part_supply }}" method="get">
                                @csrf
                                @method('DELETE')
                                <a href="/dataPartIncoming/{{ $data_barang->id_part_supply }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </form>
                            
                        </div>
                </td>
            
        </tr>
        @endforeach
    </tbody>
    </table>
</div>

@endsection