@extends ('layouts.main')

@section('container')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="/kelola-masterKategori/create">
            <button type="button" class="btn btn-primary d-block mb-3">Tambah Data Kategori</button>
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategories as $kats)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $kats->nama_kategori }} </td>
                        <td>
                            <a class="btn btn-warning" href="/kelola-masterKategori/edit/{{ $kats->id_kategori }}"
                                role="button">Edit</a>
                            <form action="/kelola-masterKategori/destroy/{{ $kats->id_kategori }}" method="post"
                                class="d-inline">
                                <a class="btn btn-danger" href="/kelola-masterKategori/destroy/{{ $kats->id_kategori }}"
                                    role="button">Delete</a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
