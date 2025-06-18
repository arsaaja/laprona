<?php
include('../koneksi/koneksi.php');
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
                            <h3><i class="fas fa-plus"></i> Tambah Tugas</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="tugas.php">Tugas</a></li>
                                <li class="breadcrumb-item active">Tambah Tugas</li>
                            </ol>
                        </div>
                    </div>
                </div></section>

            <section class="content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Tambah
                            Tugas</h3>
                        <div class="card-tools">
                            <a href="tugas.php" class="btn btn-sm btn-warning float-right"><i
                                    class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                        </div>
                    </div>
                    </br>
                    <?php if (!empty($_GET['notif'])) { ?>
                        <?php if ($_GET['notif'] == "tambahkosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Maaf data tugas wajib di isi</div>
                        <?php } elseif ($_GET['notif'] == "kelasKosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Pilih Kelas untuk tugas.</div>
                        <?php } elseif ($_GET['notif'] == "subjekKosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Pilih Subjek untuk tugas.</div>
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
                                <label for="tugas_content" class="col-sm-3 col-form-label">Isi Tugas</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" id="tugas_content" name="tugas_content" rows="5"
                                        required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="skor_tugas" class="col-sm-3 col-form-label">Skor Tugas</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" id="skor_tugas" name="skor_tugas"
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deadline_tugas" class="col-sm-3 col-form-label">Deadline Tugas</label>
                                <div class="col-sm-7">
                                    <input type="datetime-local" class="form-control" id="deadline_tugas"
                                        name="deadline_tugas" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_kelas" class="col-sm-3 col-form-label">Kelas</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="id_kelas" name="id_kelas" required>
                                        <option value="">- Pilih Kelas -</option>
                                        <?php
                                        // Fetch all classes
                                        $sql_kelas = "SELECT `id_kelas`, `nama_kelas` FROM `kelas` ORDER BY `nama_kelas`";
                                        $query_kelas = mysqli_query($koneksi, $sql_kelas);
                                        while ($data_kelas = mysqli_fetch_assoc($query_kelas)) {
                                            $id_kelas = $data_kelas['id_kelas'];
                                            $nama_kelas = $data_kelas['nama_kelas'];
                                            echo "<option value=\"$id_kelas\">$nama_kelas</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_subjek" class="col-sm-3 col-form-label">Subjek</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="id_subjek" name="id_subjek" required>
                                        <option value="">- Pilih Subjek -</option>
                                        <?php
                                        $sql_subjek = "SELECT `id_subjek_kelas`, `subjek_kelas` FROM `subjek_kelas` ORDER BY `subjek_kelas`";
                                        $query_subjek = mysqli_query($koneksi, $sql_subjek);
                                        while ($data_subjek = mysqli_fetch_assoc($query_subjek)) {
                                            $id_subjek = $data_subjek['id_subjek_kelas'];
                                            $subjek_kelas = $data_subjek['subjek_kelas'];
                                            echo "<option value=\"$id_subjek\">$subjek_kelas</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i>
                                    Tambah</button>
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