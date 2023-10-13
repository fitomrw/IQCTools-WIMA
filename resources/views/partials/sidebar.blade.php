  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="row">
        <div class="col-sm-3">    
            <a href="/" class="brand-link">
            <img src="/img/wima_logo.png" alt="WIMA Incoming" class="image w-100 mx-1"
                style="opacity: .8">
              <p class="d-block text-center mb-1"><b>IQC</b>Tools</p>
            </a>
        </div>
    </div>


    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if (auth()->user()->jabatan == "Admin QC")   
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <p>
                Kelola Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/kelola-masterPart" class="nav-link">
                  <p>- Data Master Part</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/kelola-masterKategori" class="nav-link">
                  <p>- Data Master Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/kelola-masterSupplier" class="nav-link">
                  <p>- Data Master Supplier</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if (auth()->user()->jabatan=="Staff QC")    
          <li class="nav-item">
            <a href="/dataPartIncoming" class="nav-link">
                <p>Part Incoming</p>
            </a>
          </li>
          @endif

          @if (auth()->user()->jabatan=="Staff QC") 
          <li class="nav-item">
            <a href="/kelola-pengecekan" class="nav-link">
                <p>Pengecekan</p>
            </a>
          </li>
          @endif
          
          @if (auth()->user()->jabatan=="Staff QC")    
          <li class="nav-item">
            <a href="/riwayatPengecekan" class="nav-link">
                <p>Riwayat Pengecekan</p>
            </a>
          </li>
          @endif

          @if (auth()->user()->jabatan=="Staff QC")     
          <li class="nav-item">
            <a href="/kelola-LPP" class="nav-link">
                <p>Laporan Penyimpangan Part</p>
            </a>
          </li>
          @endif

          @if (auth()->user()->jabatan=="Staff QA")    
          <li class="nav-item">
            <a href="/kelola-LPP/verifLaporan" class="nav-link">
                <p>Verifikasi Laporan</p>
            </a>
          </li>
          @endif

          @if (auth()->user()->jabatan == "Admin QC")    
          <li class="nav-item">
            <a href="/register" class="nav-link">
                <p>Kelola User</p>
            </a>
          </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>