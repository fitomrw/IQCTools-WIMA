@extends('layouts.main')

@section('container')
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
                  <th>OK</th>
                  <th>NG</th>
                  <th>AKSI</th>
              </thead>
              <tbody>
                  @php
                   $no = 1;   
                  @endphp
                <td>{{ $no++ }}</td>
                <td>D11501</td>
                <td>Hinge Cushion</td>
                <td>50</td>
                <td>
                    <label class="btn btn-danger">
                        Belum Verifikasi
                    </label>
                </td>
                <td>2023-10-10</td>
                <td>5</td>
                <td>5</td>
                <td>
                    <a class="btn btn-warning" href="/verifikasi-pengecekan/VerifPengecekanShow">Periksa</a>
                </td>
              </tbody>
          </table>
         </div>
      </div>
  </div>
</div>
@endsection