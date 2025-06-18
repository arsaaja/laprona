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
                            <h3><i class="fas fa-plus"></i> Tambah Materi</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="materi.php">Materi</a></li>
                                <li class="breadcrumb-item active">Tambah Materi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Tambah
                            Materi</h3>
                        <div class="card-tools">
                            <a href="materi.php" class="btn btn-sm btn-warning float-right"><i
                                    class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                        </div>
                    </div>
                    </br>
                    <?php if (!empty($_GET['notif'])) { ?>
                        <?php if ($_GET['notif'] == "tambahkosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Maaf data materi wajib di isi.</div>
                        <?php } else if ($_GET['notif'] == "subjekkosong") { ?>
                                <div class="alert alert-danger" role="alert">
                                    Maaf subjek kelas wajib dipilih.</div>
                        <?php } else if ($_GET['notif'] == "kelaskosong") { ?>
                                    <div class="alert alert-danger" role="alert">
                                        Maaf kelas wajib dipilih.</div>
                        <?php } ?>
                    <?php } ?>
                    <form class="form-horizontal" method="post" action="materi_konfirmasitambah.php">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nama_materi" class="col-sm-3 col-form-label">Nama Materi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="nama_materi" name="nama_materi"
                                        value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isi_materi" class="col-sm-3 col-form-label">Isi Materi
                                    (Link/Deskripsi)</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="isi_materi" name="isi_materi" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subjek_kelas" class="col-sm-3 col-form-label">Subjek Kelas</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="subjek_kelas" name="id_subjek">
                                        <option value="">- Pilih Subjek Kelas -</option>
                                        <?php
                                        include('../koneksi/koneksi.php');
                                        $sql_subjek = "SELECT id_subjek_kelas, subjek_kelas FROM `subjek_kelas` ORDER BY subjek_kelas";
                                        $query_subjek = mysqli_query($koneksi, $sql_subjek);
                                        while ($data_subjek = mysqli_fetch_assoc($query_subjek)) {
                                            $id_subjek_kelas = $data_subjek['id_subjek_kelas'];
                                            $subjek_kelas_nama = $data_subjek['subjek_kelas'];
                                            echo "<option value=\"$id_subjek_kelas\">" . htmlspecialchars($subjek_kelas_nama) . "</option>";
                                        }
                                        mysqli_close($koneksi);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kelas" class="col-sm-3 col-form-label">Kelas</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="kelas" name="id_kelas">
                                        <option value="">- Pilih Kelas -</option>
                                        <?php
                                        include('../koneksi/koneksi.php');
                                        $sql_kelas = "SELECT id_kelas, nama_kelas FROM `kelas` ORDER BY nama_kelas";
                                        $query_kelas = mysqli_query($koneksi, $sql_kelas);
                                        while ($data_kelas = mysqli_fetch_assoc($query_kelas)) {
                                            $id_kelas = $data_kelas['id_kelas'];
                                            $kelas_nama = $data_kelas['nama_kelas'];
                                            echo "<option value=\"$id_kelas\">" . htmlspecialchars($kelas_nama) . "</option>";
                                        }
                                        mysqli_close($koneksi); // Tutup koneksi
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