<?php
include('../koneksi/koneksi.php');
session_start();

$id_tugas = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 0;
$id_siswa = $_SESSION['id_siswa'];

$query = "SELECT t.*, sk.subjek_kelas, k.nama_kelas
    FROM tugas t
    JOIN master_kelas_subjek mks ON t.id_subjek = mks.id_subjek
    JOIN subjek_kelas sk ON mks.id_subjek = sk.id_subjek_kelas
    JOIN kelas k ON t.id_kelas = k.id_kelas
    WHERE t.id_tugas = $id_tugas
    LIMIT 1";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<p>Tugas tidak ditemukan.</p>";
    exit;
}

$query_cek = mysqli_query($koneksi, "SELECT * FROM pengumpulan_tugas WHERE id_tugas = $id_tugas AND id_siswa = $id_siswa");
$pengumpulan = mysqli_fetch_assoc($query_cek);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tandai_selesai'])) {
    $link_drive = mysqli_real_escape_string($koneksi, $_POST['link_drive']);

    if ($pengumpulan) {
        $query_update = "UPDATE pengumpulan_tugas SET link_drive = '$link_drive', status = 'selesai', waktu_submit = NOW()
                         WHERE id_tugas = $id_tugas AND id_siswa = $id_siswa";
        $success = mysqli_query($koneksi, $query_update);
    } else {
        $query_insert = "INSERT INTO pengumpulan_tugas (id_tugas, id_siswa, link_drive, status)
                         VALUES ($id_tugas, $id_siswa, '$link_drive', 'selesai')";
        $success = mysqli_query($koneksi, $query_insert);
    }

    if ($success) {
        echo "<script>alert('Tugas berhasil dikumpulkan!'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan tugas.');</script>";
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
            <h1>Kelas <?= htmlspecialchars($data['subjek_kelas'] ?? '') ?></h1>
            <p><?= htmlspecialchars($data['judul_tugas'] ?? '') ?></p>
            <div class="skor-diberikan">
                Skor yang diberikan: <strong><?= htmlspecialchars($data['skor_tugas'] ?? '') ?></strong>
            </div>
        </section>

        <section class="detail-tugas">
            <h2>Detail Tugas</h2>
            <div class="card">
                <p><strong><i class="fas fa-file-alt"></i> <?= htmlspecialchars($data['tugas'] ?? '') ?></strong></p>
                <p><i class="fas fa-clock"></i> Deadline:
                    <?= isset($data['deadline_tugas']) ? date("d/m/Y H:i", strtotime($data['deadline_tugas'])) : '' ?>
                </p>

                <?php if (!empty($pengumpulan)): ?>
                    <p><i class="fas fa-link"></i> Link Pengumpulan:
                        <a href="<?= htmlspecialchars($pengumpulan['link_drive'] ?? '') ?>" target="_blank">
                            <?= htmlspecialchars($pengumpulan['link_drive'] ?? '') ?>
                        </a>
                    </p>
                    <p><i class="fas fa-calendar-check"></i> Status:
                        <strong><?= ucfirst($pengumpulan['status'] ?? '') ?></strong>
                        (<?= isset($pengumpulan['waktu_submit']) ? date('d/m/Y H:i', strtotime($pengumpulan['waktu_submit'])) : '' ?>)
                    </p>
                <?php else: ?>
                    <p><i class="fas fa-info-circle"></i> Belum ada pengumpulan dari Anda.</p>
                <?php endif; ?>

                <p><i class="fas fa-star"></i> Skor Maksimum: <?= htmlspecialchars($data['skor_tugas'] ?? '') ?></p>
            </div>

            <!-- Form pengumpulan tugas -->
            <form method="post">
                <p><i class="fas fa-clock"></i> Deadline:
                    <?= isset($data['deadline_tugas']) ? date("d/m/Y H:i", strtotime($data['deadline_tugas'])) : 'N/A' ?>

                <div class="form-group">
                    <label for="link_drive"><strong>Link Google Drive</strong></label><br>
                    <input type="url" name="link_drive" id="link_drive" class="form-control"
                        value="<?= htmlspecialchars($pengumpulan['link_drive'] ?? '') ?>" required
                        placeholder="https://drive.google.com/...">
                </div>
                <br>
                <div class="actions">
                    <button type="submit" name="tandai_selesai" class="btn">
                        <i class="fas fa-check-circle"></i>
                        <?= $pengumpulan ? 'Perbarui Pengumpulan' : 'Tandai Selesai' ?>
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script src="script.js"></script>
</body>

</html>