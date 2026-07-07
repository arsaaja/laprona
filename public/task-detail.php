<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
$user = currentUser();
$db = getDB();

$id = (int) ($_GET['id'] ?? 0);

$stmt = $db->prepare('SELECT t.*, sub.nama_mapel, sub.warna,
        (SELECT status FROM submissions WHERE task_id = t.id AND user_id = ?) as my_status
    FROM tasks t JOIN subjects sub ON sub.id = t.subject_id
    WHERE t.id = ?');
$stmt->execute([$user['id'], $id]);
$task = $stmt->fetch();

include __DIR__ . '/../app/views/layouts/header.php';
?>

<?php if (!$task): ?>
    <p>Tugas tidak ditemukan.</p>
<?php else: ?>
    <div class="box box-white">
        <div class="task-card-header" style="background: <?= badgeColor($task['warna']) ?>; border-radius:10px; display:inline-block; padding:6px 14px; margin-bottom:16px;">
            <?= strtoupper(e($task['nama_mapel'])) ?>
        </div>
        <h1><?= e($task['judul']) ?></h1>
        <p><?= e($task['deskripsi']) ?></p>
        <p><strong>📅 Deadline: <?= date('d M Y', strtotime($task['deadline'])) ?></strong></p>

        <?php if ($task['my_status'] !== 'selesai'): ?>
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
