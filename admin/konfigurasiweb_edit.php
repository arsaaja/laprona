<?php
include('../koneksi/koneksi.php');
session_start();
$sql_d = "SELECT logo, nama_web, tahun FROM konfigurasi_web where id_konfigurasi_web =  1";
$query_d = mysqli_query($koneksi, $sql_d);
while ($data_d = mysqli_fetch_row($query_d)) {
  $logo = $data_d[0];
  $nama_web = $data_d[1];
  $tahun = $data_d[2];
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
              <h3><i class="fas fa-edit"></i> Edit Konfigurasi Web</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="konfigurasiweb.php">Konfigurasi Web</a></li>
                <li class="breadcrumb-item active">Edit Konfigurasi Web</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit Konfigurasi Web
            </h3>
            <div class="card-tools">
              <a href="konfigurasiweb.php" class="btn btn-sm btn-warning float-right"><i
                  class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
            </div>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          </br>

          <?php if (!empty($_GET['notif'])) { ?>
            <?php if ($_GET['notif'] == "editkosong") { ?>
              <div class="alert alert-danger" role="alert">
                Maaf data nama wajib di isi</div>
            <?php } ?>
          <?php } ?>

          <form class="form-horizontal" method="post" action="konfigurasiweb_konfirmasiedit.php">
            <div class="card-body">
              <div class="form-group row">
                <label for="logo" class="col-sm-12 col-form-label"><span class="text-info">
                    <i class="fa fa-cogs"></i> <u>KONFIGURASI WEB</u></span></label>
              </div>
              <div class="form-group row">
                <label for="logo" class="col-sm-3 col-form-label">Logo Web</label>
                <div class="col-sm-7">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="logo" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama_web" class="col-sm-3 col-form-label">Nama Web</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="nama_web" id="nama_web"
                    value="<?php echo $nama_web; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="tahun" class="col-sm-3 col-form-label">Tahun</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="tahun" id="tahun" value="<?php echo $tahun; ?>">
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-info float-right"><i class="fas fa-save"></i> Simpan</button>
              </div>
            </div>
            <!-- /.card-footer -->
          </form>
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