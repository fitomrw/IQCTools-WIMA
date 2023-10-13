<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
    </ul>

    {{-- <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-md">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

    <ul class="navbar-nav ml-auto">
    @auth
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Welcome, {{ auth()->user()->name }}
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="/">Home</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
        <form action="/logout" method="post">
          @csrf
          <button type="submit" class="dropdown-item">Log Out</button>
        </form>
        </li>
      </ul>
    </li>
    @endauth
    </ul>
  </nav>
  <!-- /.navbar -->