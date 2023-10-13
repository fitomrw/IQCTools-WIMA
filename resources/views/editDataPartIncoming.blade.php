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
            <div class="col lg-5 d-inline-block mt-50">
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

            <div class="form-group w-50">
                <label for="jumlah_kirim">Jumlah Barang Masuk</label>
                <input type="text" class="form-control @error ('jumlah_kirim') is-invalid @enderror" id="jumlah_kirim" name="jumlah_kirim" placeholder="Jumlah Barang Masuk" value="{{ old('jumlah_kirim', $dataPartIncoming->jumlah_kirim) }}">

                @error ('jumlah_kirim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group w-50">
                <label for="jumlah_cek">Jumlah Yang Ingin Di Cek</label>   
                <input type="text" class="form-control @error ('jumlah_cek') is-invalid @enderror" id="jumlah_cek" name="jumlah_cek" placeholder="Jumlah Yang Ingin Di Cek" required value="{{ old('jumlah_cek', $dataPartIncoming->jumlah_cek)  }}">

                @error ('jumlah_cek')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <strong>Checksheet Supplier</strong>

            <div class="form-check w-50">
                <label class="form-check-label"></label>
                <select class="form-select" name="checksheet_supplier">
                    <option selected></option>
                    <option value="Ada" {{ ($dataPartIncoming->checksheet_supplier == "Ada") ? 'selected' : ''}}>Ada </option>
                    <option value="Tidak Ada" {{ ($dataPartIncoming->checksheet_supplier == "Tidak Ada") ? 'selected' : ''}}>Tidak Ada</option>
                  </select>
                </div>
                {{-- <input class="form-check-input" type="radio" name="checksheet_supplier" id="checksheet_supplier" value="{{ ($dataPartIncoming == 'Ada') ? 'checked' : '' }}" >  --}}
                
            {{-- <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="checksheet_supplier" id="checksheet_supplier" value="{{ ($dataPartIncoming == 'Tidak Ada') ? 'checked' : '' }}">
                <label class="form-check-label" for="checksheet_supplier">
                   Tidak Ada
                </label>
            </div>
            <
            </div> --}}
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
        </form>
    </div>
</div>
        
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