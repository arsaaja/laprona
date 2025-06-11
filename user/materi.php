<?php include('../koneksi/koneksi.php');
session_start();

$id_kelas = $_SESSION['id_kelas'];
$id_subjek_kelas = $_SESSION['id_subjek_kelas'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Materi - La Prona</title>
    <?php include("includes/head.php") ?>
</head>

<body>

    <header>
        <?php include("includes/header.php") ?>
    </header>

    <h2>Daftar Materi</h2>

    <div class="search-bar">
        <input type="text" placeholder="Cari Materi" />
    </div>

    <div class="materi-list">
        <?php
        $query = "SELECT
    materi.id_materi,
    materi.nama_materi,
    materi.isi_materi,
    subjek_kelas.subjek_kelas
FROM
    materi
JOIN
    kelas ON materi.id_kelas = kelas.id_kelas
JOIN
    master_kelas_subjek ON materi.id_subjek = master_kelas_subjek.id_kelas_subjek
JOIN
    subjek_kelas ON master_kelas_subjek.id_kelas_subjek = subjek_kelas.id_subjek_kelas
WHERE materi.id_kelas = ? AND master_kelas_subjek.id_subjek_kelas = ?
ORDER BY
    materi.id_materi DESC
LIMIT 10";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="materi-card">';
            echo '  <div class="materi-icon"><i class="fas fa-file-alt"></i></div>';
            echo '  <div class="materi-info">';
            echo '    <h4><strong>' . htmlspecialchars($row['nama_materi']) . '</strong></h4>';
            echo '    <p>' . htmlspecialchars($row['isi_materi']) . '</p>';
            echo '    <p><em>' . htmlspecialchars($row['subjek_kelas']) . '</em></p>';
            echo '  </div>';
            echo '  <a href="unduh_materi.php?id=' . $row['id_materi'] . '" class="unduh-btn">Unduh</a>';
            echo '</div>';
        }
        ?>
    </div>

</body>

</html>