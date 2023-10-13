@extends ('layouts.main')

@section ('container')
    <div class="container-fluid">
        <form action = "/dataPartIncoming" method="POST">
        @csrf
        <div class="row">
        <div class="col lg-5 d-inline-block ml-2">
            <div class="form-group w-50">
            <label for="supply_date">Tanggal Supply</label>
            <input type="date" id="supply_date" name="supply_date" class="d-block">
            </div>
                <form action="/dataPartIncoming/getBarang" method="get"><div class="form-group w-50">
                    <label for="kategori_id">Kategori Part</label>
                    <select class="form-control @error ('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" autofocus required>
                    <option selected></option>
                    @foreach ($kategori_part as $k_part)
                    <option value="{{ $k_part->id_kategori }}"> {{ $k_part->nama_kategori }}</option>
                    @endforeach
                    </select>

                    @error ('kategori_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div></form>
                


                    <div class="form-group w-50">
                        <label for="supplier_id">Supplier</label>
                        <select class="form-control @error ('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id" required>
                        <option selected></option>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama_supplier }}</option>
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
                        <option></option>
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
                <input type="text" class="form-control @error ('jumlah_kirim') is-invalid @enderror" id="jumlah_kirim" name="jumlah_kirim" placeholder="Jumlah Barang Masuk" required value="{{ old('jumlah_kirim') }}">

                @error ('jumlah_kirim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group w-50">
                <label for="jumlah_cek">Jumlah Yang Ingin Di Cek</label>
                <input type="text" class="form-control @error ('jumlah_cek') is-invalid @enderror" id="jumlah_cek" name="jumlah_cek" placeholder="Jumlah Yang Ingin Di Cek" required value="{{ old('jumlah_cek') }}">

                @error ('jumlah_cek')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <strong>Checksheet Supplier</strong>

            <div class="form-check m-3">
                <label class="form-check-label" for="checksheet_supplier">
                    <select class="form-select" name="checksheet_supplier">
                        <option selected></option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                </label>
            </div>
            {{-- <div class="form-check mb-3">
                <label class="form-check-label" for="checksheet_supplier">
                <input class="form-check-input" type="radio" name="checksheet_supplier" id="checksheet_supplier" value="Tidak Ada">
                   Tidak Ada
                </label>
            </div> --}}
            <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
        </form>
    </div>
</div>
        
    </div>
    <script>
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
                        options += '<option value="' + value.nama_part + '">' + value.nama_part + '</option>';
                        KodeParts  += '<option value="' + value.kode_part + '">' + value.kode_part + '</option>';

                    });
                    // console.log(kode)
                    $('#kode_part').html(KodeParts);
                    $('#nama_part').html(options);
                }
            })
          })
        })
                            </script>
@endsection