<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-blue elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="/laprona/images/logo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
    <span class="brand-text font-weight-light">La Prona</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="profil.php" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Profil
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="konfigurasiweb.php" class="nav-link">
            <i class="nav-icon fa fa-cogs"></i>
            <p>
              Konfigurasi Web
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-school"></i>
            <p>
              Manajemen Kelas
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="kelas.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="tugas.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tugas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pesan.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pesan</p>
              </a>
            </li>
          </ul>
        </li>
        <?php
        if (isset($_SESSION['role'])) {
          if ($_SESSION['role'] == "admin") { ?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-user-graduate"></i>
                <p>
                  User
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="mentor.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mentor</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="siswa.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Siswa</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php }
        } ?>
        <li class="nav-item">
          <a href="riwayatpendidikan.php" class="nav-link">
            <i class="nav-icon fa fa-graduation-cap"></i>
            <p>
              Jenjang Pendidikan
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="kontak.php" class="nav-link">
            <i class="nav-icon fa fa-envelope"></i>
            <p>
              Pesan Masuk
            </p>
          </a>
        </li>


        <li class="nav-item">
          <a href="ubahpassword.php" class="nav-link">
            <i class="nav-icon fas fa-user-lock"></i>
            <p>
              Ubah Password
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Sign Out
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>