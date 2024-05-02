  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 " style="overflow: hidden">
      <!-- Brand Logo -->
      <div class="row">
          <div class="col-sm-3">
              @if (auth()->user()->jabatan == 'Kepala Seksi QC')
              <a href="/verifikasi-pengecekan/0/0/0" @elseif(auth()->user()->jabatan == 'Staff QA') <a
                      href="/kelola-LPP/grafik/0/0/0" @endif
                      <a href="/" class="brand-link">
                          <img src="/img/wima_logo.png" alt="WIMA Incoming" class="image w-100 mx-1" style="opacity: .8">
                          <p class="d-block text-center mb-1"><b>IQC</b>Tools</p>
                      </a>
          </div>
      </div>


      <!-- Sidebar -->
      <div class="sidebar" style="overflow: hidden">

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  @if (auth()->user()->jabatan == 'Staff QC')
                      <li class="nav-item">
                          <a href="/dataPartIncoming" class="nav-link">
                              <p>Part Incoming</p>
                          </a>
                      </li>
                  @endif

                  @if (auth()->user()->jabatan == 'Kepala Seksi QC')
                      <li class="nav-item">
                          <a href="/verifikasi-pengecekan/0/0/0" class="nav-link">
                              <p>Verifikasi Pengecekan</p>
                          </a>
                      </li>
                  @endif

                  @if (auth()->user()->jabatan == 'Staff QC')
                      {{-- <li class="nav-item">
            <a href="/riwayatPengecekan" class="nav-link">
                <p>Riwayat Pengecekan</p>
            </a>
          </li> --}}
                      <li class="nav-item">
                          <a href="/riwayatPengecekan" class="nav-link">
                              <p>Pengecekan</p>
                          </a>
                      </li>
                  @endif

                  @if (auth()->user()->jabatan == 'Staff QC')
                      <li class="nav-item">
                          <a href="/kelola-LPP" class="nav-link">
                              <p>Laporan Penyimpangan Part</p>
                          </a>
                      </li>
                  @endif

                  @if (auth()->user()->jabatan == 'Staff QA')
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
                              <li class="nav-item">
                                  <a href="/kelola-masterStandar" class="nav-link">
                                      <p>- Data Master Standar</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                      <li class="nav-item">
                          <a href="/kelola-masterStandarPart" class="nav-link">
                              <p>Kelola Standar Per Part</p>
                          </a>
                      </li>
                      {{-- @php
                          $dataSupp = $getSupplier->where('id_supplier', $supplier)->first();
                          $dataKat = $getKate->where('id_kategori', $kategori)->first();
                      @endphp --}}
                      <li class="nav-item">
                          <a href="/kelola-LPP/verifLaporan" class="nav-link">
                              <p>Verifikasi Laporan <br> Penyimpangan Part</p>
                          </a>
                      </li>
                  @endif

                  @if (auth()->user()->jabatan == 'Admin QC')
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
