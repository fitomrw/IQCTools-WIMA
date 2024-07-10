@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <table class="table" id="table-verif">
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
                @foreach ($verifLaporan as $verif)
                    <tr>
                        <td scope="row" class="text-center">{{ $loop->iteration }}</th>
                        <td class="text-center">{{ $verif->problem_description }}</td>
                        <td class="text-center">{{ $verif->part_code }}</td>
                        <td class="text-center">{{ $verif->part->nama_part }}</td>
                        <td class="text-center">
                            <label
                                class="{{ $verif->status == 0 ? 'bg-danger p-2 m-1 rounded-1' : 'bg-success p-2 m-1 rounded-1' }}">
                                {{ $verif->status == 0 ? 'Belum Verifikasi' : 'Sudah Verifikasi' }}
                            </label>
                        </td>
                        <td class="text-center">{{ $verif->pic->name}}</td>
                        <td class="text-center">
                            <div class="container-sm">
                                <form action="/kelola-LPP/verifLaporanShow/{{ $verif->id }}" method="post"
                                    class="d-block">
                                    <a class="btn btn-warning" href="/kelola-LPP/verifLaporanShow/{{ $verif->id }}"
                                        role="button">Periksa</a>
                                </form>
                                <a href="/kelola-LPP/printLPP/{{ $verif->id }}" class="btn btn-primary mt-2"
                                    role="button">Print</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
