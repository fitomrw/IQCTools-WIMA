<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $title }} | Incoming WIMA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  {{-- Favicon --}}
  <link rel="shortcut icon" href="/img/wima_favicon.ico" type="image/x-icon">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo mb-2">
    <p><img src ={{ $image }} alt="wima-logo"> | <b>IQC</b>Tools</p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        @if(session()->has('loginError'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
      <p class="login-box-msg">Silahkan Login</p>

      <form action="/login" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control @error ('username') is-invalid @enderror" id="username" name="username" value ="{{ old('username') }}"placeholder="Username" autofocus required>
          <div class="input-group-append">
            <div class="input-group-text">
            </div>
          </div>
          @error ('username')
          <div class="invalid-feedback">
          {{ $message }}
          </div>
          @enderror
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control @error ('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
            </div>
          </div>
          @error ('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
          <!-- /.col -->
          <div class="col">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/template/dist/js/adminlte.min.js"></script>

</body>
</html>
