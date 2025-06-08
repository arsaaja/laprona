<?php include('../koneksi/koneksi.php');
session_start();

$id_kelas = $_SESSION['id_kelas'];
$id_siswa_login = $_SESSION['id_siswa'];

// Ambil data ranking siswa di kelas yang sama
$query = "SELECT s.id_siswa, s.nama_siswa,SUM (p.nilai) AS total_nilai FROM siswa s JOIN penilaian p 
    ON s.id_siswa = p.id_siswa
    WHERE s.id_kelas = $id_kelas GROUP BY s.id_siswa ORDER BY total_nilai DESC";

$result = mysqli_query($koneksi, $query);

$ranking = 1;
$ranking_login = 0;
$nilai_login = 0;
$nama_login = '';

$rows = [];

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['id_siswa'] == $id_siswa_login) {
        $ranking_login = $ranking;
        $nilai_login = $row['total_nilai'];
        $nama_login = $row['nama_siswa'];
    }
    $row['ranking'] = $ranking;
    $rows[] = $row;
    $ranking++;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tugas - La Prona</title>
    <?php include("includes/head.php") ?>
</head>

<body>
    <header>
        <?php include("includes/header.php") ?>
    </header>

    <div class="content">
        <div class="performa">
            <div class="section-title">Performa Siswa</div>
            <div style="font-size: 2.5rem; margin: 1rem 0;">🥇</div>
            <p style="font-size: 1.2rem; font-weight: bold;">Ranking 1 dari 30 siswa</p>
            <p style="font-size: 1rem;">Luar biasa! Pertahankan prestasimu!</p>

            <div class="section-title">Ranking Kelas</div>
            <?php foreach ($rows as $row): ?>
                <div class="ranking-item <?php echo ($row['id_siswa'] == $id_siswa_login) ? 'highlight' : ''; ?>">
                    <div>
                        <strong>#<?php echo $row['ranking']; ?></strong> - <?php echo $row['nama_siswa']; ?>
                    </div>
                    <div>
                        <?php echo $row['total_nilai']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Tugas Minggu Ini</h2>
        <div class="materi">
            <?php
            $query = "SELECT tugas.id_tugas, tugas.judul_tugas, tugas.deadline_tugas, kelas.subjek_kelas FROM tugas
                        JOIN kelas ON tugas.id_kelas = kelas.id_kelas ORDER BY tugas.id_tugas DESC LIMIT 7";
            $result = mysqli_query($koneksi, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';
                echo '  <div class="icon"><i class="fas fa-tasks"></i></div>';
                echo '  <h3>' . htmlspecialchars($row['judul_tugas']) . '</h3>';
                echo '  <p>' . htmlspecialchars($row['subjek_kelas']) . '</p>';
                echo '  <p>Deadline: ' . htmlspecialchars($row['deadline_tugas']) . '</p>';
                echo '  <a href="detail_tugas.php?id=' . $row['id_tugas'] . '" class="button-link">Detail</a>';
                echo '</div>';
            }
            ?>
            <div class="card">
                <div class="icon"><i class="fas fa-folder-open"></i></div>
                <h3>Lihat Semua Tugas</h3>
                <p>Daftar lengkap tugas</p>
                <a href="tugas.php" class="button-link">Selengkapnya</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>

</body>

</html>