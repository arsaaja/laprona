<?php
session_start();
include('../koneksi/koneksi.php');

// Bagian ini adalah script PHP yang akan dieksekusi saat ada permintaan hapus
if (isset($_GET['aksi']) && isset($_GET['data'])) {
    if ($_GET['aksi'] == 'hapus') {
        $id_kelas = mysqli_real_escape_string($koneksi, $_GET['data']);

        // Transaksi untuk memastikan integritas data saat menghapus
        mysqli_begin_transaction($koneksi);

        try {
            // 1. Hapus entri dari master_kelas_subjek terlebih dahulu
            // Ini untuk mengatasi Foreign Key Constraint jika ON DELETE CASCADE tidak diatur di DB
            $sql_delete_master_subjek = "DELETE FROM master_kelas_subjek WHERE id_kelas = '$id_kelas'";
            if (!mysqli_query($koneksi, $sql_delete_master_subjek)) {
                throw new Exception("Gagal menghapus relasi subjek kelas.");
            }

            // 2. (Opsional) Update atau Hapus siswa yang terkait dengan kelas ini
            // Pilih salah satu di bawah ini, atau komentari jika tidak diperlukan
            // Pastikan kolom `id_kelas` di tabel `siswa` bisa NULL jika memilih UPDATE
            $sql_update_siswa = "UPDATE siswa SET id_kelas = NULL WHERE id_kelas = '$id_kelas'";
            if (!mysqli_query($koneksi, $sql_update_siswa)) {
                throw new Exception("Gagal mengupdate siswa terkait.");
            }

            // Atau: Hapus semua siswa yang terkait dengan kelas ini
            // $sql_delete_siswa = "DELETE FROM siswa WHERE id_kelas = '$id_kelas'";
            // if (!mysqli_query($koneksi, $sql_delete_siswa)) {
            //     throw new Exception("Gagal menghapus siswa terkait.");
            // }

            // 3. Hapus kelas dari tabel 'kelas'
            $sql_delete_kelas = "DELETE FROM kelas WHERE id_kelas = '$id_kelas'";
            if (!mysqli_query($koneksi, $sql_delete_kelas)) {
                throw new Exception("Gagal menghapus kelas.");
            }

            // Jika semua query berhasil, commit transaksi
            mysqli_commit($koneksi);
            header("Location: kelas.php?notif=hapusberhasil");
            exit;

        } catch (Exception $e) {
            // Jika ada error, rollback transaksi
            mysqli_rollback($koneksi);
            // Log error atau tampilkan pesan yang lebih spesifik jika perlu
            error_log("Error deleting class (ID: $id_kelas): " . $e->getMessage());
            header("Location: kelas.php?notif=hapusgagal&pesan=" . urlencode($e->getMessage()));
            exit;
        }
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
                            <h3><i class="fas fa-school"></i> Kelas</h3>
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
                                        value="<?php echo isset($_GET['katakunci']) ? htmlspecialchars($_GET['katakunci']) : ''; ?>">
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
                                else if ($_GET['notif'] == "hapusgagal")
                                    echo "Gagal menghapus data: " . htmlspecialchars(isset($_GET['pesan']) ? $_GET['pesan'] : 'Terjadi kesalahan.');
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

                                $katakunci = isset($_GET['katakunci']) ? mysqli_real_escape_string($koneksi, $_GET['katakunci']) : '';

                                $sql = "SELECT k.id_kelas, k.nama_kelas, jp.nama_jenjang,
                                        (SELECT COUNT(*) FROM siswa s WHERE s.id_kelas = k.id_kelas) AS jumlah_siswa
                                        FROM kelas k
                                        LEFT JOIN jenjang_pendidikan jp ON k.id_jenjang = jp.id_jenjang_pendidikan";

                                $conditions = [];

                                if (!empty($katakunci)) {
                                    $conditions[] = "k.nama_kelas LIKE '%$katakunci%'";
                                    $conditions[] = "k.id_kelas IN (SELECT mks.id_kelas FROM master_kelas_subjek mks 
                                                     JOIN subjek_kelas sk ON mks.id_subjek = sk.id_subjek_kelas
                                                     WHERE sk.subjek_kelas LIKE '%$katakunci%')";
                                }

                                if (!empty($conditions)) {
                                    $sql .= " WHERE " . implode(" OR ", $conditions);
                                }

                                $sql .= " ORDER BY k.nama_kelas ASC LIMIT $posisi, $batas";

                                $query = mysqli_query($koneksi, $sql);
                                $no = $posisi + 1;

                                while ($data = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($data['nama_kelas']); ?></td>
                                        <td>
                                            <?php
                                            $id_kelas = $data['id_kelas'];
                                            $sql_subjek = "SELECT sk.subjek_kelas FROM master_kelas_subjek mks 
                                                           JOIN subjek_kelas sk ON mks.id_subjek = sk.id_subjek_kelas
                                                           WHERE mks.id_kelas = $id_kelas";
                                            $res_subjek = mysqli_query($koneksi, $sql_subjek);
                                            $nama_subjek_list = [];
                                            while ($subjek = mysqli_fetch_assoc($res_subjek)) {
                                                $nama_subjek_list[] = htmlspecialchars($subjek['subjek_kelas']);
                                            }
                                            echo implode(", ", $nama_subjek_list);
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($data['nama_jenjang']); ?></td>
                                        <td><?php echo htmlspecialchars($data['jumlah_siswa']); ?></td>
                                        <td align="center">
                                            <a href="kelas_edit.php?data=<?php echo $data['id_kelas'] ?>"
                                                class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="kelas.php?aksi=hapus&data=<?php echo $data['id_kelas'] ?>"
                                                onclick="return confirm('Yakin ingin menghapus data ini? Ini akan menghapus semua relasi subjek dan (opsional) mengosongkan kelas siswa yang terkait.')"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <?php
                        // hitung total data untuk pagination
                        $sql_count = "SELECT COUNT(k.id_kelas) AS total
                                      FROM kelas k
                                      LEFT JOIN jenjang_pendidikan jp ON k.id_jenjang = jp.id_jenjang_pendidikan";

                        $conditions_count = [];
                        if (!empty($katakunci)) {
                            $conditions_count[] = "k.nama_kelas LIKE '%$katakunci%'";
                            $conditions_count[] = "k.id_kelas IN (SELECT mks.id_kelas FROM master_kelas_subjek mks 
                                                  JOIN subjek_kelas sk ON mks.id_subjek = sk.id_subjek_kelas 
                                                  WHERE sk.subjek_kelas LIKE '%$katakunci%')";
                        }

                        if (!empty($conditions_count)) {
                            $sql_count .= " WHERE " . implode(" OR ", $conditions_count);
                        }

                        $res_count = mysqli_query($koneksi, $sql_count);
                        $data_count = mysqli_fetch_assoc($res_count);
                        $jum_data = $data_count['total'];
                        $jum_halaman = ceil($jum_data / $batas);
                        ?>

                        <div class="card-footer clearfix">
                            <ul class="pagination justify-content-center mt-3">
                                <?php
                                if ($jum_halaman == 0) {
                                    // tidak ada halaman
                                } else if ($jum_halaman == 1) {
                                    echo "<li class='page-item'><a class='page-link'>1</a></li>";
                                } else {
                                    $sebelum = $halaman - 1;
                                    $setelah = $halaman + 1;
                                    $katakunci_param = !empty($katakunci) ? "&katakunci=" . urlencode($katakunci) : '';

                                    if ($halaman != 1) {
                                        echo "<li class='page-item'><a class='page-link' href='kelas.php?halaman=1$katakunci_param'>First</a></li>";
                                        echo "<li class='page-item'><a class='page-link' href='kelas.php?halaman=$sebelum$katakunci_param'>&laquo;</a></li>";
                                    }
                                    for ($i = 1; $i <= $jum_halaman; $i++) {
                                        if ($i > $halaman - 5 and $i < $halaman + 5) {
                                            if ($i != $halaman) {
                                                echo "<li class='page-item'><a class='page-link' href='kelas.php?halaman=$i$katakunci_param'>$i</a></li>";
                                            } else {
                                                echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
                                            }
                                        }
                                    }
                                    if ($halaman != $jum_halaman) {
                                        echo "<li class='page-item'><a class='page-link' href='kelas.php?halaman=$setelah$katakunci_param'>&raquo;</a></li>";
                                        echo "<li class='page-item'><a class='page-link' href='kelas.php?halaman=$jum_halaman$katakunci_param'>Last</a></li>";
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