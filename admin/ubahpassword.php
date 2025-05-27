<?php
session_start();
include('../koneksi/koneksi.php');

$id_user = $_SESSION['id_user'];

if (isset($_POST['ubah_password'])) {
  $password_lama = md5($_POST['password_lama']);
  $password_baru = $_POST['password_baru'];
  $konfirmasi = $_POST['konfirmasi_password'];

  $result = mysqli_query($koneksi, "SELECT password FROM user WHERE id_user = '$id_user'");
  $row = mysqli_fetch_assoc($result);

  if (!$row) {
    echo '<div class="alert alert-danger">User tidak ditemukan.</div>';
    exit;
  }

  $password_hash_db = $row['password'];
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
              <h3><i class="fas fa-user-lock"></i> Ubah Password</h3>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="far fa-list-alt"></i> Form Pengaturan Password</h3>
          </div>

          <form class="form-horizontal" method="POST" action="">

            <div class="card-body">
              <h6>
                <i class="text-blue"><i class="fas fa-info-circle"></i> Silakan masukkan password lama dan password baru
                  Anda.</i>
              </h6>
              <br>

              <div class="col-sm-12">
                <?php
                if (empty($_POST['password_lama'])) {
                  echo '<div class="alert alert-danger">Password lama wajib diisi.</div>';
                } elseif (empty($password_baru)) {
                  echo '<div class="alert alert-danger">Password baru wajib diisi.</div>';
                } elseif (empty($konfirmasi)) {
                  echo '<div class="alert alert-danger">Konfirmasi password baru wajib diisi.</div>';
                } elseif ($password_lama !== $password_hash_db) {
                  echo '<div class="alert alert-danger">Password lama tidak sesuai.</div>';
                } elseif ($password_baru !== $konfirmasi) {
                  echo '<div class="alert alert-danger">Konfirmasi password tidak cocok.</div>';
                } else {
                  $password_baru_hash = md5($password_baru);
                  $update = mysqli_query($koneksi, "UPDATE user SET password = '$password_baru_hash' WHERE id_user = '$id_user'");

                  if ($update) {
                    echo '<div class="alert alert-success">Password berhasil diubah.</div>';
                  } else {
                    echo '<div class="alert alert-danger">Gagal mengubah password.</div>';
                  }
                }
                ?>
              </div>

              <div class="form-group row">
                <label for="pass_lama" class="col-sm-3 col-form-label">Password Lama</label>
                <div class="col-sm-7">
                  <input type="password" class="form-control" name="password_lama" id="pass_lama" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="pass_baru" class="col-sm-3 col-form-label">Password Baru</label>
                <div class="col-sm-7">
                  <input type="password" class="form-control" name="password_baru" id="pass_baru" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="konfirmasi" class="col-sm-3 col-form-label">Konfirmasi Password Baru</label>
                <div class="col-sm-7">
                  <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi" required>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="col-sm-10">
                <button type="submit" name="ubah_password" class="btn btn-info float-right">
                  <i class="fas fa-save"></i> Simpan
                </button>
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