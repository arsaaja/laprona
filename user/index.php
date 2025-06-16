<?php include('../koneksi/koneksi.php');
$notif = "";

if (isset($_POST['kirim'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi_masukan']);
    $tanggal = date('Y-m-d');

    $query = "INSERT INTO pesan_masuk (username, email, isi_masukan, tanggal)
              VALUES ('$username', '$email', '$isi', '$tanggal')";

    if (mysqli_query($koneksi, $query)) {
        $notif = "Pesan berhasil dikirim!";
    } else {
        $notif = "Terjadi kesalahan: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Beranda - La Prona</title>
    <?php include("includes/head.php") ?>
</head>


<body>

    <header>
        <?php include("includes/header.php") ?>
    </header>


    <h2>Berita</h2>
    <div class="carousel-container">
        <button class="carousel-button prev" onclick="moveCarousel(-1)">‹</button>
        <div class="carousel-track" id="carouselTrack">
            <img src="/laprona/images/banner.png" alt="SNPMB UTBK" />
            <img src="/laprona/images/banner.png" alt="Kelas UTBK SNBT" />
            <img src="/laprona/images/banner.png" alt="Daftar Batch 6" />
        </div>
        <button class="carousel-button next" onclick="moveCarousel(1)">›</button>
    </div>

    <h2>Materi Minggu Ini</h2>
    <div class="materi">
        <?php
        $queryMateri = "SELECT m.*, k.nama_kelas, sk.subjek_kelas
    FROM materi m
    JOIN kelas k ON m.id_kelas = k.id_kelas
    JOIN subjek_kelas sk ON m.id_subjek = sk.id_subjek_kelas ORDER BY m.id_materi DESC LIMIT 4";

        $resultMateri = mysqli_query($koneksi, $queryMateri);

        if ($resultMateri) {
            while ($row = mysqli_fetch_assoc($resultMateri)) {
                echo '<div class="card">';
                echo '  <div class="icon"><i class="fas ' . ($row["ikon"] ?? "fa-book") . '"></i></div>';
                echo '  <h3>' . htmlspecialchars($row['nama_materi']) . '</h3>';
                echo '  <p>' . htmlspecialchars($row['subjek_kelas']) . '</p>';
                echo '  <a href="detail_materi.php?id=' . $row['id_materi'] . '" class="button-link">Detail</a>';
                echo '</div>';
            }
        } else {
            echo "Gagal memuat materi: " . mysqli_error($koneksi);
        }
        ?>
        <div class="card">
            <div class="icon"><i class="fas fa-folder-open"></i></div>
            <h3>Lihat Daftar Materi</h3>
            <a href="materi.php" class="button-link">Selengkapnya</a>
        </div>
    </div>

    <h2>Tugas Minggu Ini</h2>
    <div class="materi">
        <?php

        $queryTugas = "SELECT t.*, sk.subjek_kelas FROM tugas t 
    JOIN kelas k ON t.id_kelas = k.id_kelas
    JOIN subjek_kelas sk ON t.id_subjek = sk.id_subjek_kelas
    ORDER BY t.id_tugas DESC LIMIT 4";
        $resultTugas = mysqli_query($koneksi, $queryTugas);

        if ($resultTugas) {
            while ($row = mysqli_fetch_assoc($resultTugas)) {
                echo '<div class="card">';
                echo '  <div class="icon"><i class="fas fa-tasks"></i></div>';
                echo '  <h3>' . htmlspecialchars($row['judul_tugas']) . '</h3>';
                echo '  <p>' . htmlspecialchars($row['subjek_kelas']) . '</p>';
                echo '  <p>Deadline: ' . htmlspecialchars($row['deadline_tugas']) . '</p>';
                echo '  <a href="pengumpulan_tugas.php?id=' . $row['id_tugas'] . '" class="button-link">Detail</a>';
                echo '</div>';
            }
        } else {
            echo "Gagal memuat tugas: " . mysqli_error($koneksi);
        }
        ?>

        <div class="card">
            <div class="icon"><i class="fas fa-folder-open"></i></div>
            <h3>Lihat Daftar Tugas</h3>
            <a href="tugas.php" class="button-link">Selengkapnya</a>
        </div>
    </div>

    <h2 id="form-masukan">Kirim Masukan</h2>
    <?php if (!empty($notif)): ?>
        <div class="notif-box">
            <?= htmlspecialchars($notif) ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Pesan:</label><br>
        <textarea name="isi_masukan" rows="5" required></textarea><br><br>

        <input type="submit" name="kirim" value="Kirim Pesan">
    </form>

    <script src="script.js"></script>

</body>

</html>