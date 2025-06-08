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
        $query = "SELECT * FROM kelas";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="kelas-card">
                    <div>
                        <?= htmlspecialchars($row["nama_kelas"] ?? "Tanpa Nama Kelas") ?><br>
                        <?= htmlspecialchars($row["subjek_kelas"] ?? "Tanpa Subjek") ?>
                    </div>
                    <div class="kelas-actions">
                        <a href="materi.php?id_kelas=<?= $row["id_kelas"] ?>" class="button-link">
                            <i class="fa-solid fa-chalkboard-user"></i> Materi
                        </a>
                        <a href="pengumpulan_tugas.php?id_kelas=<?= $row["id_kelas"] ?>" class="button-link">
                            <i class="fas fa-book"></i> Tugas
                        </a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>Tidak ada data kelas tersedia.</p>";
        }
        ?>
    </div>

    <script src="script.js"></script>
</body>

</html>