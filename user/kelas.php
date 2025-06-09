<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelas - La Prona</title>
    <?php include("includes/head.php") ?>
</head>

<body>
    <header>
        <?php include("includes/header.php") ?>
    </header>

    <div class="search-bar">
        <input type="text" placeholder="Cari Kelas" />
    </div>

    <h2>Daftar Kelas</h2>

    <div class="kelas-list">
        <?php
        include('../koneksi/koneksi.php');
        session_start();

        $id_siswa = $_SESSION['id_siswa'];

        $sql_kelas = "SELECT k.id_kelas, k.nama_kelas FROM siswa s
              JOIN kelas k ON s.id_kelas = k.id_kelas
              WHERE s.id_siswa = $id_siswa
              LIMIT 1";
        $res_kelas = mysqli_query($koneksi, $sql_kelas);

        if ($data_kelas = mysqli_fetch_assoc($res_kelas)) {
            $id_kelas = $data_kelas['id_kelas'];
            $nama_kelas = $data_kelas['nama_kelas'];

            $sql_subjek = "SELECT sk.subjek_kelas, sk.id_subjek_kelas FROM master_kelas_subjek mks
                   JOIN subjek_kelas sk ON mks.id_subjek = sk.id_subjek_kelas
                   WHERE mks.id_kelas = $id_kelas";
            $res_subjek = mysqli_query($koneksi, $sql_subjek);

            if (mysqli_num_rows($res_subjek) > 0) {
                while ($sub = mysqli_fetch_assoc($res_subjek)) {
                    ?>
                    <div class="kelas-card">
                        <div>
                            <?= $nama_kelas ?><br>
                            <?= $sub["subjek_kelas"] ?>
                        </div>
                        <div class="kelas-actions">
                            <a href="materi.php?id_kelas=<?= $id_kelas ?>&id_subjek=<?= $sub["id_subjek_kelas"] ?>"
                                class="button-link">
                                <i class="fa-solid fa-chalkboard-user"></i> Materi
                            </a>
                            <a href="tugas.php?id_kelas=<?= $id_kelas ?>&id_subjek=<?= $sub["id_subjek_kelas"] ?>"
                                class="button-link">
                                <i class="fas fa-book"></i> Tugas
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Tidak ada subjek untuk kelas ini.</p>";
            }
        } else {
            echo "<p>Kelas siswa tidak ditemukan.</p>";
        }
        ?>
    </div>

    <script src="script.js"></script>
</body>

</html>