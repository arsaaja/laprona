<?php
include('../koneksi/koneksi.php');

$q_siswa = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa");
$jumlah_siswa = mysqli_fetch_assoc($q_siswa)['total'];

//$q_pesan = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesan");
//$jumlah_pesan = mysqli_fetch_assoc($q_pesan)['total'];

$q_mentor = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM mentor");
$jumlah_mentor = mysqli_fetch_assoc($q_mentor)['total'];

$q_kelas = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kelas");
$jumlah_kelas = mysqli_fetch_assoc($q_kelas)['total'];
?>

<!DOCTYPE html>
<html>

<head>
  <?php include("includes/head.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include("includes/header.php") ?>

    <?php include("includes/sidebar.php") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3><i class="fa-solid fa-house"></i>Beranda</h3>
            </div>

          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?= $jumlah_siswa ?></h3>
                <p>Jumlah Siswa</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-graduate"></i>
              </div>
              <a href="siswa.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $jumlah_mentor ?></h3>
                <p>Jumlah Mentor</p>
              </div>
              <div class="icon">
                <i class="fas fa-chalkboard-teacher"></i>
              </div>
              <a href="mentor.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $jumlah_kelas ?></h3>
                <p>Jumlah Kelas</p>
              </div>
              <div class="icon">
                <i class="fas fa-school"></i>
              </div>
              <a href="kelas.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /.card-header -->

    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">&nbsp;</div>
  </div>
  <!-- /.card -->

  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("includes/footer.php") ?>

  </div>
  <!-- ./wrapper -->

  <?php include("includes/script.php") ?>
</body>

</html>