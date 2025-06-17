<?php
include('../koneksi/koneksi.php');
session_start();
if (isset($_SESSION['id_user'])) {
  $id_user = $_SESSION['id_user'];

  $sql_d = "select nama, email, role from user where id_user = '$id_user'";
  $query_d = mysqli_query($koneksi, $sql_d);
  while ($data_d = mysqli_fetch_row($query_d)) {
    $nama = $data_d[0];
    $email = $data_d[1];
    $role = $data_d[2];
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

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3><i class="fas fa-edit"></i> Edit Profil</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="profil.php">Profil</a></li>
                <li class="breadcrumb-item active">Edit Profil</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit Profil</h3>
            <div class="card-tools">
              <a href="profil.php" class="btn btn-sm btn-warning float-right"><i
                  class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
            </div>
          </div>
          </br>

          <?php if ((!empty($_GET['notif'])) && (!empty($_GET['jenis']))) { ?>
            <?php if ($_GET['notif'] == "editkosong") { ?>
              <div class="alert alert-danger" role="alert">Maaf data
                <?php echo $_GET['jenis']; ?> wajib di isi
              </div>
            <?php } ?>
          <?php } ?>

          <form class="form-horizontal" method="post" action="profil_konfirmasiedit.php" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group row">
                <label for="foto" class="col-sm-12 col-form-label"><span class="text-info">
                    <i class="fas fa-user-circle"></i> <u>PROFIL USER</u></span></label>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="role" class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="role" id="role" value="<?php echo $role; ?>" readonly>
                  <small class="form-text text-muted">Role tidak bisa diubah dari halaman ini.</small>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-info float-right"><i class="fas fa-save"></i> Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
    <?php include("includes/footer.php") ?>

  </div>
  <?php include("includes/script.php") ?>
</body>

</html>