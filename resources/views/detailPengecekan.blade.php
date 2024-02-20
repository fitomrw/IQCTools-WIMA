@extends ('layouts.main')

@section ('container')
    <div class="container-fluid border-top">
        <form id="tabelDetailPengecekan" action="/submit-pengecekan/{{ $dataPartIn->id_part_supply }}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="col-2">
                    <div class="fs-5">Periksa Part</div>
                    <div class="fs-5">{{ $dataPartIn->part->nama_part }}</div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-4">
                    <img src="/img/img_part/{{ $dataPartIn->part->gambar_part }}" alt="" style="max-width: 500px">
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
                                <label for="tanggal_periksa" class="form-label">Tanggal</label>
                                <td><input type="date" class="form-control" name="tanggal_periksa" id="tanggal_periksa" value="{{ $dataPartIn->tanggal_pengecekan }}" required></td>
                            @else
                                <label for="tanggal_periksa" class="form-label">Tanggal</label>
                                <td><input type="date" class="form-control" name="tanggal_periksa" id="tanggal_periksa" required></td>
                            @endif
                           
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                {{-- @for ($i = 1; $i <=  $jumlahTabel; $i++) --}}
                <table id="tabelUtamaDetailPengecekan" class="table table-bordered mt-3" style="overflow-x:auto;">
                    <thead>
                        <tr>
                            <th class="text-center border-3" colspan="7" style="background-color: darkgrey">VISUAL</th>
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
                        @endphp 
                        @foreach ($standarPerPart as $stdPart)
                            <tr>
                                <td>{{ $no1++ }}</td>
                                
                                {{-- <td>{{ $stdPart->uraian }}</td> --}}
                            </tr>
                        @endforeach  
                            
    
                            {{-- @foreach ($cekVisual as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->standarPart->standar->uraian }}</td>
                                    <td colspan="2" class="text-center">{{ $item->standarPart->rincian_standar }}</td>
                                    
                                    <td>{{ $item->standarPart->standar->alat }}</td>
                                    @if ($item->status == null)
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off"  onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @elseif($item->status == 'OK')
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off" checked onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @elseif($item->status == 'NG')
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off"  onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" checked onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @endif
                                </tr>
                                @php
                                $no1++;
                            @endphp
                            @endforeach
                    </tbody> --}}
                </tbody>
                </table>  
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center border-3" colspan="7" style="background-color: darkgrey">DIMENSI</th>
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
                            {{-- @foreach ($cekDimensi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->standarPart->standar->uraian }}</td>
                                <td colspan="2" class="text-center">{{ $item->standarPart->rincian_standar }}</td>
                                <td>{{ $item->standarPart->standar->alat }}</td>
                                @if ($item->status == null)
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off"  onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @elseif($item->status == 'OK')
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off" checked onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @elseif($item->status == 'NG')
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off"  onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" checked onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @endif
                            </tr>
                        @endforeach --}}
                        </tbody>
                    </table>
                </div>
                
            </div>
            {{-- @if ($cekFunction != null) --}}
                <div class="row mt-2">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center border-3" colspan="7" style="background-color: darkgrey">FUNCTION</th>
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
                                {{-- @foreach ($cekFunction as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> 
                                    <td>{{ $item->standarPart->standar->uraian }}</td>
                                    <td colspan="2" class="text-center">{{ $item->standarPart->rincian_standar }}</td>
                                    
                                    <td>{{ $item->standarPart->standar->alat }}</td>
                                    @if ($item->status == null)
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off"  onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @elseif($item->status == 'OK')
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off" checked onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @elseif($item->status == 'NG')
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="success-outlined{{ $item->id }} " autocomplete="off"  onclick="submitCek('OK',{{ $item->id }})">
                                            <label class="btn btn-outline-success" for="success-outlined{{ $item->id }} ">OK</label></td>
                                        <td class="text-center"><input type="radio" class="btn-check" name="options-outlined{{ $item->id }}" id="danger-outlined{{ $item->id }}" checked onclick="submitCek('NG',{{ $item->id }})" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="danger-outlined{{ $item->id }}">NG</label></td>
                                    @endif
                                
                                </tr>
                            @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- @endif --}}
                {{-- @endfor --}}
            <div class="row d-flex justify-content-end mt-2">
                <div class="col-2">
                    
                    <form action="/detailPengecekan/{{ $dataPartIn->id_part_supply }}" method="post">
                        @csrf
                        <input type="hidden" name="status_pengecekan" value="1">
                        <button class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </form>
    </div>
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
                url: '/submit-cek' , // The URL of your Laravel route
                data: formData,
                dataType: 'json',
                success: function (data) {
                    // Handle the response from the server
                    console.log('Terupdate'); // You can do something with the response
                    // windows.load();
                },
                error: function (error) {
                    // Handle any errors that occur during the AJAX request
                    console.error(error);
                },
            });
            
        }
    
    </script>
@endsection