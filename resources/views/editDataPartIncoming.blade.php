@extends ('layouts.main')

@section ('container')
    <div class="container-fluid">
        <form action = "/dataPartIncoming/{{ $dataPartIncoming->id_part_supply }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
        <div class="col lg-5 d-inline-block ml-2">
            {{-- @dd($dataPartIncoming->kategori_id); --}}

            <div class="form-group w-50">
            <label for="supply_date">Tanggal Supply</label>
            <input type="date" id="supply_date" name="supply_date" class="d-block" value="{{ $dataPartIncoming->supply_date }}">
            </div>
            {{-- {{ $dataPartIncoming->part->kategori_part->nama_kategori }} --}}
                <form action="/dataPartIncoming/getBarang" method="get"><div class="form-group w-50">
                    <label for="kategori_id">Kategori Part</label>
                    <select class="form-control @error ('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" autofocus required>
                   
                    @foreach ($kategori_part as $k_part)
                    <option value="{{ $k_part->id_kategori }}" @if($dataPartIncoming->kategori_id == $k_part->id_kategori)
                         selected @endif> {{ $k_part->nama_kategori }}</option>
                    @endforeach
                    </select>

                    @error ('kategori_part')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </form>
        </div>
                

                    <div class="form-group w-50">
                        <label for="supplier_id">Supplier</label>
                        <select class="form-control @error ('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id" required>
                        <option selected></option>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id_supplier }}" @if($supplier->id_supplier == $dataPartIncoming->part->supplier_id) selected @endif>{{ $supplier->nama_supplier }}</option>
                        @endforeach
                        </select>

                        @error ('supplier_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror


                    </div>

                    <div class="form-group w-50">
                        <label for="kode_part">Kode Part</label>
                        <select class="form-control @error ('kode_part') is-invalid @enderror" id="kode_part" name="kode_part" required>
                        <option selected></option>
                        <optgroup id="kode_part" label="kode_part">
                            <option></option>
                        </optgroup>
                        </select>
                    </div>
            </div>
            
            <div class="form-group w-50">
                <label for="nama_part">Nama Part</label>
                <select class="form-control @error ('nama_part') is-invalid @enderror" id="nama_part" name="nama_part" required>
                <option selected></option>
                <option value=""></option>
                </select>

                @error ('nama_part')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        <div class="form-group w-40">
            <label for="jumlah_kirim">Jumlah Barang Masuk</label>
            <input type="text" class="form-control @error ('jumlah_kirim') is-invalid @enderror" id="jumlah_kirim" name="jumlah_kirim" placeholder="Jumlah Barang Masuk" value="{{ old('jumlah_kirim', $dataPartIncoming->jumlah_kirim) }}">

            @error ('jumlah_kirim')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <strong>Inspection Level</strong>
            <div class="form-check w-50 dropdownInspectionLevel">
                <label class="form-check-label" for="inspection_level">
                    <select class="form-select" name="inspection_level">
                        <option selected></option>
                        <option value="S-I" {{ ($dataPartIncoming->inspection_level == "S-I") ? 'selected' : ''}}>S-I</option>
                        <option value="S-II" {{ ($dataPartIncoming->inspection_level == "S-II") ? 'selected' : ''}}>S-II</option>
                        <option value="S-III" {{ ($dataPartIncoming->inspection_level == "S-III") ? 'selected' : ''}}>S-III</option>
                        <option value="S-IV" {{ ($dataPartIncoming->inspection_level == "S-IV") ? 'selected' : ''}}>S-IV</option>
                        <option value="G-I" {{ ($dataPartIncoming->inspection_level == "G-I") ? 'selected' : ''}}>G-I</option>
                        <option value="G-II" {{ ($dataPartIncoming->inspection_level == "G-II") ? 'selected' : ''}}>G-II</option>
                        <option value="G-III" {{ ($dataPartIncoming->inspection_level == "G-III") ? 'selected' : ''}}>G-III</option>
                    </select>
                </label>
            </div>

            <strong>AQL Number (in %)</strong>

            <div class="form-check w-100">
                <label class="form-check-label" for="aql_number">
                    <select class="form-select" name="aql_number">
                        <option selected></option>
                        <option value="0.065" {{ ($dataPartIncoming->aql_number == "0.065") ? 'selected' : ''}}>0.065</option>
                        <option value="0.1" {{ ($dataPartIncoming->aql_number == "0.065") ? 'selected' : ''}}>0.1</option>
                        <option value="0.15" {{ ($dataPartIncoming->aql_number == "0.15") ? 'selected' : ''}}>0.15</option>
                        <option value="0.25" {{ ($dataPartIncoming->aql_number == "0.25") ? 'selected' : ''}}>0.25</option>
                        <option value="0.4" {{ ($dataPartIncoming->aql_number == "0.4") ? 'selected' : ''}}>0.4</option>
                        <option value="1" {{ ($dataPartIncoming->aql_number == "1") ? 'selected' : ''}}>1</option>
                        <option value="1.5" {{ ($dataPartIncoming->aql_number == "1.5") ? 'selected' : ''}}>1.5</option>
                        <option value="2.5" {{ ($dataPartIncoming->aql_number == "2.5") ? 'selected' : ''}}>2.5</option>
                        <option value="4" {{ ($dataPartIncoming->aql_number == "4") ? 'selected' : ''}}>4</option>
                        <option value="6.5" {{ ($dataPartIncoming->aql_number == "6.5") ? 'selected' : ''}}>6.5</option>
                    </select>
                </label>
            </div>
        <button type="submit" class="btn btn-primary mt-4">Edit</button>
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
                    $.each(response, function (key, value) {
                        options += `<option value='${value.nama_part}' ${(value.kode_part == '{!! $dataPartIncoming->kode_part !!}' ? 'selected' : '')  } > ${value.nama_part} </option> `;
                        KodeParts  += ` <option value='${value.kode_part}' ${(value.kode_part == '{!! $dataPartIncoming->kode_part !!}' ? 'selected' : '') } > ${value.kode_part} </option>`;

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