@extends ('layouts.main')

@section ('container')
<div class="container-fluid">
  <a href="/kelola-masterStandar/create">
    <button type="button" class="btn btn-primary d-block mb-3">Tambah Data Standar</button>
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
              <th scope="col">Jenis Standar</th>
              <th scope="col">Alat</th>
              <th scope="col">Uraian</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
             $no = 1;   
            @endphp
            @foreach ($standar as $item)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $item->jenis_standar }}</td>
                  <td>{{ $item->alat }}</td>
                  <td>{{ $item->uraian }}</td>
                  <td class="d-flex">
                    <a class="btn btn-warning" href="/kelola-masterStandar/edit/{{ $item->id_standar }}" role="button">Edit</a>

                    <form action="/kelola-masterStandar/destroy/{{ $item->id_standar }}" method="post">
                    @csrf
                    @method('DELETE')
                    <a class="btn btn-danger ml-2" href="/kelola-masterStandar/destroy/{{ $item->id_standar }}" role="button">Delete</a>
                    </form>
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection