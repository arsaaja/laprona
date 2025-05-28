<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_GET['data'])) {
    $id_materi = $_GET['data'];
    $_SESSION['id_materi'] = $id_materi;
    $sql_d = "SELECT `nama_materi`, `isi_materi` FROM `materi` WHERE `id_materi` = '$id_materi'";
    $query_d = mysqli_query($koneksi, $sql_d);
    while ($data_d = mysqli_fetch_row($query_d)) {
        $nama_materi = $data_d[0];
        $isi_materi = $data_d[1];
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
                            <h3><i class="fas fa-edit"></i> Edit Materi</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="materi.php">Materi</a></li>
                                <li class="breadcrumb-item active">Edit Materi</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit Materi
                        </h3>
                        <div class="card-tools">
                            <a href="materi.php" class="btn btn-sm btn-warning float-right"><i
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
                                Maaf data materi wajib di isi</div>
                        <?php } ?>
                    <?php } ?>
                    <form class="form-horizontal" method="post" action="materi_konfirmasiedit.php">
                        <div class="card-body">
                            <div class="form-group row" method="post" action="materi_konfirmasiedit.php">
                                <label for="materi" class="col-sm-3 col-form-label">Materi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="materi" name="nama_materi"
                                        value="<?php echo $nama_materi; ?>">
                                </div>
                            </div>
                            <div class="form-group row" method="post" action="materi_konfirmasiedit.php">
                                <label for="materi" class="col-sm-3 col-form-label">Link Materi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="materi" name="isi_materi"
                                        value="<?php echo $isi_materi; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-info float-right"><i class="fas fa-save"></i>
                                    Simpan</button>
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