@extends('layouts.main')

@section('container')
<div class="container">
    <table class="table" id="table-verif">
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
        @foreach ($verifLaporan as $verif)   
        <tr>
          <th scope="row" class="text-center">{{ $loop->iteration }}</th>
          <td class="text-center">
            {{ $verif->problem_description }}
          </td>
          <td class="text-center">{{ $verif->part_code }}</td>
          <td class="text-center">
            <label class="btn {{ ($verif->status == 0) ? 'btn-danger' : 'btn-success' }}">
            {{ ($verif->status == 0) ? 'Belum Verifikasi' : 'Sudah Verifikasi' }}
            </label>
          </td>
          <td class="text-center">
            <form action="/kelola-LPP/verifLaporanShow/{{ $verif->id }}" method="post" class="d-inline">
              <a class="btn btn-warning" href="/kelola-LPP/verifLaporanShow/{{ $verif->id }}" role="button">Periksa</a>
            </form>
            <a href="/kelola-LPP/printLPP/{{ $verif->id }}" class="btn btn-primary" role="button">Print</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>

<script>
  var successVerif = localStorage.getItem("successVerif");

  if (successVerif > 0) {
    var tableVerif = document.getElementById("table-verif").getElementByTagName('tbody');
    tableVerif.innerHTML = '';
  }
</script>
@endsection