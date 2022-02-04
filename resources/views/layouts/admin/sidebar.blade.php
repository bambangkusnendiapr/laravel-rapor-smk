<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{ asset('admin/dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SMK Persis</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <!-- <div class="image">
        <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div> -->
      <div class="info">
        <a href="{{ route('profile') }}" class="d-block">{{ Auth::user()->name }} <span class="right badge badge-primary">{{ Auth::user()->roles->first()->display_name  }}</span></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-header">MAIN MENU</li>
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link @yield('dashboard')">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        @role('superadmin')
        <li class="nav-item">
          <a href="{{ route('bayar') }}" class="nav-link @yield('bayar')">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Bayar
            </p>
          </a>
        </li>
        @endrole
        @role('superadmin|wali_kelas')
        <li class="nav-header">DATA MASTER</li>
        <li class="nav-item @yield('wali')">
          <a href="#" class="nav-link @yield('kelas')">
            <i class="nav-icon fab fa-buffer"></i>
            <p>
              Kelola Data Wali Kelas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('wali.kelas') }}" class="nav-link @yield('wali-kelas')">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Wali Kelas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pelajaran') }}" class="nav-link @yield('pelajaran')">
                <i class="far fa-circle nav-icon"></i>
                <p>Bank Pelajaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('semester') }}" class="nav-link @yield('semester')">
                <i class="far fa-circle nav-icon"></i>
                <p>Semester</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('jurusan') }}" class="nav-link @yield('jurusan')">
                <i class="far fa-circle nav-icon"></i>
                <p>Jurusan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('kelompok') }}" class="nav-link @yield('kelompok')">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelompok Pelajaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('ekstrakurikuler') }}" class="nav-link @yield('ekstrakurikuler')">
                <i class="far fa-circle nav-icon"></i>
                <p>Ekstrakurikuler</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('jabatan') }}" class="nav-link @yield('jabatan')">
                <i class="far fa-circle nav-icon"></i>
                <p>Jabatan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item @yield('data-guru')">
          <a href="#" class="nav-link @yield('data_guru')">
            <i class="nav-icon fab fa-buffer"></i>
            <p>
              Kelola Data Guru
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('guru') }}" class="nav-link @yield('guru')">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Guru</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pelajaran.guru') }}" class="nav-link @yield('pelajaran-guru')">
                <i class="far fa-circle nav-icon"></i>
                <p>Mata Pelajaran</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item @yield('data-siswa')">
          <a href="#" class="nav-link @yield('data_siswa')">
            <i class="nav-icon fab fa-buffer"></i>
            <p>
              Kelola Data Siswa
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('students.index') }}" class="nav-link @yield('student')">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Siswa</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item @yield('orang')">
          <a href="#" class="nav-link @yield('tua')">
            <i class="nav-icon fab fa-buffer"></i>
            <p>
              Kelola Data Orang Tua
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('ortu') }}" class="nav-link @yield('ortu')">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Orang Tua</p>
              </a>
            </li>
          </ul>
        </li>
        @endrole
        <li class="nav-header">RAPOR</li>
        <li class="nav-item @yield('nilai-rapor')">
          <a href="#" class="nav-link @yield('nilai_rapor')">
            <i class="nav-icon fab fa-buffer"></i>
            <p>
              Penilaian Rapor
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('rapor') }}" class="nav-link @yield('rapor')">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Rapor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('rapor.nilai') }}" class="nav-link @yield('rapor-nilai')">
                <i class="far fa-circle nav-icon"></i>
                <p>Penilaian</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">KELUAR</li>
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Logout
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>