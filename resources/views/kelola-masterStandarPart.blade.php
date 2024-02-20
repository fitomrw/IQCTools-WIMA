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

  {{-- <a href="/kelola-masterPart/create">
    <button type="button" class="btn btn-primary d-block mb-3">Tambah Data Part</button>
  </a> --}}
    <table class="table datatable">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Kode Part</th>
            <th scope="col">Nama Part</th>
            <th scope="col">Aksi</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($part as $p)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $p->kode_part }}</td>
            <td>{{ $p->nama_part }}</td>

            <td><a class="btn btn-warning" href="/kelola-masterStandarPart/edit/{{ $p->kode_part }}" role="button">Edit</a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
</div>
<script>
  $(document).ready(function() {
      $('.datatable').DataTable();
  });
</script>
@endsection