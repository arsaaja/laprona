<?php
include('../koneksi/koneksi.php');
if ((isset($_GET['aksi'])) && (isset($_GET['data']))) {
    if ($_GET['aksi'] == 'hapus') {
        $id_materi = $_GET['data'];
        $sql_dh = "delete from `materi`
            where `id_materi` = '$id_materi'";
        mysqli_query($koneksi, $sql_dh);
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
                            <h3><i class="fas fa-jenjang"></i> Materi</h3>

                        </div>

                    </div>
                    <a href="materi_tambah.php" class="btn btn-primary mb-3">+ Tambah Materi</a>

                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-12">

                            <form method="get" action="materi.php">
                                <div class="row">
                                    <div class="col-md-4 bottom-10">
                                        <input type="text" class="form-control" placeholder="Cari materi..."
                                            id="kata_kunci" name="katakunci">
                                    </div>
                                    <div class="col-md-5 bottom-10">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fas fa-search"></i>&nbsp; Search</button>
                                    </div>
                                </div><!-- .row -->
                            </form>
                        </div><br>

                        <div class="col-sm-12">
                            <?php if (!empty($_GET['notif'])) { ?>
                                <?php if ($_GET['notif'] == "tambahberhasil") { ?>
                                    <div class="alert alert-success" role="alert">
                                        Data Berhasil Ditambahkan</div>
                                <?php } else if ($_GET['notif'] == "editberhasil") { ?>
                                        <div class="alert alert-success" role="alert">
                                            Data Berhasil Diubah</div>
                                <?php } else if ($_GET['notif'] == "hapusberhasil") { ?>
                                            <div class="alert alert-success" role="alert">
                                                Data Berhasil Dihapus</div>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="35%">Judul Materi</th>
                                    <th width="35%">Link Materi</th>
                                    <th width="15%">
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $batas = 10;
                                if (!isset($_GET['halaman'])) {
                                    $posisi = 0;
                                    $halaman = 1;
                                } else {
                                    $halaman = $_GET['halaman'];
                                    $posisi = ($halaman - 1) * $batas;
                                }
                                $sql_u = "SELECT id_materi, nama_materi, isi_materi FROM materi";
                                if (isset($_GET["katakunci"])) {
                                    $katakunci_materi = $_GET["katakunci"];
                                    $sql_u .= " where nama_materi LIKE '%$katakunci_materi%' OR isi_materi LIKE '%$katakunci_materi%'";
                                }
                                $sql_u .= " ORDER BY nama_materi limit $posisi, $batas ";
                                $query_u = mysqli_query($koneksi, $sql_u);
                                $no = 1;
                                while ($data_u = mysqli_fetch_assoc($query_u)) {
                                    $id_materi = $data_u['id_materi'];
                                    $nama_materi = $data_u['nama_materi'];
                                    $isi_materi = $data_u['isi_materi'];
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $nama_materi; ?></td>
                                        <td><?php echo $isi_materi; ?></td>
                                        <td align="center">
                                            <a href="materi_edit.php?data=<?php echo
                                                $id_materi ?>" class="btn btn-sm btn-warning"><i
                                                    class="fas fa-edit"></i> Edit</a>
                                            <a href="javascript:if(confirm('Anda yakin ingin menghapus data
                    <?php echo $nama_materi; ?>?'))window.location.href =
                    'materi.php?aksi=hapus&data=<?php echo
                        $id_materi; ?>&notif=hapusberhasil'" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                Hapus</a>
                                        </td>
                                    </tr>
                                    <?php $no++;
                                } ?>
                            </tbody>
                        </table>
                    </div>


                    <?php
                    //hitung jumlah semua data
                    
                    $sql_jum = "SELECT nama_materi, isi_materi FROM materi ORDER BY nama_materi";
                    if (isset($_GET["katakunci"])) {
                        $katakunci_materi = $_GET["katakunci"];
                        $sql_jum .= " where nama_materi LIKE '%$katakunci_materi%' OR isi_materi LIKE '%$katakunci_materi%'";
                    }

                    $query_jum = mysqli_query($koneksi, $sql_jum);
                    $jum_data = mysqli_num_rows($query_jum);
                    $jum_halaman = ceil($jum_data / $batas);
                    ?>


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
                                    $katakunci_materi = $_GET["katakunci"];
                                    if ($halaman != 1) {
                                        echo "<li class='page-item'><a class='page-link'href='materi.php?katakunci=$katakunci_materi&halaman=1'>First</a></li>";
                                        echo "<li class='page-item'><a class='page-link'href='materi.php?katakunci=$katakunci_materi&halaman=$sebelum'>«</a></li>";
                                    }
                                    for ($i = 1; $i <= $jum_halaman; $i++) {
                                        if ($i > $halaman - 5 and $i < $halaman + 5) {
                                            if ($i != $halaman) {
                                                echo "<li class='page-item'><a class='page-link'href='materi.php?katakunci=$katakunci_materi&halaman=$i'>$i</a></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                                            }
                                        }
                                    }
                                } else {
                                    if ($halaman != 1) {
                                        echo "<li class='page-item'><a class='page-link'href='materi.php?halaman=1'>First</a></li>";
                                        echo "<li class='page-item'><a class='page-link'href='materi.php?halaman=$sebelum'>«</a></li>";
                                    }
                                    for ($i = 1; $i <= $jum_halaman; $i++) {
                                        if ($i > $halaman - 5 and $i < $halaman + 5) {
                                            if ($i != $halaman) {
                                                echo "<li class='page-item'><a class='page-link'href='materi.php?halaman=$i'>$i</a></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                                            }
                                        }
                                    }
                                    if ($halaman != $jum_halaman) {
                                        echo "<li class='page-item'><a class='page-link' href='siswa.php?halaman=$setelah'> »</a></li>";
                                        echo "<li class='page-item'><a class='page-link'href='siswa.php?halaman=$jum_halaman'>Last</a></li>";
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