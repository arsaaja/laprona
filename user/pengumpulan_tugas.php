<?php
include('../koneksi/koneksi.php');
$id = $_GET['id'];
$query = "
    SELECT tugas.*, kelas.subjek_kelas 
    FROM tugas 
    JOIN kelas ON tugas.id_kelas = kelas.id_kelas 
    WHERE tugas.id_tugas = $id
";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tandai_selesai'])) {
    $id_tugas = $_POST['id_tugas'];
    $link_drive = mysqli_real_escape_string($koneksi, $_POST['link_drive']);

    $query_insert = "INSERT INTO pengumpulan (id_tugas, link_drive, status) 
                     VALUES ($id_tugas, '$link_drive', 'selesai')";
    if (mysqli_query($koneksi, $query_insert)) {
        echo "<script>alert('Link tugas berhasil dikumpulkan!');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan ke database.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Detail Tugas - La Prona</title>
    <?php include("includes/head.php"); ?>
</head>

<body>
    <header>
        <?php include("includes/header.php"); ?>
    </header>

    <main>
        <section class="kelas-info">
            <h1>Kelas <?= htmlspecialchars($data['subjek_kelas']) ?></h1>
            <p><?= htmlspecialchars($data['judul_tugas']) ?></p>
            <div class="skor-diberikan">
                Skor yang diberikan: <strong><?= htmlspecialchars($data['skor_tugas']) ?></strong>
            </div>
        </section>

        <section class="detail-tugas">
            <h2>Detail Tugas</h2>
            <div class="card">
                <p><strong><i class="fas fa-file-alt"></i> <?= htmlspecialchars($data['tugas']) ?></strong></p>
                <p><i class="fas fa-clock"></i> Deadline: <?= date("d/m/Y H:i", strtotime($data['deadline_tugas'])) ?>
                </p>
                <p><i class="fas fa-file"></i> Tipe Pengumpulan:
                    <?= pathinfo($data['pengumpulan_tugas'], PATHINFO_EXTENSION) ?>
                </p>
                <p><i class="fas fa-star"></i> Skor: <?= htmlspecialchars($data['skor_tugas']) ?></p>
            </div>

            <!-- Form pengumpulan tugas berupa link -->
            <form method="post">
                <input type="hidden" name="id_tugas" value="<?= $data['id_tugas'] ?>">
                <div class="form-group">
                    <label for="link_drive"><strong>Link Google Drive</strong></label><br>
                    <input type="url" name="link_drive" id="link_drive" class="form-control" required
                        placeholder="https://drive.google.com/...">
                </div>
                <br>
                <div class="actions">
                    <button type="submit" name="tandai_selesai" class="btn">
                        <i class="fas fa-check-circle"></i> Tandai Selesai
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script src="script.js"></script>
</body>

</html>