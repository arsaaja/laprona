<?php
session_start();
include('../koneksi/koneksi.php');

$nama_materi = "";
$isi_materi = "";
$id_subjek_terpilih = "";
$id_kelas_terpilih = "";

if (isset($_GET['data'])) {
    $id_materi = mysqli_real_escape_string($koneksi, $_GET['data']); 
    $_SESSION['id_materi'] = $id_materi; 

    $sql_d = "SELECT m.nama_materi, m.isi_materi, m.id_subjek, m.id_kelas
              FROM `materi` m
              WHERE m.id_materi = '$id_materi'";

    $query_d = mysqli_query($koneksi, $sql_d);

    while ($data_d = mysqli_fetch_assoc($query_d)) { 
        $nama_materi = $data_d['nama_materi'];
        $isi_materi = $data_d['isi_materi'];
        $id_subjek_terpilih = $data_d['id_subjek'];
        $id_kelas_terpilih = $data_d['id_kelas'];
    }
} else {
    header("Location: materi.php");
    exit();
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
                            <h3><i class="fas fa-edit"></i> Edit Materi</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="materi.php">Materi</a></li>
                                <li class="breadcrumb-item active">Edit Materi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

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
                    </br>
                    <?php if (!empty($_GET['notif'])) { ?>
                        <?php if ($_GET['notif'] == "editkosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Maaf data wajib di isi (Nama Materi, Isi Materi, Subjek, dan Kelas).</div>
                        <?php } ?>
                    <?php } ?>
                    <form class="form-horizontal" method="post" action="materi_konfirmasiedit.php">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nama_materi" class="col-sm-3 col-form-label">Nama Materi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="nama_materi" name="nama_materi"
                                        value="<?php echo htmlspecialchars($nama_materi); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isi_materi" class="col-sm-3 col-form-label">Isi Materi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="isi_materi" name="isi_materi"
                                        value="<?php echo htmlspecialchars($isi_materi); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subjek_kelas" class="col-sm-3 col-form-label">Subjek Kelas</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="subjek_kelas" name="id_subjek">
                                        <option value="">- Pilih Subjek Kelas -</option>
                                        <?php
                                        // Ambil data subjek kelas untuk dropdown
                                        $sql_subjek = "SELECT id_subjek_kelas, subjek_kelas FROM `subjek_kelas` ORDER BY subjek_kelas";
                                        $query_subjek = mysqli_query($koneksi, $sql_subjek);
                                        while ($data_subjek = mysqli_fetch_assoc($query_subjek)) {
                                            $id_subjek_option = $data_subjek['id_subjek_kelas'];
                                            $nama_subjek_option = $data_subjek['subjek_kelas'];
                                            $selected = ($id_subjek_option == $id_subjek_terpilih) ? 'selected' : '';
                                            echo "<option value=\"$id_subjek_option\" $selected>" . htmlspecialchars($nama_subjek_option) . "</option>";
                                        }
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
                                        $sql_kelas = "SELECT id_kelas, nama_kelas FROM `kelas` ORDER BY nama_kelas";
                                        $query_kelas = mysqli_query($koneksi, $sql_kelas);
                                        while ($data_kelas = mysqli_fetch_assoc($query_kelas)) {
                                            $id_kelas_option = $data_kelas['id_kelas'];
                                            $nama_kelas_option = $data_kelas['nama_kelas'];
                                            $selected = ($id_kelas_option == $id_kelas_terpilih) ? 'selected' : '';
                                            echo "<option value=\"$id_kelas_option\" $selected>" . htmlspecialchars($nama_kelas_option) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-info float-right"><i class="fas fa-save"></i>
                                    Simpan</button>
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