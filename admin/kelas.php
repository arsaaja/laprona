<?php
include('../koneksi/koneksi.php');

if (isset($_GET['aksi']) && isset($_GET['data'])) {
    if ($_GET['aksi'] == 'hapus') {
        $id_kelas = $_GET['data'];
        $sql_dh = "DELETE FROM `kelas` WHERE `id_kelas` = '$id_kelas'";
        mysqli_query($koneksi, $sql_dh);
        header("Location: kelas.php?notif=hapusberhasil");
        exit;
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
                            <h3><i class="fas fa-jenjang"></i> Kelas</h3>
                        </div>
                    </div>
                    <a href="kelas_tambah.php" class="btn btn-primary mb-3">+ Tambah Kelas</a>
                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-body">
                        <form method="get" action="kelas.php">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <input type="text" class="form-control" placeholder="Cari kelas..." name="katakunci"
                                        value="<?php echo isset($_GET['katakunci']) ? $_GET['katakunci'] : ''; ?>">
                                </div>
                                <div class="col-md-5 mb-2">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp;
                                        Search</button>
                                </div>
                            </div>
                        </form>
                        <br>

                        <?php if (!empty($_GET['notif'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?php
                                if ($_GET['notif'] == "tambahberhasil")
                                    echo "Data Berhasil Ditambahkan";
                                else if ($_GET['notif'] == "editberhasil")
                                    echo "Data Berhasil Diubah";
                                else if ($_GET['notif'] == "hapusberhasil")
                                    echo "Data Berhasil Dihapus";
                                ?>
                            </div>
                        <?php endif; ?>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Kelas</th>
                                    <th width="30%">Subjek Kelas</th>
                                    <th width="20%">Jenjang Pendidikan</th>
                                    <th width="10%">Jumlah Siswa</th>
                                    <th width="15%">
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $batas = 10;
                                $halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
                                $posisi = ($halaman - 1) * $batas;

                                $katakunci = isset($_GET['katakunci']) ? $_GET['katakunci'] : '';

                                $sql = "SELECT k.*, jp.nama_jenjang, 
                                       (SELECT COUNT(*) FROM siswa s WHERE s.id_kelas = k.id_kelas) AS jumlah_siswa 
                                        FROM kelas k
                                        LEFT JOIN jenjang_pendidikan jp ON k.id_jenjang = jp.id_jenjang_pendidikan";

                                if (!empty($katakunci)) {
                                    $sql .= " WHERE k.nama_kelas LIKE '%$katakunci%' OR k.subjek_kelas LIKE '%$katakunci%'";
                                }

                                $sql .= " ORDER BY k.nama_kelas ASC LIMIT $posisi, $batas";

                                $query = mysqli_query($koneksi, $sql);
                                $no = $posisi + 1;

                                while ($data = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data['nama_kelas']; ?></td>
                                        <td><?php echo $data['subjek_kelas']; ?></td>
                                        <td><?php echo $data['nama_jenjang']; ?></td>
                                        <td><?php echo $data['jumlah_siswa']; ?></td>
                                        <td align="center">
                                            <a href="kelas_edit.php?data=<?php echo $data['id_kelas'] ?>"
                                                class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="kelas.php?aksi=hapus&data=<?php echo $data['id_kelas'] ?>"
                                                onclick="return confirm('Yakin ingin hapus?')"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <?php
                        // hitung total data
                        $sql_count = "SELECT COUNT(*) AS total FROM kelas k LEFT JOIN jenjang_pendidikan jp ON k.id_jenjang = jp.id_jenjang_pendidikan";
                        if (!empty($katakunci)) {
                            $sql_count .= " WHERE k.nama_kelas LIKE '%$katakunci%' OR k.subjek_kelas LIKE '%$katakunci%'";
                        }
                        $res_count = mysqli_query($koneksi, $sql_count);
                        $data_count = mysqli_fetch_assoc($res_count);
                        $jum_data = $data_count['total'];
                        $jum_halaman = ceil($jum_data / $batas);
                        ?>s


                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination justify-content-center mt-3">
                                <?php
                                if ($jum_halaman == 0) {
                                    //tidak ada halaman
                                } else if ($jum_halaman == 1) {
                                    echo "<li class='page-item'><a class='page-link'>1</a></li>";
                                } else {
                                    $sebelum = $halaman - 1;
                                    $setelah = $halaman + 1;
                                    if (isset($_GET["katakunci"])) {
                                        $katakunci_kelas = $_GET["katakunci"];
                                        if ($halaman != 1) {
                                            echo "<li class='page-item'><a class='page-link'href='kelas.php?katakunci=$katakunci_kelas&halaman=1'>First</a></li>";
                                            echo "<li class='page-item'><a class='page-link'href='kelas.php?katakunci=$katakunci_kelas&halaman=$sebelum'>«</a></li>";
                                        }
                                        for ($i = 1; $i <= $jum_halaman; $i++) {
                                            if ($i > $halaman - 5 and $i < $halaman + 5) {
                                                if ($i != $halaman) {
                                                    echo "<li class='page-item'><a class='page-link'href='kelas.php?katakunci=$katakunci_kelas&halaman=$i'>$i</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                                                }
                                            }
                                        }
                                    } else {
                                        if ($halaman != 1) {
                                            echo "<li class='page-item'><a class='page-link'href='kelas.php?halaman=1'>First</a></li>";
                                            echo "<li class='page-item'><a class='page-link'href='kelas.php?halaman=$sebelum'>«</a></li>";
                                        }
                                        for ($i = 1; $i <= $jum_halaman; $i++) {
                                            if ($i > $halaman - 5 and $i < $halaman + 5) {
                                                if ($i != $halaman) {
                                                    echo "<li class='page-item'><a class='page-link'href='kelas.php?halaman=$i'>$i</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                                                }
                                            }
                                        }
                                        if ($halaman != $jum_halaman) {
                                            echo "<li class='page-item'><a class='page-link' href='kelas.php?halaman=$setelah'> »</a></li>";
                                            echo "<li class='page-item'><a class='page-link'href='kelas.php?halaman=$jum_halaman'>Last</a></li>";
                                        }
                                    }
                                } ?>
                            </ul>
                        </div>
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