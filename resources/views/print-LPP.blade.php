<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Print</title>
</head>

<body>
    <div class="container-fluid">
        <table class="table table-bordered" style="border: 4px">
            <tr>
                <td rowspan="2" style="width: 20%;">
                    <img src="/img/wima_logo.png" alt="Wima Logo" width="200" height="50">
                </td>
                <td class="fw-bold text-center">QUALITY CONTROL DEPARTEMENT</td>
            </tr>
            <tr>
                <td class="fw-bold text-center fs-5">REPORT OF PRODUCT DEFECT</td>
            </tr>
        </table>
        <div class="col-6">
            <table class="table table-sm table-borderless ms-2">
                <tr>
                    <td>To</td>
                    <td>: {{ $printingLPP->supplier->nama_supplier }}</td>
                </tr>
                <tr>
                    <td>Attn</td>
                    <td>: {{ $printingLPP->attention }}</td>
                </tr>
                <tr>
                    <td>CC</td>
                    <td>: {{ $printingLPP->cc }}</td>
                </tr>
            </table>
        </div>
        <div class="row mx-2">
            <table class="table table-sm ">
                <tr class="border-top">
                    <td>Part Name</td>
                    <td>: {{ $printingLPP->part->nama_part }}</td>
                    <td>LPP No.</td>
                    <td>: {{ $printingLPP->id }}/IV/2023</td>
                </tr>
                <tr>
                    <td>Part No.</td>
                    <td>: {{ $printingLPP->part_code }}</td>
                    <td>Found Date</td>
                    <td>: 22/03/2023</td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td>: {{ $printingLPP->kategori_part->nama_kategori }}</td>
                    <td>Issue date</td>
                    <td>: 22/03/2023</td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td>: {{ $printingLPP->quantity }} pcs</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lot No</td>
                    <td>: -</td>
                    <td>Qty Check Stock</td>
                    <td>: -</td>
                </tr>
            </table>
        </div>
        <div class="row mt-1 ms-2">
            {{-- <div class="col-6"> --}}
            <table class="table table-sm table-borderless">
                <tr>
                    <td style="width: 15%;">Problem Description :</td>
                    <td>{{ $printingLPP->problem_description }} </td>
                </tr>
                <tr>
                    <td style="width: 15%;">Found Area :</td>
                    <td>{{ $printingLPP->found_area }} </td>
                </tr>
                <tr>
                    <td style="width: 15%;">Ilustration :</td>
                    <td> <img src="/img/img_lpp/{{ $printingLPP->gambar_lpp }}" alt="" srcset=""
                            width="180px"></td>
                </tr>
                <tr>
                    <td style="width: 15%;">Request :</td>
                    <td> {{ $printingLPP->request }}</td>
                </tr>
            </table>
            {{-- </div> --}}
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div style="font-size: 10px" class="ms-2">Fill By Supplier</div>
                    <div class="ms-2" style="15px">Claim Status</div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check ms-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Approved
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check ms-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Rejected
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row ms-2 mt-3">
                        Aprroved/Rejected By
                    </div>
                    <div class="row mt-5 ms-2">
                        <div class="col-6 border-bottom">
                            (_____________)
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card" style=>
                    <div style="font-size: 10px" class="ms-2">Fill By QCD WIMA</div>
                    <div class="row">
                        <div style="font-size: 18px; font-weight:bold;" class="ms-2">Date: </div>
                        <div style="font-size: 18px; margin:10px 0px 15px 0px;" class="ms-2">10 Juli 2024 </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div style="font-size: 18px; font-weight:bold;" class="ms-2">Approved By: </div>
                            <div style="font-size: 18px; margin-top: 30px;" class="ms-2">{{ auth()->user()->name }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 18px; font-weight:bold;" class="ms-2">Verificator: </div>
                            <div style="font-size: 18px; margin-top: 30px;" class="ms-2">{{ auth()->user()->name }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
        <script>
            window.print();
        </script>
</body>

</html>
