@extends ('layouts.main')

@section('container')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('danger'))
            <div class="alert alert-success">
                {{ session('danger') }}
            </div>
        @endif
        <div class="row">
            <form action="/tambahStandarPart/{{ $part->kode_part }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-3">
                        <strong>Tambah Jenis Standar</strong>
                        <select class="form-select" id="rincian_standar" name="rincian_standar">
                            <option selected></option>
                            <option value="VISUAL">VISUAL</option>
                            <option value="DIMENSI">DIMENSI</option>
                            <option value="FUNCTION">FUNCTION</option>
                        </select>
                    </div>
                    <div class="col-3 d-inline-block">
                        <strong>Tambah Rincian Standar</strong>
                        <select class="form-select" id="jenis_standar" name="jenis_standar">
                            <option selected></option>
                            @foreach ($dataStandar as $item)
                                <option value="{{ $item->id_standar }}">{{ $item->uraian }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-success  ml-3 my-auto">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <th>No</th>
                        <th>Jenis Standar</th>
                        <th>Alat</th>
                        <th>Uraian</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($standar as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->standar->jenis_standar }}</td>
                                <td>{{ $item->standar->alat }}</td>
                                <td>{{ $item->standar->uraian }}</td>
                                <td>
                                    <form action="/kelola-masterStandarPart/delete/{{ $item->id_standar_part }}" method="get">
                                        @csrf
                                        @method('DELETE')
                                        <a href="/kelola-masterStandarPart/delete/{{ $item->id_standar_part }}" class="btn btn-danger">Delete</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#rincian_standar').change(function() {
                var rincianStandar = $(this).val();
                $.ajax({
                    url: '/kelola-masterStandarPart/getJenisStandarPart/' + rincianStandar,
                    type: 'GET',
                    datatype: 'json',
                    success: function(response) {
                        console.log(response);
                        var inputRincianStandar =
                            '<option value="">--Pilh Rincian Standar--</option>';
                        $.each(response, function(key, value) {
                            inputRincianStandar += '<option value="' + value
                                .id_standar + '">' + value.uraian + '</option>';
                        });
                        $('#jenis_standar').html(inputRincianStandar);
                    }
                })
            })
        })
    </script>
@endsection
