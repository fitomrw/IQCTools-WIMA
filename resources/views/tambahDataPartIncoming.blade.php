@extends ('layouts.main')

@section('container')
    <div class="container-fluid">
        <form id="formDataPartIncoming" action = "/dataPartIncoming" method="POST">
            @csrf
            <div class="row">
                <div class="col lg-5 d-inline-block ml-2">
                    <div class="form-group">
                        <label for="supply_date">Tanggal Supply</label>
                        <input type="date" id="supply_date" name="supply_date" class="d-block" required>
                    </div>
                    <label for="kategori_id">Kategori Part</label>
                    <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id"
                        name="kategori_id" autofocus required>
                        <option selected></option>
                        @foreach ($kategori_part as $k_part)
                            <option value="{{ $k_part->id_kategori }}"> {{ $k_part->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
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
                        <option></option>
                    </select>
                </div>
            </div>

            <div class="col lg-5 d-inline-block">
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

                    <div class="form-group">
                        <label for="supplier_id">Supplier</label>
                        <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id"
                            name="supplier_id" required>
                            <option selected></option>
                            @foreach ($suppliers as $supp)
                                <option value="{{ $supp->id_supplier }}">{{ $supp->nama_supplier }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="form-group">
                    <label for="jumlah_kirim">Jumlah Barang Masuk</label>
                    <input type="text" class="form-control @error('jumlah_kirim') is-invalid @enderror" id="jumlah_kirim"
                        name="jumlah_kirim" placeholder="Jumlah Barang Masuk" required value="{{ old('jumlah_kirim') }}">

                    @error('jumlah_kirim')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <strong>Inspection Level</strong>
                <div class="form-group">
                    <label class="form-check-label" for="inspection_level">
                        <select class="form-select" name="inspection_level">
                            <option selected></option>
                            <option value="S-I">S-I</option>
                            <option value="S-II">S-II</option>
                            <option value="S-III">S-III</option>
                            <option value="S-IV">S-IV</option>
                        </select>
                    </label>
                </div>

                <input type="hidden" name="aql_number" value="1">
            </div>

            <input type="hidden" name="status_pengecekan" id="status_pengecekan" value="1">
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // AJAX pertama
            $('#kategori_id').change(function() {
                var kategoriPart = $(this).val();
                $.ajax({
                    url: '/dataPartIncoming/getBarang' + '/' + kategoriPart,
                    type: 'GET',
                    datatype: 'json',
                    success: function(response) {
                        var KodeParts = '<option value="">-- Masukkan Kode Part --</option>';
                        $.each(response, function(key, value) {
                            KodeParts += '<option value="' + value.kode_part + '">' + value.kode_part + '</option>';
                        });
                        $('#kode_part').html(KodeParts);
                    }
                });
            });

            // AJAX kedua
            $('#kode_part').change(function() {
                var kodePart = $(this).val();
                $.ajax({
                    url: '/dataPartIncoming/getNamaPart' + '/' + kodePart,
                    type: 'GET',
                    datatype: 'json',
                    success: function(response) {
                        var namaParts = '<option value="">-- Pilih Nama Part --</option>';
                        var suppliers = '<option value="">-- Pilih Supplier --</option>';
                        $.each(response, function(key, value) {
                            namaParts += '<option value="' + value.nama_part + '">' + value.nama_part + '</option>';
                            suppliers += '<option value="' + value.supplier_id + '">' + value.supplier.nama_supplier + '</option>';
                        });
                        $('#nama_part').html(namaParts);
                        $('#supplier_id').html(suppliers); // Perbaiki pemilihan elemen di sini
                    }
                });
            });
        });
    </script>
    
@endsection
