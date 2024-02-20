@extends ('layouts.main')

@section ('container')
<div class="container-fluid">
  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif

  @if (session('delete'))
    <div class="alert alert-danger">
        {{ session('delete') }}
    </div>
  @endif

  <a href="/kelola-masterPart/create">
    <button type="button" class="btn btn-primary d-block mb-3">Tambah Data Part</button>
  </a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Part</th>
            <th scope="col">Kode Part</th>
            <th scope="col">Kategori</th>
            <th scope="col">Supplier</th>
            <th scope="col">Gambar</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($part as $p)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $p->nama_part }}</td>
            <td>{{ $p->kode_part }}</td>
            <td>{{ $p->kategori_part->nama_kategori }}</td>
            <td>{{ $p->supplier->nama_supplier }}</td>
            <td>{{ $p->gambar_part }}</td>
            <td><a class="btn btn-warning" href="/kelola-masterPart/edit/{{ $p->kode_part }}" role="button">Edit</a>
              <form action="/kelola-masterPart/destroy/{{ $p->kode_part }}" method="post" class="d-inline">
                <a class="btn btn-danger" href="/kelola-masterPart/destroy/{{ $p->kode_part }}" role="button">Delete</a>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
</div>
@endsection