@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
        <a href="/kelola-LPP/create">
            <button type="button" class="btn btn-primary d-block mb-3">Buat Laporan Penyimpangan Part</button>
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Problem</th>
                    <th scope="col" class="text-center">Kode Part</th>
                    <th scope="col" class="text-center">Nama Part</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">PIC</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $lp)
                    <tr>
                        <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                        <td class="text-center">{{ $lp->problem_description }}</td>
                        <td class="text-center">{{ $lp->part_code }}</td>
                        <td class="text-center">{{ $lp->part->nama_part }}</td>
                        <td class="text-center">
                            <label class="btn {{ $lp->status == 0 ? 'btn-danger' : 'btn-success' }}">
                                {{ $lp->status == 0 ? 'Belum Verifikasi' : 'Sudah Verifikasi' }}
                            </label>
                        </td>
                        {{-- @dd() --}}
                        <td class="text-center">{{ $lp->pic->name }}</td>
                        <td class="text-center">
                            <div class="container-sm">
                                <a class="btn btn-warning d-block mt-1" href="/kelola-LPP/edit/{{ $lp->id }}"
                                    role="button">Edit</a>
                                <a class="btn btn-info d-block mt-1" href="/kelola-LPP/laporanShow/{{ $lp->id }}"
                                    role="button">Lihat</a>
                                <form action="/kelola-LPP/destroy/{{ $lp->id }}" method="post" class="d-inline">
                                    <a class="btn btn-danger d-block mt-1" href="/kelola-LPP/destroy/{{ $lp->id }}"
                                        role="button">Delete</a>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
