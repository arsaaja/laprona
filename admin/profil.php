<?php
session_start();
include('../koneksi/koneksi.php');
$id_user = $_SESSION['id_user'];

$sql = "select nama, email, role from user where id_user='$id_user'";
$query = mysqli_query($koneksi, $sql);
while ($data = mysqli_fetch_row($query)) {
  $nama = $data[0];
  $email = $data[1];
  $role = $data[2];
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
              <h3><i class="fas fa-user-tie"></i> Profil</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Profil</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <a href="profil_edit.php" class="btn btn-sm btn-info float-right"><i class="fas fa-edit"></i> Edit
                Profil</a>
            </div>
          </div>
          <div class="card-body">
            <div class="col-sm-12">
              <div class="alert alert-success" role="alert">Data Berhasil Diambil</div>
            </div>
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="2"><i class="fas fa-user-circle"></i> <strong>PROFIL<strong></td>
                </tr>
                <tr>
                  <td width="20%"><strong>Nama<strong></td>
                  <td width="80%"><?php echo $nama; ?></td>
                </tr>
                <tr>
                  <td width="20%"><strong>Email<strong></td>
                  <td width="80%"><?php echo $email; ?></td>
                </tr>
                <tr>
                  <td width="20%"><strong>Role<strong></td>
                  <td width="80%"><?php echo $role; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer clearfix">&nbsp;</div>
        </div>
      </section>
    </div>
    <?php include("includes/footer.php") ?>

  </div>
  <?php include("includes/script.php") ?>
</body>

</html>