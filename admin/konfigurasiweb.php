<?php
session_start();
include('../koneksi/koneksi.php');
$sql = "SELECT logo, nama_web, tahun FROM konfigurasi_web where id_konfigurasi_web =  1";
//echo $sql;
$query = mysqli_query($koneksi, $sql);
while ($data = mysqli_fetch_row($query)) {
  $logo = $data[0];
  $nama_web = $data[1];
  $tahun = $data[2];
}
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
              <h3><i class="fas fa-user-tie"></i> Konfigurasi Web</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Konfigurasi Web</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <a href="konfigurasiweb_edit.php" class="btn btn-sm btn-info float-right"><i class="fas fa-edit"></i> Edit
                Konfigurasi Web</a>
            </div>
          </div>
          <!-- /.card-header -->
          <?php if (!empty($_GET['notif'])) {
            if ($_GET['notif'] == "editberhasil") { ?>
              <div class="alert alert-success" role="alert">
                Data Berhasil Diubah</div>
            <?php } ?>
          <?php } ?>

          <table class="table table-bordered">
            <tbody>
              <tr>
                <td colspan="2"><i class="fas fa-user-circle"></i> <strong>KONFIGURASI WEB<strong></td>
              </tr>
              <tr>
                <td width="20%"><strong>Logo<strong></td>
                <td width="80%"><img src="/laprona/images/<?php echo $logo; ?>" class="img-fluid" width="200px;"></td>
              </tr>
              <tr>
                <td width="20%"><strong>Nama Web<strong></td>
                <td width="80%"><?php echo $nama_web; ?></td>
              </tr>
              <tr>
                <td width="20%"><strong>Tahun<strong></td>
                <td width="80%"><?php echo $tahun; ?></td>
              </tr>
            </tbody>
          </table>
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