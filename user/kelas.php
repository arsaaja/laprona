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
        <div class="kelas-card">
            <div>Kelas 4B</div>
            <div>Bu Wawan</div>
            <div class="kelas-buttons">
                <a href="materi.php" class="btn">Materi</a>
                <a href="pengumpulan_tugas.php" class="btn">Tugas</a>
            </div>
        </div>
        <div class="kelas-card">
            <div>Kelas 4C</div>
            <div>Bu Totok</div>
        </div>
        <div class="kelas-card">
            <div>Kelas 4D</div>
            <div>Pak Sugandi</div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>