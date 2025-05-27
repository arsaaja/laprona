<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_GET['data'])) {

  $id_mentor = $_GET['data'];
  $_SESSION['id_mentor'] = $id_mentor;
  $sql_d = "select `nama_mentor` from `mentor` where
  `id_mentor` = '$id_mentor'";
  $query_d = mysqli_query($koneksi, $sql_d);
  while ($data_d = mysqli_fetch_row($query_d)) {
    $nama_mentor = $data_d[0];
  }
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
              <h3><i class="fas fa-edit"></i> Edit Mentor</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="mentor.php">Mentor</a></li>
                <li class="breadcrumb-item active">Edit Mentor</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit Mentor</h3>
            <div class="card-tools">
              <a href="mentor.php" class="btn btn-sm btn-warning float-right"><i
                  class="fas fa-arrow-alt-circle-left"></i>
                Kembali</a>
            </div>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          </br>
          <?php if (!empty($_GET['notif'])) { ?>
            <?php if ($_GET['notif'] == "editkosong") { ?>
              <div class="alert alert-danger" role="alert">
                Maaf data mentor wajib di isi</div>
            <?php } ?>
          <?php } ?>
          <form class="form-horizontal" method="post" action="mentor_konfirmasiedit.php">
            <div class="card-body">
              <div class="form-group row" method="post" action="mentor_konfirmasiedit.php">
                <label for="Tag" class="col-sm-3 col-form-label">Mentor</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="mentor" name="nama_mentor"
                    value="<?php echo $nama_mentor; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="bidang_ajar" class="col-sm-3 col-form-label">Bidang Ajar</label>
                <div class="col-sm-7">
                  <select class="form-control" name="id_bidang_ajar" required>
                    <option value="">-- Pilih Bidang Ajar --</option>
                    <?php
                    $sql_b = "SELECT id_bidang_ajar, nama_bidang FROM bidang_ajar ORDER BY nama_bidang";
                    $query_b = mysqli_query($koneksi, $sql_b);
                    while ($data_b = mysqli_fetch_array($query_b)) {
                      $selected = ($data_b['id_bidang_ajar'] == $id_bidang_ajar) ? 'selected' : '';
                      echo "<option value='" . $data_b['id_bidang_ajar'] . "' $selected>" . $data_b['nama_bidang'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <div class="col-sm-10">
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