@extends('layouts.main')

@section('container')
<div class="container">
    <a href="/kelola-LPP/create">
        <button type="button" class="btn btn-primary d-block mb-3">Buat LPP</button>
    </a>
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="text-center">No</th>
          <th scope="col" class="text-center">Problem</th>
          <th scope="col" class="text-center">Kode Part</th>
          <th scope="col" class="text-center">Status</th>
          <th scope="col" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($laporan as $lp)   
        <tr>
          <th scope="row" class="text-center">{{ $loop->iteration }}</th>
          <td class="text-center">
            <a href="/kelola-LPP/show/{{ $lp->id }}">
            {{ $lp->problem_description }}
            </a>
          </td>
          <td class="text-center">{{ $lp->part_code }}</td>
          <td class="text-center">
            <label class="btn {{ ($lp->status == 0) ? 'btn-danger' : 'btn-success' }}">
            {{ ($lp->status == 0) ? 'Belum Verifikasi' : 'Sudah Verifikasi' }}
            </label>
          </td>
          <td class="text-center">
            <a class="btn btn-warning" href="/kelola-LPP/edit/{{ $lp->id }}" role="button">Edit</a>
            <form action="/kelola-LPP/destroy/{{ $lp->id }}" method="post" class="d-inline">
              <a class="btn btn-danger" href="/kelola-LPP/destroy/{{ $lp->id }}" role="button">Delete</a>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

</div>
@endsection