{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Incoming WIMA</title>

    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--My Style-->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="wrapper">
        <!--Nav-->
            <nav class="navbar navbar-expand-lg bg-warning navbar-dark">
                <div class="container justify-content-center">
                    <a class="navbar-brand mb-0" href="#"><img src ={{ $image }} alt="wima-logo"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
                    
        <div class="container">
                <div class="row justify-content-center">
                    <div class="login mt-5">
                        @if(session()->has('loginError'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        @endif    
                            <form action="/login" method="post">
                                @csrf
                                <h4 class="text-center">Silahkan Login!</h4>
                                <div class="form-group mt-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error ('username') is-invalid @enderror" id="username" name="username" value ="{{ old('username') }}"placeholder="Masukkkan Username Anda!" autofocus required>
                                    
                                    @error ('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error ('password') is-invalid @enderror" id="password" 
                                    name="password" placeholder="Masukkan Password Anda!"required>

                                    @error ('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <button type="submit" class="w-100 btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html> --}}

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
              <span class="fas fa-envelope"></span>
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
              <span class="fas fa-lock"></span>
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
