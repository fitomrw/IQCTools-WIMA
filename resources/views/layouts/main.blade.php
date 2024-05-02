<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if (auth()->user()->jabatan == 'Staff QA' && Request::is('/kelola-LPP/grafik/0/0/0'))
            Dashboard
        @elseif (auth()->user()->jabatan == 'Kepala Seksi QC' && Request::is('verifikasi-pengecekan/0/0/0'))
            Dashboard
        @else
            {{ $title }}
        @endif
        | Incoming WIMA
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 5 -->
    <!-- <link rel="stylesheet" href="" -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('/template/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/template/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <!-- <link rel="stylesheet" href="{{ url('/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"> -->
    <!-- Daterange picker -->
    <!-- <link rel="stylesheet" href="{{ url('/template/plugins/daterangepicker/daterangepicker.css') }}"> -->
    <!-- summernote -->
    <!-- <link rel="stylesheet" href="{{ url('/template/plugins/summernote/summernote-bs4.css') }}"> -->
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!--Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="/js/jquery363.js"></script>
    {{-- <script src="/js/jquerydatatables.js"></script> --}}
    <!--My Style-->
    <link rel="stylesheet" href="/css/style.css">
    {{-- Favicon --}}
    <link rel="shortcut icon" href="/img/wima_favicon.ico" type="image/x-icon">
    <!--ChartJS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include ('partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include ('partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: white;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">
                                @if (auth()->user()->jabatan == 'Staff QA')
                                    Dashboard
                                @elseif (auth()->user()->jabatan == 'Kepala Seksi QC')
                                    Dashboard
                                @else
                                    {{ $title }}
                                @endif
                            </h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            @yield('container')

        </div>
        <!-- /.content-wrapper -->
        @include('partials.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <!-- <script src="{{ url('/template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->
    <!-- ChartJS -->
    <!-- <script src="{{ url('/template/plugins/chart.js/Chart.min.js') }}"></script> -->
    <!-- Sparkline -->
    <!-- <script src="{{ url('/template/plugins/sparklines/sparkline.js') }}"></script> -->
    <!-- JQVMap -->
    <!-- <script src="{{ url('/template/plugins/jqvmap/jquery.vmap.min.js') }}"></script> -->
    <!-- <script src="{{ url('/template/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> -->
    <!-- jQuery Knob Chart -->
    <!-- <script src="{{ url('/template/plugins/jquery-knob/jquery.knob.min.js') }}"></script> -->
    <!-- daterangepicker -->
    <!-- <script src="{{ url('/template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ url('/template/plugins/daterangepicker/daterangepicker.js') }}"></script> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <!-- <script src="{{ url('/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> -->
    <!-- Summernote -->
    <!-- <script src="{{ url('/template/plugins/summernote/summernote-bs4.min.js') }}"></script> -->
    <!-- overlayScrollbars -->
    <!-- <script src="{{ url('/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script> -->
    <!-- AdminLTE App -->
    <script src="{{ url('/template/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="{{ url('/template/dist/js/pages/dashboard.js') }}"></script> -->
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="{{ url('/template/dist/js/demo.js') }}"></script> -->


</body>

</html>
