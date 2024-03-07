@extends ('layouts.main')

@section('container')
    <div class="container-fluid">
        <form action = "/dataPartIncoming/{{ $dataPartIncoming->id_part_supply }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col lg-5 d-inline-block ml-2">
                    <div class="form-group">
                        <label for="supply_date">Tanggal Supply</label>
                        <input type="date" id="supply_date" name="supply_date" class="d-block"
                            value="{{ $dataPartIncoming->supply_date }}">
                    </div>
                    {{-- {{ $dataPartIncoming->part->kategori_part->nama_kategori }} --}}
                    <form action="/dataPartIncoming/getBarang" method="get">
                        <div class="form-group">
                            <label for="kategori_id">Kategori Part</label>
                            <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                name="kategori_id" autofocus required>

                                @foreach ($kategori_part as $k_part)
                                    <option value="{{ $k_part->id_kategori }}"
                                        @if ($dataPartIncoming->kategori_id == $k_part->id_kategori) selected @endif> {{ $k_part->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>

                            @error('kategori_part')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                    </form>
                </div>


                <div class="form-group">
                    <label for="supplier_id">Supplier</label>
                    <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id"
                        name="supplier_id" required>
                        <option selected></option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id_supplier }}" @if ($supplier->id_supplier == $dataPartIncoming->part->supplier_id) selected @endif>
                                {{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>

                    @error('supplier_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror


                </div>

                <div class="form-group">
                    <label for="kode_part">Kode Part</label>
                    <select class="form-control @error('kode_part') is-invalid @enderror" id="kode_part" name="kode_part"
                        required>
                        <option selected></option>
                        <optgroup id="kode_part" label="kode_part">
                            <option></option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="nama_part">Nama Part</label>
                <select class="form-control @error('nama_part') is-invalid @enderror" id="nama_part" name="nama_part"
                    required>
                    <option selected></option>
                    <option value=""></option>
                </select>

                @error('nama_part')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group w-40">
                <label for="jumlah_kirim">Jumlah Barang Masuk</label>
                <input type="text" class="form-control @error('jumlah_kirim') is-invalid @enderror" id="jumlah_kirim"
                    name="jumlah_kirim" placeholder="Jumlah Barang Masuk"
                    value="{{ old('jumlah_kirim', $dataPartIncoming->jumlah_kirim) }}">

                @error('jumlah_kirim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <strong>Inspection Level</strong>
                <div class="form-group">
                    <label class="form-check-label" for="inspection_level">
                        <select class="form-select" name="inspection_level">
                            <option selected></option>
                            <option value="S-I" {{ $dataPartIncoming->inspection_level == 'S-I' ? 'selected' : '' }}>
                                S-I</option>
                            <option value="S-II" {{ $dataPartIncoming->inspection_level == 'S-II' ? 'selected' : '' }}>
                                S-II</option>
                            <option value="S-III" {{ $dataPartIncoming->inspection_level == 'S-III' ? 'selected' : '' }}>
                                S-III</option>
                            <option value="S-IV" {{ $dataPartIncoming->inspection_level == 'S-IV' ? 'selected' : '' }}>
                                S-IV</option>
                        </select>
                    </label>
                    <input type="hidden" name="aql_number" value="1">
                </div>
                <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>


    <script>
        let event_ = new Event('change')
        $(document).ready(function() {

            $('#kategori_id').change(function() {
                var kategoriPart = $(this).val();
                $.ajax({
                    url: '/dataPartIncoming/getBarang' + '/' + kategoriPart,
                    type: 'GET',
                    datatype: 'json',
                    success: function(response) {
                        var options = '<option value="">-- Pilih Nama Part --</option>';
                        var KodeParts = '<option value="">-- Masukkan Kode Part --</option>';
                        $.each(response, function(key, value) {
                            options +=
                                `<option value='${value.nama_part}' ${(value.kode_part == '{!! $dataPartIncoming->kode_part !!}' ? 'selected' : '')  } > ${value.nama_part} </option> `;
                            KodeParts +=
                                ` <option value='${value.kode_part}' ${(value.kode_part == '{!! $dataPartIncoming->kode_part !!}' ? 'selected' : '') } > ${value.kode_part} </option>`;

                        });
                        // console.log(kode)
                        $('#kode_part').html(KodeParts);
                        $('#nama_part').html(options);
                    }
                })
            })

            document.querySelector('#kategori_id').dispatchEvent(event_);
        })
    </script>
@endsection
