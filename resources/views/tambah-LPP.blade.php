@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-secondary"></div>
            <div class="card-body">
                <form action="/kelola-LPP/store" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="to" class="form-label">To</label>
                        <select class="form-select" name="to" id="to">
                            <option selected></option>
                            @foreach ($suppliers as $sup)
                                <option value="{{ $sup->id_supplier }}">{{ $sup->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="attention" class="form-label">Attention</label>
                        <input type="text" class="form-control" name="attention" id="attention">
                    </div>
                    <div class="mb-3">
                        <label for="cc" class="form-label">CC</label>
                        <input type="text" class="form-control" name="cc" id="cc">
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <select class="form-select" name="model" id="model">
                            <option selected></option>
                            @foreach ($model_kategori as $mk)
                                <option value="{{ $mk->id_kategori }}">{{ $mk->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="part_name" class="form-label">Part Name</label>
                        <select class="form-select" name="part_name" id="part_name">
                            <option selected></option>
                            <option value=""></option>
                            {{-- @foreach ($part as $p)
                        <option value="{{ $p->nama_part }}">{{ $p->nama_part }}</option>
                        @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="part_code" class="form-label">Part Code</label>
                        <select class="form-select" name="part_code" id="part_code">
                            <option selected></option>
                            <option value=""></option>
                            {{-- @foreach ($part as $p)
                        <option value="{{ $p->kode_part }}">{{ $p->kode_part }}</option>
                        @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="found_date" class="form-label">Found Date</label>
                        <input type="date" id="found_date" name="found_date" class="d-block form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="issue_date" class="form-label">Issue Date</label>
                        <input type="date" id="issue_date" name="issue_date" class="d-block form-control"
                            value="{{ $getIssueDate }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity">
                    </div>
                    <div class="mb-3">
                        <label for="problem_description" class="form-label">Problem Description</label>
                        <textarea class="form-control" id="problem_description" rows="5" name="problem_description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="found_area" class="form-label">Found Area</label>
                        <select class="form-select" name="found_area" id="found_area">
                            <option selected></option>
                            <option value="On Customer">On Customer</option>
                            <option value="On Factory">On Factory</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="request" class="form-label">Request</label>
                        <textarea class="form-control" id="request" rows="5" name="request"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Input Gambar</label>
                        <input class="form-control" type="file" id="formFile" name="gambar_lpp" required>
                    </div>

                    <input type="hidden" name="pic_person" value="{{ auth()->user()->id }}">
                    <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#model').change(function() {
                var modelPart = $(this).val();
                $.ajax({
                    url: '/kelola-LPP/getPartInfo/' + modelPart,
                    type: 'GET',
                    datatype: 'json',
                    success: function(response) {
                        var partName = '<option value=""></option>';
                        var partCode = '<option value=""></option>';
                        $.each(response, function(key, value) {
                            partName += '<option value="' + value.nama_part + '">' +
                                value.nama_part + '</option>';
                            partCode += '<option value="' + value.kode_part + '">' +
                                value.kode_part + '</option>';
                        });
                        $('#part_name').html(partName);
                        $('#part_code').html(partCode);
                    }
                })
            })
        })
    </script>
@endsection
