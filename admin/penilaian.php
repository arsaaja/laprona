<?php
include('../koneksi/koneksi.php');

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['data'])) {
    $id_penilaian = mysqli_real_escape_string($koneksi, $_GET['data']);
    $sql_dh = "DELETE FROM `penilaian` WHERE `id_penilaian` = '$id_penilaian'";
    mysqli_query($koneksi, $sql_dh);
    header("Location: penilaian.php?notif=hapusberhasil");
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
                            <h3><i class="fas fa-clipboard-check"></i> Penilaian Tugas</h3>
                        </div>
                    </div>

                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Daftar Penilaian
                            Tugas</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <form method="get" action="tugas.php">
                                <div class="row">
                                    <div class="col-md-4 bottom-10">
                                        <input type="text" class="form-control"
                                            placeholder="Cari judul tugas atau nama siswa..." name="katakunci">
                                    </div>
                                    <div class="col-md-5 bottom-10">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                            Search</button>
                                    </div>
                                </div>
                            </form>
                        </div><br>

                        <div class="col-sm-12">
                            <?php if (!empty($_GET['notif'])) {
                                if ($_GET['notif'] == "tambahberhasil") { ?>
                                    <div class="alert alert-success">Penilaian Berhasil Ditambahkan</div>
                                <?php } elseif ($_GET['notif'] == "editberhasil") { ?>
                                    <div class="alert alert-success">Penilaian Berhasil Diubah</div>
                                <?php } elseif ($_GET['notif'] == "hapusberhasil") { ?>
                                    <div class="alert alert-success">Penilaian Berhasil Dihapus</div>
                                <?php }
                            } ?>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Judul Tugas</th>
                                    <th width="20%">Nama Siswa</th>
                                    <th width="15%">Mata Pelajaran</th>
                                    <th width="15%">Tanggal Pengumpulan</th>
                                    <th width="15%">Link Drive</th>
                                    <th width="10%">Nilai</th>
                                    <th width="15%">
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $batas = 5;
                                $posisi = 0;
                                $halaman = 1;
                                if (isset($_GET['halaman'])) {
                                    $halaman = intval($_GET['halaman']);
                                    $posisi = ($halaman - 1) * $batas;
                                }

                                $sql = "SELECT
                                            p.id_penilaian,
                                            p.nilai,
                                            u.nama AS nama_siswa,
                                            t.judul_tugas,
                                            sk.subjek_kelas,
                                            pt.waktu_submit,
                                            pt.link_drive
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
                                            `subjek_kelas` sk ON p.id_subjek = sk.id_subjek_kelas";

                                $where = "";
                                if (isset($_GET["katakunci"])) {
                                    $katakunci = mysqli_real_escape_string($koneksi, $_GET["katakunci"]);
                                    $where = " WHERE t.judul_tugas LIKE '%$katakunci%' OR u.nama LIKE '%$katakunci%'";
                                }

                                $sql .= $where . " ORDER BY t.judul_tugas ASC, nama_siswa ASC LIMIT $posisi, $batas";
                                $query = mysqli_query($koneksi, $sql);
                                $no = $posisi + 1;

                                while ($data = mysqli_fetch_assoc($query)) {
                                    $id_penilaian = $data['id_penilaian'];
                                    $judul_tugas = $data['judul_tugas'];
                                    $nama_siswa = $data['nama_siswa'];
                                    $nama_subjek = $data['subjek_kelas'];
                                    $tanggal_pengumpulan = $data['waktu_submit'];
                                    $nilai = $data['nilai'];
                                    $link_drive = $data['link_drive'];
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $judul_tugas; ?></td>
                                        <td><?php echo $nama_siswa; ?></td>
                                        <td><?php echo $nama_subjek; ?></td>
                                        <td><?php echo $tanggal_pengumpulan; ?></td>
                                        <td><a href="<?php echo $link_drive; ?>"
                                                target="_blank"><?php echo $link_drive; ?></a></td>
                                        <td><?php echo ($nilai !== null) ? $nilai : 'Belum Dinilai'; ?></td>
                                        <td>
                                            <a href="penilaian_edit.php?data=<?php echo $id_penilaian; ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit Nilai
                                            </a>
                                            <a href="javascript:if(confirm('Yakin ingin menghapus penilaian ini?'))window.location.href='tugas.php?aksi=hapus&data=<?php echo $id_penilaian; ?>'"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <?php
                        $sql_count = "SELECT COUNT(p.id_penilaian) AS total
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
                                            `subjek_kelas` sk ON p.id_subjek = sk.id_subjek_kelas";
                        $sql_count .= $where;
                        $result_count = mysqli_query($koneksi, $sql_count);
                        $row_count = mysqli_fetch_assoc($result_count);
                        $jum_data = $row_count['total'];
                        $jum_halaman = ceil($jum_data / $batas);
                        ?>

                        <div class="card-footer clearfix">
                            <ul class="pagination justify-content-center mt-3">
                                <?php
                                if ($jum_halaman == 0) {
                                    //no pages
                                } else if ($jum_halaman == 1) {
                                    echo "<li class='page-item'><a class='page-link'>1</a></li>";
                                } else {
                                    $sebelum = $halaman - 1;
                                    $setelah = $halaman + 1;
                                    $katakunci_param = isset($_GET["katakunci"]) ? "&katakunci=" . $_GET["katakunci"] : "";

                                    if ($halaman != 1) {
                                        echo "<li class='page-item'><a class='page-link'href='tugas.php?halaman=1" . $katakunci_param . "'>First</a></li>";
                                        echo "<li class='page-item'><a class='page-link'href='tugas.php?halaman=$sebelum" . $katakunci_param . "'>«</a></li>";
                                    }
                                    for ($i = 1; $i <= $jum_halaman; $i++) {
                                        if ($i > $halaman - 5 and $i < $halaman + 5) {
                                            if ($i != $halaman) {
                                                echo "<li class='page-item'><a class='page-link'href='tugas.php?halaman=$i" . $katakunci_param . "'>$i</a></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                                            }
                                        }
                                    }
                                    if ($halaman != $jum_halaman) {
                                        echo "<li class='page-item'><a class='page-link' href='tugas.php?halaman=$setelah" . $katakunci_param . "'> »</a></li>";
                                        echo "<li class='page-item'><a class='page-link'href='tugas.php?halaman=$jum_halaman" . $katakunci_param . "'>Last</a></li>";
                                    }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include("includes/footer.php") ?>
    </div>
    <?php include("includes/script.php") ?>
</body>

</html>