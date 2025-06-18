<?php
include('../koneksi/koneksi.php');

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['data'])) {
    $id_tugas = mysqli_real_escape_string($koneksi, $_GET['data']);
    $sql_dh = "DELETE FROM `tugas` WHERE `id_tugas` = '$id_tugas'";
    mysqli_query($koneksi, $sql_dh);
    header("Location: tugas.php?notif=hapusberhasil");
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
                            <h3><i class="fas fa-tasks"></i> Tugas</h3>
                        </div>
                    </div>
                    <a href="tugas_tambah.php" class="btn btn-primary mb-3">+ Tambah Tugas</a>
                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Daftar Tugas</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <form method="get" action="tugas.php">
                                <div class="row">
                                    <div class="col-md-4 bottom-10">
                                        <input type="text" class="form-control" placeholder="Cari judul tugas..."
                                            name="katakunci">
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
                                    <div class="alert alert-success">Data Berhasil Ditambahkan</div>
                                <?php } elseif ($_GET['notif'] == "editberhasil") { ?>
                                    <div class="alert alert-success">Data Berhasil Diubah</div>
                                <?php } elseif ($_GET['notif'] == "hapusberhasil") { ?>
                                    <div class="alert alert-success">Data Berhasil Dihapus</div>
                                <?php }
                            } ?>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Judul Tugas</th>
                                    <th width="20%">Tugas</th> <?php ?>
                                    <th width="10%">Skor</th>
                                    <th width="15%">Deadline</th>
                                    <th width="10%">Kelas</th> <?php  ?>
                                    <th width="10%">Subjek</th> <?php  ?>
                                    <th width="10%">
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
                                            tugas.id_tugas,
                                            tugas.judul_tugas,
                                            tugas.tugas,
                                            tugas.skor_tugas,
                                            tugas.deadline_tugas,
                                            kelas.nama_kelas,
                                            subjek_kelas.subjek_kelas
                                        FROM
                                            `tugas`
                                        JOIN
                                            `kelas` ON tugas.id_kelas = kelas.id_kelas
                                        JOIN
                                            `subjek_kelas` ON tugas.id_subjek = subjek_kelas.id_subjek_kelas";
                                $where = "";

                                if (isset($_GET["katakunci"])) {
                                    $katakunci = mysqli_real_escape_string($koneksi, $_GET["katakunci"]);
                                    $where = " WHERE
                                                tugas.judul_tugas LIKE '%$katakunci%' OR
                                                tugas.tugas LIKE '%$katakunci%' OR
                                                kelas.nama_kelas LIKE '%$katakunci%' OR
                                                subjek_kelas.subjek_kelas LIKE '%$katakunci%'";
                                }

                                $sql .= $where . " ORDER BY tugas.judul_tugas LIMIT $posisi, $batas";
                                $query = mysqli_query($koneksi, $sql);
                                $no = $posisi + 1;
                                
                                while ($data = mysqli_fetch_assoc($query)) {
                                    $id_tugas = $data['id_tugas'];
                                    $judul_tugas = $data['judul_tugas'];
                                    $tugas_content = $data['tugas']; 
                                    $skor_tugas = $data['skor_tugas'];
                                    $deadline_tugas = $data['deadline_tugas'];
                                    $nama_kelas = $data['nama_kelas']; 
                                    $subjek_kelas = $data['subjek_kelas']; 
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $judul_tugas; ?></td>
                                        <td><?php echo substr($tugas_content, 0, 50) . (strlen($tugas_content) > 50 ? '...' : ''); ?>
                                        </td> <?php  ?>
                                        <td><?php echo $skor_tugas; ?></td>
                                        <td><?php echo $deadline_tugas; ?></td>
                                        <td><?php echo $nama_kelas; ?></td> <?php ?>
                                        <td><?php echo $subjek_kelas; ?></td> <?php ?>
                                        <td align="center">
                                            <a href="tugas_edit.php?data=<?php echo $id_tugas; ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="javascript:if(confirm('Yakin ingin menghapus tugas <?php echo $judul_tugas; ?>?'))window.location.href='tugas.php?aksi=hapus&data=<?php echo $id_tugas; ?>'"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                } ?>
                            </tbody>
                        </table>

                        <?php
                        $sql_count = "SELECT COUNT(*) AS total
                                      FROM `tugas`
                                      JOIN `kelas` ON tugas.id_kelas = kelas.id_kelas
                                      JOIN `subjek_kelas` ON tugas.id_subjek = subjek_kelas.id_subjek_kelas" . $where;
                        $result_count = mysqli_query($koneksi, $sql_count);
                        $row_count = mysqli_fetch_assoc($result_count);
                        $jum_data = $row_count['total'];
                        $jum_halaman = ceil($jum_data / $batas);
                        ?>

                        <div class="card-footer clearfix">
                            <ul class="pagination justify-content-center mt-3">
                                <?php
                                if ($jum_halaman == 0) {
                                } else if ($jum_halaman == 1) {
                                    echo "<li class='page-item'><a class='page-link'>1</a></li>";
                                } else {
                                    $sebelum = $halaman - 1;
                                    $setelah = $halaman + 1;
                                    if (isset($_GET["katakunci"])) {
                                        $katakunci_tugas = $_GET["katakunci"];
                                        if ($halaman != 1) {
                                            echo "<li class='page-item'><a class='page-link'href='tugas.php?katakunci=$katakunci_tugas&halaman=1'>First</a></li>";
                                            echo "<li class='page-item'><a class='page-link'href='tugas.php?katakunci=$katakunci_tugas&halaman=$sebelum'>«</a></li>";
                                        }
                                        for ($i = 1; $i <= $jum_halaman; $i++) {
                                            if ($i > $halaman - 5 and $i < $halaman + 5) {
                                                if ($i != $halaman) {
                                                    echo "<li class='page-item'><a class='page-link'href='tugas.php?katakunci=$katakunci_tugas&halaman=$i'>$i</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                                                }
                                            }
                                        }
                                        if ($halaman != $jum_halaman) {
                                            echo "<li class='page-item'><a class='page-link' href='tugas.php?katakunci=$katakunci_tugas&halaman=$setelah'> »</a></li>";
                                            echo "<li class='page-item'><a class='page-link'href='tugas.php?katakunci=$katakunci_tugas&halaman=$jum_halaman'>Last</a></li>";
                                        }
                                    } else {
                                        if ($halaman != 1) {
                                            echo "<li class='page-item'><a class='page-link'href='tugas.php?halaman=1'>First</a></li>";
                                            echo "<li class='page-item'><a class='page-link'href='tugas.php?halaman=$sebelum'>«</a></li>";
                                        }
                                        for ($i = 1; $i <= $jum_halaman; $i++) {
                                            if ($i > $halaman - 5 and $i < $halaman + 5) {
                                                if ($i != $halaman) {
                                                    echo "<li class='page-item'><a class='page-link'href='tugas.php?halaman=$i'>$i</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                                                }
                                            }
                                        }
                                        if ($halaman != $jum_halaman) {
                                            echo "<li class='page-item'><a class='page-link' href='tugas.php?halaman=$setelah'> »</a></li>";
                                            echo "<li class='page-item'><a class='page-link'href='tugas.php?halaman=$jum_halaman'>Last</a></li>";
                                        }
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