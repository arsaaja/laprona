<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

$taskId = (int) ($_GET['task_id'] ?? 0);

$stmt = $db->prepare('SELECT * FROM tasks WHERE id = ?');
$stmt->execute([$taskId]);
$task = $stmt->fetch();

$rows = [];
if ($task) {
    $stmt = $db->prepare('SELECT cm.no_absen, u.nama, u.email, s.status, s.catatan, s.submitted_at, s.file_path
        FROM class_members cm
        JOIN users u ON u.id = cm.user_id
        LEFT JOIN submissions s ON s.user_id = u.id AND s.task_id = ?
        WHERE cm.class_id = ?
        ORDER BY cm.no_absen ASC');
    $stmt->execute([$taskId, $task['class_id']]);
    $rows = $stmt->fetchAll();
}

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header"><h1>Pengumpulan: <?= e($task['judul'] ?? '-') ?></h1></div>

<table class="data-table">
    <tr><th>No</th><th>Nama</th><th>Status</th><th>Catatan</th><th>Waktu Kumpul</th></tr>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= str_pad($r['no_absen'], 2, '0', STR_PAD_LEFT) ?></td>
            <td><?= e($r['nama']) ?></td>
            <td>
                <?php if ($r['status'] === 'selesai'): ?>
                    <span class="status-tag status-selesai">SUDAH KUMPUL</span>
                <?php else: ?>
                    <span class="status-tag status-belum">BELUM KUMPUL</span>
                <?php endif; ?>
            </td>
            <td><?= e($r['catatan'] ?? '-') ?></td>
            <td><?= $r['submitted_at'] ? date('d M Y, H:i', strtotime($r['submitted_at'])) : '-' ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br><a href="tasks.php" class="btn">&larr; Kembali</a>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
