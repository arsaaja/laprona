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
                            <h3><i class="fas fa-plus"></i> Tambah Tugas</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="tugas.php">Tugas</a></li>
                                <li class="breadcrumb-item active">Tambah Tugas</li>
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
                            Tugas</h3>
                        <div class="card-tools">
                            <a href="mentor.php" class="btn btn-sm btn-warning float-right"><i
                                    class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    </br>
                    <?php if (!empty($_GET['notif'])) { ?>
                        <?php if ($_GET['notif'] == "tambahkosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Maaf data tugas wajib di isi</div>
                        <?php } ?>
                    <?php } ?>
                    <form class="form-horizontal" method="post" action="tugas_konfirmasitambah.php">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="judul_tugas" class="col-sm-3 col-form-label">Judul Tugas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="judul_tugas" name="judul_tugas"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="skor" class="col-sm-3 col-form-label">Skor Tugas</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" id="skor_tugas" name="skor_tugas"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="deadline" class="col-sm-3 col-form-label">Deadline Tugas</label>
                                <div class="col-sm-7">
                                    <input type="datetime-local" class="form-control" id="deadline_tugas"
                                        name="deadline_tugas" required>
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