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
        $query = "SELECT m.*, k.nama_kelas, k.id_kelas 
          FROM materi m
          JOIN kelas k ON m.id_kelas = k.id_kelas
          ORDER BY m.id_materi DESC LIMIT 4";

        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $id_kelas = $row['id_kelas'];

            // Ambil subjek-subjek untuk kelas ini
            $subjek = [];
            $sql_subjek = "SELECT sk.subjek_kelas 
                   FROM master_kelas_subjek mks
                   JOIN subjek_kelas sk ON mks.id_subjek = sk.id_subjek_kelas
                   WHERE mks.id_kelas = $id_kelas";
            $res_subjek = mysqli_query($koneksi, $sql_subjek);
            while ($sub = mysqli_fetch_assoc($res_subjek)) {
                $subjek[] = $sub['subjek_kelas'];
            }

            $subjek_kelas = implode(", ", $subjek);

            // Tampilkan
            echo '<div class="card">';
            echo '  <div class="icon"><i class="fas ' . ($row["ikon"] ?? "fa-book") . '"></i></div>';
            echo '  <h3>' . $row['nama_materi'] . '</h3>';
            echo '  <p>' . $subjek_kelas . '</p>';
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
        include('../koneksi/koneksi.php');

        // Ambil tugas + subjek melalui relasi master_kelas_subjek
        $query = "SELECT t.id_tugas, t.judul_tugas, t.deadline_tugas, sk.subjek_kelas
          FROM tugas t
          JOIN master_kelas_subjek mks ON t.id_kelas = mks.id_kelas
          JOIN subjek_kelas sk ON mks.id_subjek = sk.id_subjek_kelas
          ORDER BY t.id_tugas DESC
          LIMIT 7";

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