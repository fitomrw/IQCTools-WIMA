@extends ('layouts.main')

@section ('container')
<div class="container-fluid">
  <a href="/kelola-masterSupplier/create">
    <button type="button" class="btn btn-primary d-block mb-3">Tambah Data Supplier</button>
  </a>
    @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
      <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Supplier</th>
              <th scope="col">Alamat</th>
              <th scope="col">No Telepon</th>
              <th scope="col">Email</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>

            @foreach($suppliers as $supp)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $supp->nama_supplier }}</td>
              <td>{{ $supp->alamat }}</td>
              <td>{{ $supp->no_telepon }}</td>
              <td>{{ $supp->email }}</td>
              <td>
                <a class="btn btn-warning" href="/kelola-masterSupplier/edit/{{ $supp->id_supplier}}" role="button">Edit</a>
                <form action="/kelola-masterSupplier/destroy/{{ $supp->id_supplier }}" method="post" class="d-inline"> 
                  @csrf
                  @method('DELETE')
                  <a class="btn btn-danger" href="/kelola-masterSupplier/destroy/{{ $supp->id_supplier }}" role="button">Delete</a>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection