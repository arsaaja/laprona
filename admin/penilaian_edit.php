<?php
session_start();
include('../koneksi/koneksi.php');

// Pastikan ada data 'id_penilaian' yang dikirim melalui GET
if (isset($_GET['data'])) {
    $id_penilaian = mysqli_real_escape_string($koneksi, $_GET['data']);
    // Simpan id_penilaian di session untuk digunakan pada halaman konfirmasi
    $_SESSION['id_penilaian'] = $id_penilaian;

    // Query untuk mengambil detail penilaian beserta informasi tugas dan siswa
    $sql_penilaian = "SELECT
                        p.nilai,
                        u.nama AS nama_siswa,
                        t.judul_tugas,
                        sk.subjek_kelas,
                        pt.waktu_submit
                      FROM
                        `penilaian` p
                      JOIN
                        `siswa` s ON p.id_siswa = s.id_siswa
                      JOIN
                        `user` u ON s.id_user = u.id_user
                      JOIN
                        `pengumpulan_tugas` pt ON p.id_pengumpulan = pt.id_pengumpulan
                      JOIN
                        `tugas` t ON pt.id_tugas = t.id_tugas
                      JOIN
                        `subjek_kelas` sk ON p.id_subjek = sk.id_subjek_kelas
                      WHERE
                        p.id_penilaian = '$id_penilaian'";

    $query_penilaian = mysqli_query($koneksi, $sql_penilaian);

    // Periksa apakah data ditemukan
    if (mysqli_num_rows($query_penilaian) > 0) {
        $data_penilaian = mysqli_fetch_assoc($query_penilaian);
        $nilai = $data_penilaian['nilai'];
        $nama_siswa = $data_penilaian['nama_siswa'];
        $judul_tugas = $data_penilaian['judul_tugas'];
        $subjek_kelas = $data_penilaian['subjek_kelas'];
        $waktu_submit = $data_penilaian['waktu_submit'];
    } else {
        // Jika id_penilaian tidak ditemukan, redirect atau tampilkan pesan error
        header("Location: penilaian.php?notif=datanotfound");
        exit();
    }
} else {
    // Jika tidak ada id_penilaian di URL, redirect kembali ke halaman penilaian
    header("Location: penilaian.php");
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
                            <h3><i class="fas fa-clipboard-check"></i> Edit Penilaian Tugas</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="penilaian.php">Penilaian</a></li>
                                <li class="breadcrumb-item active">Edit Penilaian</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit
                            Penilaian
                        </h3>
                        <div class="card-tools">
                            <a href="penilaian.php" class="btn btn-sm btn-warning float-right"><i
                                    class="fas fa-arrow-alt-circle-left"></i>
                                Kembali</a>
                        </div>
                    </div>
                    <br>
                    <?php if (!empty($_GET['notif'])) { ?>
                        <?php if ($_GET['notif'] == "nilaikosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Maaf nilai wajib di isi.</div>
                        <?php } elseif ($_GET['notif'] == "datanotfound") { ?>
                            <div class="alert alert-danger" role="alert">
                                Data penilaian tidak ditemukan.</div>
                        <?php } ?>
                    <?php } ?>

                    <form class="form-horizontal" method="post" action="penilaian_konfirmasiedit.php">
                        <div class="card-body">
                            <input type="hidden" name="id_penilaian"
                                value="<?php echo htmlspecialchars($id_penilaian); ?>">

                            <div class="form-group row">
                                <label for="judul_tugas_display" class="col-sm-3 col-form-label">Judul Tugas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="judul_tugas_display"
                                        value="<?php echo htmlspecialchars($judul_tugas ?? ''); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_siswa_display" class="col-sm-3 col-form-label">Nama Siswa</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="nama_siswa_display"
                                        value="<?php echo htmlspecialchars($nama_siswa ?? ''); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subjek_kelas_display" class="col-sm-3 col-form-label">Mata Pelajaran</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="subjek_kelas_display"
                                        value="<?php echo htmlspecialchars($subjek_kelas ?? ''); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="waktu_submit_display" class="col-sm-3 col-form-label">Tanggal
                                    Pengumpulan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="waktu_submit_display"
                                        value="<?php echo htmlspecialchars($waktu_submit ?? ''); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nilai" class="col-sm-3 col-form-label">Nilai</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" id="nilai" name="nilai"
                                        value="<?php echo htmlspecialchars($nilai ?? ''); ?>" required min="0"
                                        max="100">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-info float-right"><i class="fas fa-save"></i>
                                    Simpan Penilaian</button>
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