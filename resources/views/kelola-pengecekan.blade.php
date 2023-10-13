@extends('layouts.main')

@section('container')

<div class="container-fluid">
    <a href="/kelola-pengecekan/create">
        <button type="button" class="btn btn-primary d-block mb-3">Buat Pengecekan Kategori</button>
      </a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col-span-4">Kode Part</th>
                    <th scope="col">Nama Part</th>
                    <th scope="col">Kategori Part</th>
                    <th scope="col">Jumlah Barang Masuk</th>
                    <th scope="col">Jumlah Pengecekan</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>@fat</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                    <td>@twitter</td>
                    <td>@twitter</td>
                </tr>
            </tbody>
    </table>
</div> 
@endsection