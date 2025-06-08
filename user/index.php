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
        <div class="carousel-track" id="carouselTrack">
            <img src="https://via.placeholder.com/250x120?text=SNPMB+UTBK" alt="SNPMB UTBK" />
            <img src="https://via.placeholder.com/250x120?text=Kelas+UTBK+SNBT" alt="Kelas UTBK SNBT" />
            <img src="https://via.placeholder.com/250x120?text=Daftar+Batch+6" alt="Daftar Batch 6" />
        </div>
    </div>
    <h2>Materi Minggu Ini</h2>
    <div class="materi">
        <?php
        $query = "SELECT materi.*, kelas.subjek_kelas FROM materi
    JOIN kelas ON materi.id_kelas = kelas.id_kelas
    ORDER BY id_materi DESC LIMIT 8";

        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="card">';
            echo '  <div class="icon"><i class="fas ' . ($row["ikon"] ?? "fa-book") . '"></i></div>';
            echo '  <h3>' . $row['nama_materi'] . '</h3>';
            echo '  <p>' . $row['subjek_kelas'] . '</p>';
            echo '  <a href="detail_materi.php?id=' . $row['id_materi'] . '" class="button-link">Detail</a>';
            echo '</div>';
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
        $query = "SELECT tugas.id_tugas, tugas.judul_tugas, tugas.deadline_tugas, kelas.subjek_kelas FROM tugas
                        JOIN kelas ON tugas.id_kelas = kelas.id_kelas ORDER BY tugas.id_tugas DESC LIMIT 7";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="card">';
            echo '  <div class="icon"><i class="fas fa-tasks"></i></div>';
            echo '  <h3>' . $row['judul_tugas'] . '</h3>';
            echo '  <p>' . $row['subjek_kelas'] . '</p>';
            echo '  <p>Deadline: ' . $row['deadline_tugas'] . '</p>';
            echo '  <a href="pengumpulan_tugas.php?id=' . $row['id_tugas'] . '" class="button-link">Detail</a>';
            echo '</div>';
        }
        ?>
        <div class="card">
            <div class="icon"><i class="fas fa-folder-open"></i></div>
            <h3>Lihat Daftar Tugas</h3>
            <a href="tugas.php" class="button-link">Selengkapnya</a>
        </div>
    </div>

    <h2>Kirim Masukan</h2>
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