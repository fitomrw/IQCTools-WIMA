@extends ('layouts.main')

@section('container')
    <div class="container-fluid border-top">
        <form id="tabelDetailPengecekan" action="/verifikasi-pengecekan/storeVerifikasiPengecekan/{{ $dataPartIn->id_part_supply }}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="col-2">
                    <div class="fs-5">Periksa Part</div>
                    <div class="fs-5">{{ $dataPartIn->part->nama_part }}</div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-4">
                    <img src="/img/img_part/{{ $dataPartIn->part->gambar_part }}" alt="Photo" style="max-width: 500px">
                </div>
            </div>
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Kode Part</td>
                            <td>: {{ $dataPartIn->kode_part }}</td>
                        </tr>
                        <tr>
                            <td>Supplier</td>
                            <td>: {{ $dataPartIn->supplier->nama_supplier }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-3">
                    <table class="table table-sm table-borderless">
                        <tr>
                            {{-- <td>Tanggal Periksa</td> --}}
                            @if ($dataPartIn->tanggal_pengecekan != null)
                                <label for="tanggal_periksa" class="form-label">Tanggal Pemeriksaan</label>
                                <td><input type="date" class="form-control" name="tanggal_periksa" id="tanggal_periksa"
                                        value="{{ $dataPartIn->tanggal_pengecekan }}" required></td>
                            @else
                                <label for="tanggal_periksa" class="form-label">Tanggal Pemeriksaan</label>
                                <td><input type="date" class="form-control" name="tanggal_periksa" id="tanggal_periksa"
                                        value="{{ $dataPartIn->supply_date }}" disabled></td>
                            @endif

                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <h3 class="text-center"><b>PEMERIKSAAN VISUAL</b></h3>
                @for ($i = 1; $i <= $jumlahTabel; $i++)
                    <div class="col-12 table-responsive">
                        <table id="tabelUtamaDetailPengecekan" class="table table-bordered mt-3" style="overflow-x:auto;">
                            <thead>
                                <tr>
                                    <th class="bg-warning">Sample ke-{{ $i }}</th>
                                    <th class="text-center border-3" colspan="7" style="background-color: darkgrey">
                                        VISUAL</th>
                                </tr>
                                <tr>
                                    <th class="text-center" rowspan="2">NO</th>
                                    <th class="text-center" rowspan="2">URAIAN</th>
                                    <th class="text-center" rowspan="1" colspan="2">STANDAR</th>
                                    <th class="text-center" rowspan="2">ALAT</th>
                                    <th class="text-center" rowspan="1" colspan="2">KESIMPULAN</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Spesifikasi</th>
                                    <th class="text-center">Toleransi</th>
                                    <th class="text-center">OK</th>
                                    <th class="text-center">NG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no1 = 1;
                                    // dd($cekVisual);
                                    // Filtering the array to get elements where id is greater than 1
                                    // $i = $i;
                                    $data = array_filter($verifCekVisual, function ($item) use ($i) {
                                        return $item['urutan_sample'] === $i; // Use strict comparison here
                                    });
                                    // dd($data);
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->standarPart->standar->uraian }}</td>
                                        <td colspan="2" class="text-center">{{ $item->standarPart->rincian_standar }}
                                        </td>

                                        <td>{{ $item->standarPart->standar->alat }}</td>
                                        @if ($item->status == null)
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="success-outlined{{ $item->id }} " autocomplete="off"
                                                    onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                <label class="btn btn-outline-success"
                                                    for="success-outlined{{ $item->id }} ">OK</label>
                                            </td>
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="danger-outlined{{ $item->id }}"
                                                    onclick="submitCek('NG',{{ $item->id }})" autocomplete="off" disabled>
                                                <label class="btn btn-outline-danger"
                                                    for="danger-outlined{{ $item->id }}">NG</label>
                                            </td>
                                        @elseif($item->status == 'OK')
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="success-outlined{{ $item->id }} " autocomplete="off" checked
                                                    onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                <label class="btn btn-outline-success"
                                                    for="success-outlined{{ $item->id }} ">OK</label>
                                            </td>
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="danger-outlined{{ $item->id }}"
                                                    onclick="submitCek('NG',{{ $item->id }})" autocomplete="off" disabled>
                                                <label class="btn btn-outline-danger"
                                                    for="danger-outlined{{ $item->id }}">NG</label>
                                            </td>
                                        @elseif($item->status == 'NG')
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="success-outlined{{ $item->id }} " autocomplete="off"
                                                    onclick="submitCek('OK',{{ $item->id }})" disabled> 
                                                <label class="btn btn-outline-success"
                                                    for="success-outlined{{ $item->id }} ">OK</label>
                                            </td>
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="danger-outlined{{ $item->id }}" checked
                                                    onclick="submitCek('NG',{{ $item->id }})" autocomplete="off" disabled>
                                                <label class="btn btn-outline-danger"
                                                    for="danger-outlined{{ $item->id }}">NG</label>
                                            </td>
                                        @endif
                                        {{-- <td>{{ $item->urutan_sample }}</td> --}}
                                    </tr>
                                    @php
                                        $no1++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endfor
            </div>
            <div class="row mt-2">
                <h3 class="text-center"><b>PEMERIKSAAN DIMENSI</b></h3>
                @for ($i = 1; $i <= $jumlahTabel; $i++)
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered" class="table table-bordered mt-3 datatable"
                            style="overflow-x:auto;">
                            <thead>
                                <tr>
                                    <th class="bg-warning" colspan="2">Sample ke-{{ $i }}</th>
                                    <th class="text-center border-3" colspan="8" style="background-color: darkgrey">
                                        DIMENSI</th>
                                </tr>
                                <tr>
                                    <th class="text-center" rowspan="3" style="width: 30px;">NO</th>
                                    <th class="text-center" rowspan="3" style="width: 30px;">POINT</th>
                                    <th class="text-center" rowspan="3">URAIAN</th>
                                    <th class="text-center" rowspan="1" colspan="3">STANDAR</th>
                                    <th class="text-center" rowspan="3">ALAT</th>
                                    <th class="text-center" rowspan="3" style="width: 150px;">INPUT VALUE</th>
                                    <th class="text-center" rowspan="2" colspan="2">KESIMPULAN</th>
                                </tr>
                                <tr>
                                    <th class="text-center" rowspan="2">Spesifikasi</th>
                                    <th class="text-center" colspan="2">Toleransi</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Max</th>
                                    <th class="text-center">Min</th>
                                    <th class="text-center">OK</th>
                                    <th class="text-center">NG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no1 = 1;
                                    // dd($cekVisual);
                                    // Filtering the array to get elements where id is greater than 1
                                    // $i = $i;
                                    $data = array_filter($verifCekDimensi, function ($item) use ($i) {
                                        return $item['urutan_sample'] === $i; // Use strict comparison here
                                    });
                                    // dd($data);
                                @endphp
                                @foreach ($data as $item)
                                    {{-- @dd($cekDimensi) --}}
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->standarPart->point }}</td>
                                        <td>{{ $item->standarPart->standar->uraian }}</td>
                                        <td class="text-center">{{ $item->standarPart->spesifikasi }}
                                        </td>
                                        <td class="text-center">{{ $item->standarPart->max }}</td>
                                        <td class="text-center">{{ $item->standarPart->min }}</td>
                                        <td>{{ $item->standarPart->standar->alat }}</td>
                                        <td class="text-center">
                                            @if (array_key_exists($item->id, $valueDimensi))
                                                <input type="text" name="value_dimensi[]" id="value_dimensi"
                                                    class="form-control w-50 mx-auto"
                                                    value="{{ $valueDimensi[$item->id] }}"disabled> 
                                            @else
                                                <input type="text" name="value_dimensi[]" id="value_dimensi"
                                                    class="form-control w-50 mx-auto" value="" disabled>
                                            @endif
                                            <input type="hidden" name="id_value_dimensi[]" value="{{ $item->id }}">
                                        </td>
                                        @if ($item->status == null)
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="success-outlined{{ $item->id }} " autocomplete="off"
                                                    onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                <label class="btn btn-outline-success"
                                                    for="success-outlined{{ $item->id }} ">OK</label>
                                            </td>
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="danger-outlined{{ $item->id }}"
                                                    onclick="submitCek('NG',{{ $item->id }})" autocomplete="off" disabled>
                                                <label class="btn btn-outline-danger"
                                                    for="danger-outlined{{ $item->id }}">NG</label>
                                            </td>
                                        @elseif($item->status == 'OK')
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="success-outlined{{ $item->id }} " autocomplete="off" checked
                                                    onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                <label class="btn btn-outline-success"
                                                    for="success-outlined{{ $item->id }} ">OK</label>
                                            </td>
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="danger-outlined{{ $item->id }}"
                                                    onclick="submitCek('NG',{{ $item->id }})" autocomplete="off" disabled>
                                                <label class="btn btn-outline-danger"
                                                    for="danger-outlined{{ $item->id }}">NG</label>
                                            </td>
                                        @elseif($item->status == 'NG')
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="success-outlined{{ $item->id }} " autocomplete="off"
                                                    onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                <label class="btn btn-outline-success"
                                                    for="success-outlined{{ $item->id }} ">OK</label>
                                            </td>
                                            <td class="text-center"><input type="radio" class="btn-check"
                                                    name="options-outlined{{ $item->id }}"
                                                    id="danger-outlined{{ $item->id }}" checked
                                                    onclick="submitCek('NG',{{ $item->id }})" autocomplete="off" disabled>
                                                <label class="btn btn-outline-danger"
                                                    for="danger-outlined{{ $item->id }}">NG</label>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endfor
            </div>
            @if ($verifCekFunction != null)
                <h3 class="text-center"><b>PEMERIKSAAN FUNCTION</b></h3>
                <div class="row mt-2">
                    @for ($i = 1; $i <= $jumlahTabel; $i++)
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered" style="overflow-x:auto;">
                                <thead>
                                    <tr>
                                        <th class="bg-warning">Sample ke-{{ $i }}</th>
                                        <th class="text-center border-3" colspan="7"
                                            style="background-color: darkgrey">
                                            FUNCTION</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" rowspan="2">NO</th>
                                        <th class="text-center" rowspan="2">URAIAN</th>
                                        <th class="text-center" rowspan="1" colspan="2">STANDAR</th>
                                        <th class="text-center" rowspan="2">ALAT</th>
                                        <th class="text-center" rowspan="1" colspan="2">KESIMPULAN</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Spesifikasi</th>
                                        <th class="text-center">Toleransi</th>
                                        <th class="text-center">OK</th>
                                        <th class="text-center">NG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no1 = 1;
                                        // dd($cekVisual);
                                        // Filtering the array to get elements where id is greater than 1
                                        // $i = $i;
                                        $data = array_filter($verifCekFunction, function ($item) use ($i) {
                                            return $item['urutan_sample'] === $i; // Use strict comparison here
                                        });
                                        // dd($data);
                                    @endphp
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->standarPart->standar->uraian }}</td>
                                            <td colspan="2" class="text-center">
                                                {{ $item->standarPart->rincian_standar }}
                                            </td>

                                            <td>{{ $item->standarPart->standar->alat }}</td>
                                            @if ($item->status == null)
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'OK')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off"
                                                        checked onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'NG')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}" checked
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off" disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @endfor
                </div>
            @endif

            <div class="row d-flex justify-content-end mt-2">
                <div class="col-2">
                        <input type="hidden" name="status_pengecekan" value="2">
                        <button type="submit" class="btn btn-primary">Verifikasi</button>
                </div>
            </div>
        </form>
        {{-- {{ $paginatedData->links }} --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            function submitCek(kondisi, id) {
                var formData = {
                    _token: csrfToken,
                    key1: kondisi,
                    key2: id,
                };
                $.ajax({
                    type: 'POST',
                    url: '/submit-cek', // The URL of your Laravel route
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        // Handle the response from the server
                        console.log('Terupdate'); // You can do something with the response
                        // windows.load();
                    },
                    error: function(error) {
                        // Handle any errors that occur during the AJAX request
                        console.error(error);
                    },
                });
            }

            $(document).ready(function() {
                $('.datatable').DataTable();
            });
        </script>
    @endsection
