@extends('layouts.main')
@section('container')
<div class="container-fluid">
    <a class="btn btn-primary mb-2" href="/kelola-standarMIL/create">Tambah Data Standar MIL 105 STD E</a>
    @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
    <table class="table">
        <thead class="text-center">
        @php    
        $no = 1;
        @endphp
        <tr>
            <th scope="col">No</th>
            <th scope="col">Minimal Sample</th>
            <th scope="col">Maximal Sample</th>
            <th scope="col">Size Code</th>
            <th scope="col">Sample Size</th>
            {{-- <th scope="col">Limit NG</th> --}}
            <th scope="col">Aksi</th>
        </tr>
        </thead>
        <tbody class="text-center">
        @foreach ($standarMIL as $stdMIL)
        <tr>
            <th scope="row">{{ $no++ }}</th>
            <td>{{ $stdMIL->min_sample }}</td>
            <td>{{ $stdMIL->max_sample }}</td>
            <td>{{ $stdMIL->size_code }}</td>
            <td>{{ $stdMIL->sample_size }}</td>
            {{-- <td>{{ $stdMIL->limit_ng }}</td> --}}
            <td>
                <a class="btn btn-warning" href="/kelola-standarMIL/edit/{{ $stdMIL->id }}">Edit</a>
            <form action="/kelolaDataMIL/destroy/{{             $stdMIL->id }}" method="post">
                @csrf
                @method('DELETE')
                <a class="btn btn-danger" href="/kelola-standarMIL/destroy/{{ $stdMIL->id }}" id="delete_button">Delete</a>
            </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <script>
    // $(document).ready( function () {
    // $('#myTable').DataTable();
    // } );
    document.getElementById("delete_button").addEventListener("click", function(){
        alert('Apakah Anda Yakin Ingin Menghapus Data?'))
    });
    </script>
</div>
@endsection