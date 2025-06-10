<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_GET['data'])) {

    $id_siswa = $_GET['data'];
    $_SESSION['id_siswa'] = $id_siswa;
    $sql_d = "SELECT siswa.id_siswa, user.nama AS nama_siswa, kelas.nama_kelas 
                    FROM siswa 
                    LEFT JOIN user ON siswa.id_user = user.id_user 
                    LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas WHERE `id_siswa` = '$id_siswa'";
    $query_d = mysqli_query($koneksi, $sql_d);
    while ($data_d = mysqli_fetch_row($query_d)) {
        $nama_siswa = $data_d[0];
        $id_kelas_siswa = $data_d[1];
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
                            <h3><i class="fas fa-plus"></i> Tambah Siswa</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="siswa.php">Siswa</a></li>
                                <li class="breadcrumb-item active">Tambah Siswa</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Tambah
                            Siswa</h3>
                        <div class="card-tools">
                            <a href="siswa.php" class="btn btn-sm btn-warning float-right"><i
                                    class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    </br>
                    <?php if (!empty($_GET['notif'])) { ?>
                        <?php if ($_GET['notif'] == "tambahkosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Maaf data siswa wajib di isi</div>
                        <?php } ?>
                    <?php } ?>
                    <form class="form-horizontal" method="post" action="siswa_konfirmasitambah.php">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="mentor" class="col-sm-3 col-form-label">Nama Siswa</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="mentor" name="nama_siswa" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_kelas" class="col-sm-3 col-form-label">Nama Kelas</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="id_kelas" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php
                                        $sql_b = "SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas";
                                        $query_b = mysqli_query($koneksi, $sql_b);
                                        while ($data_b = mysqli_fetch_array($query_b)) {
                                            $selected = ($data_b['id_kelas'] == $id_kelas) ? 'selected' : '';
                                            echo "<option value='" . $data_b['id_kelas'] . "' $selected>" . $data_b['nama_kelas'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i>
                                    Tambah</button>
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