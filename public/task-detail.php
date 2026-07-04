<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();

$id = (int) ($_GET['id'] ?? 0);
$task = null;
foreach ($DUMMY_TASKS as $t) {
    if ($t['id'] === $id) { $task = $t; break; }
}

include __DIR__ . '/../app/views/layouts/header.php';
?>

<?php if (!$task): ?>
    <p>Tugas tidak ditemukan.</p>
<?php else: ?>
    <div class="box" style="background:#fff;">
        <div class="task-card-header" style="background: <?= badgeColor($task['warna']) ?>; border-radius:10px; display:inline-block; padding:6px 14px; margin-bottom:16px;">
            <?= strtoupper(e($task['mapel'])) ?>
        </div>
        <h1><?= e($task['judul']) ?></h1>
        <p><?= e($task['deskripsi']) ?></p>
        <p><strong>📅 <?= e($task['deadline']) ?></strong></p>

        <?php if ($task['status'] === 'belum'): ?>
            <div class="status-tag status-belum">BELUM DIKUMPULKAN</div>
            <br><br>
            <a href="task-submit.php?id=<?= $task['id'] ?>" class="btn btn-yellow">KUMPULKAN TUGAS</a>
        <?php else: ?>
            <div class="status-tag status-selesai">SUDAH DIKUMPULKAN</div>
        <?php endif; ?>
    </div>
    <br>
    <a href="tasks.php" class="btn">&larr; Kembali ke Daftar Tugas</a>
<?php endif; ?>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
