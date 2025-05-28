<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_GET['data'])) {
    $id_kelas = $_GET['data'];
    $_SESSION['id_kelas'] = $id_kelas;
    $sql_d = "SELECT k.*, jp.nama_jenjang 
          FROM kelas k
          LEFT JOIN jenjang_pendidikan jp ON k.id_jenjang = jp.id_jenjang_pendidikan
          WHERE k.id_kelas = '$id_kelas";
    $query_d = mysqli_query($koneksi, $sql_d);
    while ($data_d = mysqli_fetch_row($query_d)) {
        $nama_kelas = $data_d[0];
        $subjek_kelas = $data_d[1];
        $id_jenjang = $data_d[2];
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
                            <h3><i class="fas fa-plus"></i> Tambah Kelas</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="kelas.php">Kelas</a></li>
                                <li class="breadcrumb-item active">Tambah Kelas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Tambah Kelas
                        </h3>
                        <div class="card-tools">
                            <a href="kelas.php" class="btn btn-sm btn-warning float-right">
                                <i class="fas fa-arrow-alt-circle-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Notifikasi -->
                    <?php if (!empty($_GET['notif']) && $_GET['notif'] == "tambahkosong") { ?>
                        <div class="alert alert-danger m-3" role="alert">
                            Maaf, data kelas wajib diisi.
                        </div>
                    <?php } ?>

                    <form class="form-horizontal" method="post" action="kelas_konfirmasitambah.php">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nama_kelas" class="col-sm-3 col-form-label">Nama Kelas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subjek_kelas" class="col-sm-3 col-form-label">Subjek Kelas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="subjek_kelas" name="subjek_kelas"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_jenjang_pendidikan" class="col-sm-3 col-form-label">Jenjang
                                    Pendidikan</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="id_jenjang_pendidikan" name="id_jenjang_pendidikan"
                                        required>
                                        <option value="">-- Pilih Jenjang Pendidikan --</option>
                                        <?php
                                        $sql_b = "SELECT id_jenjang_pendidikan, nama_jenjang FROM jenjang_pendidikan ORDER BY nama_jenjang";
                                        $query_b = mysqli_query($koneksi, $sql_b);
                                        while ($data_b = mysqli_fetch_array($query_b)) {
                                            echo "<option value='" . $data_b['id_jenjang_pendidikan'] . "'>" . $data_b['nama_jenjang'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-info float-right">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
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