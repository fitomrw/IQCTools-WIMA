@extends ('layouts.main')
@section('container')
    <div class="container-fluid border-top">
        <form id="tabelDetailPengecekan" action="/submit-pengecekan/{{ $dataPartIn->id_part_supply }}" method="post">
            {{-- @dd($dataPartIn) --}}
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
                            @if ($tanggalCek->tanggal_cek != null) 
                                <label for="tanggal_cek" class="form-label">Tanggal</label>
                                <td><input type="date" class="form-control" name="tanggal_cek" id="tanggal_cek"
                                        value="{{ $tanggalCek->tanggal_cek }}" disabled></td>
                            @else
                                <label for="tanggal_cek" class="form-label">Tanggal</label>
                                <td><input type="date" class="form-control" name="tanggal_cek" id="tanggal_cek"
                                        value="{{ $tanggalSekarang }}" required></td>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
            <h3 class="text-center"><b>CHECKSHEET PEMERIKSAAN</b></h3>
            @for ($i = 1; $i <= $jumlahTabel; $i++)
                <div class="row mt-2">
                    <div class="col-12 table-responsive">
                        <table id="tabelUtamaDetailPengecekan" class="table table-bordered mt-3" style="overflow-x:auto;">
                            <thead>
                                <tr>
                                    <th class="bg-warning text-center" colspan="8">Sample ke-{{ $i }}</th>
                                </tr>
                                <tr>
                                    <th class="text-center border-3" colspan="8" style="background-color: darkgrey">
                                        VISUAL</th>
                                </tr>
                                <tr>
                                    <th class="text-center" rowspan="2">NO</th>
                                    <th class="text-center" rowspan="2" style="width: 30px;">POINT</th>
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
                                    // Filtering the array to get elements where id is greater than 1
                                    $data = array_filter($cekVisual, function ($item) use ($i) {
                                        return $item['urutan_sample'] === $i; // Use strict comparison here
                                    });
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->standarPart->standar->uraian }}</td>
                                        <td colspan="2" class="text-center">{{ $item->standarPart->spesifikasi }}
                                        </td>
                                        <td>{{ $item->standarPart->standar->alat }}</td>
                                        {{-- IF THE CHECKSHEET ALREADY VERIFIED --}}
                                        @if ($dataPartIn->status_pengecekan == 2)
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
                                        @php
                                            $ngFound = false;
                                            $groupedCekVisual = collect($cekVisual)
                                                ->flatMap(function ($item) {
                                                    return $item;
                                                })
                                                ->groupBy('urutan_sample');
                                            foreach ($groupedCekVisual as $urutanSample => $items) {
                                                $ngFound = $items->contains(function ($item) {
                                                    return $item['status'] === 'NG';
                                                });
                                                if ($ngFound) {
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if ($ngFound)
                                            <input type="hidden" name="final_status[]" value="1">
                                        @else
                                            <input type="hidden" name="final_status[]" value="0">
                                        @endif
                                        {{-- (END OF) IF THE CHECKSHEET ALREADY VERIFIED --}}
                                        @else
                                        {{--IF THE CHECKSHEET NOT VERIFIED YET OR NOT CHECKED YET  --}}
                                            @if ($item->status == null)
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})">
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'OK')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off" checked
                                                        onclick="submitCek('OK',{{ $item->id }})">
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'NG')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})">
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}" checked
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @endif
                                        </tr>
                                        @php
                                            $ngFound = false;
                                            $groupedCekVisual = collect($cekVisual)
                                                ->flatMap(function ($item) {
                                                    return $item;
                                                })
                                                ->groupBy('urutan_sample');
                                            foreach ($groupedCekVisual as $urutanSample => $items) {
                                                $ngFound = $items->contains(function ($item) {
                                                    return $item['status'] === 'NG';
                                                });
                                                if ($ngFound) {
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if ($ngFound)
                                            <input type="hidden" name="final_status[]" value="1">
                                        @else
                                            <input type="hidden" name="final_status[]" value="0">
                                        @endif
                                    @endif
                                    {{--(END OF) IF THE CHECKSHEET NOT VERIFIED YET OR NOT CHECKED YET  --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- @endfor --}}
                </div>
                {{-- PEMERIKSAAN DIMENSI --}}
                <div class="row mt-2">
                    {{-- <h3 class="text-center"><b>PEMERIKSAAN DIMENSI</b></h3> --}}
                    {{-- @for ($i = 1; $i <= $jumlahTabel; $i++) --}}
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered" class="table table-bordered mt-3 datatable"
                            style="overflow-x:auto;">
                            <thead>
                                <tr>
                                    {{-- <th class="bg-warning" colspan="2">Sample ke-{{ $i }}</th> --}}
                                    <th class="text-center border-3" colspan="10" style="background-color: darkgrey">
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
                                    // dd($cekVisual);
                                    // Filtering the array to get elements where id is greater than 1
                                    // $i = $i;
                                    $data = array_filter($cekDimensi, function ($item) use ($i) {
                                        return $item['urutan_sample'] === $i; // Use strict comparison here
                                    });
                                @endphp
                                @foreach ($data as $item)
                                    {{-- @dd($cekDimensi) --}}
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->standarPart->point }}</td>
                                        <td>{{ $item->standarPart->standar->uraian }}</td>
                                        <td class="text-center">{{ $item->standarPart->spesifikasi }}
                                        </td>
                                        <td class="text-center">{{ $item->standarPart->max }}</td>
                                        <td class="text-center">{{ $item->standarPart->min }}</td>
                                        <td class="text-center">{{ $item->standarPart->standar->alat }}</td>
                                        @if ($item->standarPart->standar->alat == 'RING GAUGE')
                                            <td>
                                                <input type="text" name="value_dimensi[]" id="value_dimensi"
                                                    class="form-control w-50 mx-auto" value="" disabled>
                                            </td>
                                            @if ($dataPartIn->status_pengecekan == 2)
                                                @if ($item->status == null)
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off" disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                                @elseif($item->status == 'OK')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        checked onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                                @elseif($item->status == 'NG')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}" checked
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                            @endif
                                        </tr>
                                        @php
                                            $ngFound = false;
                                            $groupedCekDimensi = collect($cekDimensi)
                                                ->flatMap(function ($item) {
                                                    return $item;
                                                })
                                                ->groupBy('urutan_sample');
                                            foreach ($groupedCekDimensi as $urutanSample => $items) {
                                                $ngFound = $items->contains(function ($item) {
                                                    return $item['status'] === 'NG';
                                                });
                                                if ($ngFound) {
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if ($ngFound)
                                            <input type="hidden" name="final_status[]" value="1">
                                        @else
                                            <input type="hidden" name="final_status[]" value="0">
                                        @endif

                                            @else
                                    
                                            @if ($item->status == null)
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})">
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'OK')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        checked onclick="submitCek('OK',{{ $item->id }})" >
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        >
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'NG')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})" >
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}" checked
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        >
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                            @endif
                                        </tr>
                                        @php
                                            $ngFound = false;
                                            $groupedCekDimensi = collect($cekDimensi)
                                                ->flatMap(function ($item) {
                                                    return $item;
                                                })
                                                ->groupBy('urutan_sample');
                                            foreach ($groupedCekDimensi as $urutanSample => $items) {
                                                $ngFound = $items->contains(function ($item) {
                                                    return $item['status'] === 'NG';
                                                });
                                                if ($ngFound) {
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if ($ngFound)
                                            <input type="hidden" name="final_status[]" value="1">
                                        @else
                                            <input type="hidden" name="final_status[]" value="0">
                                        @endif

                                        @endif

                                        @else

                                        @if ($dataPartIn->status_pengecekan == 2)
                                        <td class="text-center">
                                            @if (array_key_exists($item->id, $valueDimensi))
                                                <input type="text" name="value_dimensi[]"
                                                    id="inputDim{{ $item->id }}"
                                                    class="form-control w-50 mx-auto"
                                                    oninput="test({{ $item->id }}, {{ $item->standarPart->spesifikasi }},'{{ $item->standarPart->max }}','{{ $item->standarPart->min }}')"
                                                    value="{{ $valueDimensi[$item->id] }}" disabled>
                                            @else
                                                <input type="text" name="value_dimensi[]"
                                                    class="form-control w-50 mx-auto" value=""
                                                    id="inputDim{{ $item->id }}"
                                                    oninput="test({{ $item->id }}, {{ $item->standarPart->spesifikasi }},'{{ $item->standarPart->max }}','{{ $item->standarPart->min }}')"
                                                    disabled>
                                            @endif
                                            <input type="hidden" name="id_value_dimensi[]"
                                                id="inputDim{{ $item->id }}" value="{{ $item->id }}"
                                                oninput="test({{ $item->id }}, {{ $item->standarPart->spesifikasi }},'{{ $item->standarPart->max }}','{{ $item->standarPart->min }}')">
                                        </td>
                                        @else
                                        <td class="text-center">
                                            @if (array_key_exists($item->id, $valueDimensi))
                                                <input type="text" name="value_dimensi[]"
                                                    id="inputDim{{ $item->id }}"
                                                    class="form-control w-50 mx-auto"
                                                    oninput="test({{ $item->id }}, {{ $item->standarPart->spesifikasi }},'{{ $item->standarPart->max }}','{{ $item->standarPart->min }}')"
                                                    value="{{ $valueDimensi[$item->id] }}" required>
                                            @else
                                                <input type="text" name="value_dimensi[]"
                                                    class="form-control w-50 mx-auto" value=""
                                                    id="inputDim{{ $item->id }}"
                                                    oninput="test({{ $item->id }}, {{ $item->standarPart->spesifikasi }},'{{ $item->standarPart->max }}','{{ $item->standarPart->min }}')"
                                                    required>
                                            @endif
                                            <input type="hidden" name="id_value_dimensi[]"
                                                id="inputDim{{ $item->id }}" value="{{ $item->id }}"
                                                oninput="test({{ $item->id }}, {{ $item->standarPart->spesifikasi }},'{{ $item->standarPart->max }}','{{ $item->standarPart->min }}')">
                                        </td>
                                        @endif
                                            @if ($item->status == null)
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'OK')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        checked onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'NG')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlinedtest{{ $item->id }}" autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlinedtest{{ $item->id }}">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlinedtest{{ $item->id }}" checked
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off"
                                                        disabled>
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlinedtest{{ $item->id }}">NG</label>
                                                </td>
                                            @endif
                                    </tr>
                                    @php
                                        $ngFound = false;
                                        $groupedCekDimensi = collect($cekDimensi)
                                            ->flatMap(function ($item) {
                                                return $item;
                                            })
                                            ->groupBy('urutan_sample');
                                        foreach ($groupedCekDimensi as $urutanSample => $items) {
                                            $ngFound = $items->contains(function ($item) {
                                                return $item['status'] === 'NG';
                                            });
                                            if ($ngFound) {
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if ($ngFound)
                                        <input type="hidden" name="final_status[]" value="1">
                                    @else
                                        <input type="hidden" name="final_status[]" value="0">
                                    @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- @endfor --}}
                </div>
                {{-- PEMERIKSAAN FUNCTION --}}
                @if ($cekFunction != null)
                    <div class="row mt-2">
                        {{-- <h3 class="text-center"><b>PEMERIKSAAN FUNCTION</b></h3> --}}
                        {{-- @for ($i = 1; $i <= $jumlahTabel; $i++) --}}
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered" style="overflow-x:auto;">
                                <thead>
                                    <tr>
                                        {{-- <th class="bg-warning">Sample ke-{{ $i }}</th> --}}
                                        <th class="text-center border-3" colspan="8"
                                            style="background-color: darkgrey">
                                            FUNCTION</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" rowspan="2">NO</th>
                                        <th class="text-center" rowspan="2" style="width: 30px;">POINT</th>
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
                                        // dd($cekVisual);
                                        // Filtering the array to get elements where id is greater than 1
                                        // $i = $i;
                                        $data = array_filter($cekFunction, function ($item) use ($i) {
                                            return $item['urutan_sample'] === $i; // Use strict comparison here
                                        });
                                        // dd($data);
                                    @endphp
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->standarPart->standar->uraian }}</td>
                                            <td colspan="2" class="text-center">
                                                {{ $item->standarPart->spesifikasi }}
                                            </td>
                                            <td>{{ $item->standarPart->standar->alat }}</td>
                                            {{-- IF THE CHECKSHEET ALREADY VERIFIED --}}
                                            @if ($dataPartIn->status_pengecekan == 2)
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
                                                            id="success-outlined{{ $item->id }} " autocomplete="off"
                                                            checked onclick="submitCek('OK',{{ $item->id }})" disabled>
                                                        <label class="btn btn-outline-success"
                                                            for="success-outlined{{ $item->id }} ">OK</label>
                                                    </td>
                                                    <td class="text-center"><input type="radio" class="btn-check"
                                                            name="options-outlined{{ $item->id }}"
                                                            id="danger-outlined{{ $item->id }}"
                                                            onclick="submitCek('NG',{{ $item->id }})"
                                                            autocomplete="off" disabled>
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
                                                            onclick="submitCek('NG',{{ $item->id }})"
                                                            autocomplete="off" disabled>
                                                        <label class="btn btn-outline-danger"
                                                            for="danger-outlined{{ $item->id }}">NG</label>
                                                    </td>
                                                @endif
                                    </tr>
                                    @php
                                        $ngFound = false;
                                        $groupedCekDimensi = collect($cekFunction)
                                            ->flatMap(function ($item) {
                                                return $item;
                                            })
                                            ->groupBy('urutan_sample');
                                        foreach ($groupedCekDimensi as $urutanSample => $items) {
                                            $ngFound = $items->contains(function ($item) {
                                                return $item['status'] === 'NG';
                                            });
                                            if ($ngFound) {
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if ($ngFound)
                                        <input type="hidden" name="final_status[]" value="1">
                                    @else
                                        <input type="hidden" name="final_status[]" value="0">
                                    @endif
                                        {{-- (END OF) IF THE CHECKSHEET ALREADY VERIFIED --}}
                                        {{-- IF THE CHECKSHEET NOT VERIFIED YET OR NOT CHECKED YET --}}
                                            @else
                                            @if ($item->status == null)
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})">
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'OK')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off"
                                                        checked onclick="submitCek('OK',{{ $item->id }})">
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}"
                                                        onclick="submitCek('NG',{{ $item->id }})"
                                                        autocomplete="off">
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @elseif($item->status == 'NG')
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="success-outlined{{ $item->id }} " autocomplete="off"
                                                        onclick="submitCek('OK',{{ $item->id }})">
                                                    <label class="btn btn-outline-success"
                                                        for="success-outlined{{ $item->id }} ">OK</label>
                                                </td>
                                                <td class="text-center"><input type="radio" class="btn-check"
                                                        name="options-outlined{{ $item->id }}"
                                                        id="danger-outlined{{ $item->id }}" checked
                                                        onclick="submitCek('NG',{{ $item->id }})"
                                                        autocomplete="off">
                                                    <label class="btn btn-outline-danger"
                                                        for="danger-outlined{{ $item->id }}">NG</label>
                                                </td>
                                            @endif
                                        </tr>
                                        @php
                                            $ngFound = false;
                                            $groupedCekDimensi = collect($cekFunction)
                                                ->flatMap(function ($item) {
                                                    return $item;
                                                })
                                                ->groupBy('urutan_sample');
                                            foreach ($groupedCekDimensi as $urutanSample => $items) {
                                                $ngFound = $items->contains(function ($item) {
                                                    return $item['status'] === 'NG';
                                                });
                                                if ($ngFound) {
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if ($ngFound)
                                            <input type="hidden" name="final_status[]" value="1">
                                        @else
                                            <input type="hidden" name="final_status[]" value="0">
                                        @endif
                                        @endif
                                        {{-- (END OF) IF THE CHECKSHEET ALREADY VERIFIED --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endfor


            <div class="row d-flex justify-content-end mt-2">
                <div class="col-2">
                    @if ($ngFound)
                        <input type="hidden" name="final_status[]" value="1">
                    @else
                        <input type="hidden" name="final_status[]" value="0">
                    @endif
                </div>

                <div class="col-2 mb-2">
                    <form id="tabelDetailPengecekan" action="/submit-pengecekan/{{ $dataPartIn->id_part_supply }}"
                        method="post">
                        @csrf
                        <input type="hidden" name="status_pengecekan" value="1">
                    </form>
                    @if ($dataPartIn->status_pengecekan == 0 || $dataPartIn->status_pengecekan == 1)
                        <button type="submit" class="btn btn-success" name="submitButton">Submit</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    {{-- {{ $paginatedData->links }} --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        function test(id, spesifikasi, max, min) {

            var newSpesifikasi = parseFloat(spesifikasi);
            var newMax = parseFloat(max);
            let batasAtas = (newSpesifikasi + newMax); // Subtract min from newSpesifikasi
            let batasBawah = (newSpesifikasi - min); // Add max to newSpesifikasi

            var radioButton = document.getElementById('success-outlinedtest' + id);
            var wrongButton = document.getElementById('danger-outlinedtest' + id);
            var inputDimensi = document.getElementById('inputDim' + id);
            if (batasAtas < inputDimensi.value || batasBawah > inputDimensi.value) {
                wrongButton.checked = true;
                console.log('S')
                submitCek('NG', id)
            } else {
                radioButton.checked = true;
                console.log('B')
                submitCek('OK', id)
            }
            console.log(inputDimensi.value);
            // Set the checked attribute to true to select the radio button
        }

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
