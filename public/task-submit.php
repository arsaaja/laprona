<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();

$id = (int) ($_GET['id'] ?? 0);
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dummy: file tidak benar-benar disimpan ke uploads/submissions/
    // karena ini masih data statis, bukan database.
    $success = true;
}

include __DIR__ . '/../app/views/layouts/header.php';
?>

<div class="box" style="background:#fff; max-width:500px;">
    <h2>Kumpulkan Tugas</h2>

    <?php if ($success): ?>
        <p style="color:#1a7a4c; font-weight:700;">Tugas berhasil dikumpulkan! (dummy, belum tersimpan ke database)</p>
        <a href="tasks.php" class="btn btn-yellow">Kembali ke Daftar Tugas</a>
    <?php else: ?>
        <form method="post" enctype="multipart/form-data">
            <p>Upload file jawaban untuk tugas ID #<?= $id ?>:</p>
            <input type="file" name="file_jawaban" style="margin-bottom:16px;">
            <br>
            <textarea name="catatan" placeholder="Catatan tambahan (opsional)" rows="4" style="width:100%; border:2px solid #111; border-radius:8px; padding:10px; margin-bottom:16px;"></textarea>
            <br>
            <button type="submit" class="btn btn-yellow">Submit Jawaban</button>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
