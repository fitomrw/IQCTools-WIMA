<div class="container">
    <form action="/filterGrafik" method="post">
        @csrf
        <div class="row mb-5 w-75 flow-reverse">

            <div class="col">
                <label for="supplierFilter" class="form-label">Supplier</label>
                <select class="form-select border border-dark" id="supplierFilter" name="supplierFilter">
                    <option selected></option>
                    @foreach ($getSupplier as $getSupp)
                        <option value="{{ $getSupp->id_supplier }}">{{ $getSupp->nama_supplier }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="kategoriFilter" class="form-label">Kategori</label>
                <select class="form-select border border-dark" id="kategoriFilter" name="kategoriFilter">
                    <option selected></option>
                    @foreach ($getKategori as $getKate)
                        <option value="{{ $getKate->id_kategori }}">{{ $getKate->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="bulanFilter" class="form-label">Bulan</label>
                <select class="form-select border border-dark" id="bulanFilter" name="bulanFilter">
                    <option selected></option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>

            <div class="col d-flex align-items-center">
                <button class="btn btn-info mt-4">Filter</button>
            </div>
        </div>
    </form>
    <div class="row">
        @if ($supplier != 0 || $kategori != 0 || $bulan != 0)
            @php
                $dataSupp = $getSupplier->where('id_supplier', $supplier)->first();
                $dataKat = $getKate->where('id_kategori', $kategori)->first();
            @endphp
            @if ($supplier != 0 && $kategori == 0)
                <span> <strong>Supplier :</strong> {{ $dataSupp->nama_supplier }} | <strong>Kategori :</strong>
                    {{ $dataKat }} |
                    <strong>Bulan
                        :</strong> {{ $bulanForView }}
                </span>
            @elseif($supplier == 0 && $kategori != 0)
                <span> <strong>Supplier :</strong> {{ $dataSupp }} | <strong>Kategori :</strong>
                    {{ $dataKat->nama_kategori }} |
                    <strong>Bulan
                        :</strong> {{ $bulanForView }}
                </span>
            @elseif($supplier != 0 && $kategori != 0)
                <span> <strong>Supplier :</strong> {{ $dataSupp->nama_supplier }} | <strong>Kategori :</strong>
                    {{ $dataKat->nama_kategori }} |
                    <strong>Bulan
                        :</strong> {{ $bulanForView }}
                </span>
            @endif
        @else
            <span> <strong>Supplier :</strong> 0 | <strong>Kategori :</strong> 0 | <strong>Bulan
                    :</strong> {{ $bulanForView }}
            </span>
        @endif

    </div>
    <div class="row w-100"><canvas id="myChart" width="400" height="400"></canvas></div>
</div>

<script>
    $.ajax({
        url: '/api/kelola-LPP/grafik/{{ $supplier }}/{{ $kategori }}/{{ $bulan }}',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Handle the data returned from the server
            console.log(response);
            console.log(response[0]);
            console.log(response[1][0]);
            console.log(response[2][0]);
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response[0],
                    datasets: [{
                        label: 'Reject Part',
                        // data: [12, 19, 3, 5, 2, 3],
                        data: response[1],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            // 'rgba(54, 162, 235, 0.2)',
                            // 'rgba(255, 206, 86, 0.2)',
                            // 'rgba(75, 192, 192, 0.2)',
                            // 'rgba(153, 102, 255, 0.2)',
                            // 'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            // 'rgba(54, 162, 235, 1)',
                            // 'rgba(255, 206, 86, 1)',
                            // 'rgba(75, 192, 192, 1)',
                            // 'rgba(153, 102, 255, 1)',
                            // 'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }, {
                        label: 'Ok Part',
                        // data: [12, 19, 3, 5, 2, 3],
                        data: response[2],
                        backgroundColor: [
                            // 'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            // 'rgba(255, 206, 86, 0.2)',
                            // 'rgba(75, 192, 192, 0.2)',
                            // 'rgba(153, 102, 255, 0.2)',
                            // 'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            // 'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            // 'rgba(255, 206, 86, 1)',
                            // 'rgba(75, 192, 192, 1)',
                            // 'rgba(153, 102, 255, 1)',
                            // 'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                // beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    });
</script>