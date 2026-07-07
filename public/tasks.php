<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
$user = currentUser();
$db = getDB();

$filter = $_GET['filter'] ?? 'semua';

$stmt = $db->prepare('SELECT c.id FROM classes c JOIN class_members cm ON cm.class_id = c.id WHERE cm.user_id = ? LIMIT 1');
$stmt->execute([$user['id']]);
$myClass = $stmt->fetch();

$tasks = [];
if ($myClass) {
    $sql = 'SELECT t.*, sub.nama_mapel, sub.warna,
                (SELECT status FROM submissions WHERE task_id = t.id AND user_id = ?) as my_status
            FROM tasks t
            JOIN subjects sub ON sub.id = t.subject_id
            WHERE t.class_id = ?
            ORDER BY t.deadline ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute([$user['id'], $myClass['id']]);
    $allTasks = $stmt->fetchAll();

    foreach ($allTasks as $t) {
        $status = $t['my_status'] ?: 'belum';
        if ($filter === 'belum' && $status !== 'belum') continue;
        if ($filter === 'selesai' && $status !== 'selesai') continue;
        $t['status'] = $status;
        $tasks[] = $t;
    }
}

include __DIR__ . '/../app/views/layouts/header.php';
?>

<h2>Daftar Tugas Anda</h2>
<p>Pantau progres akademik Anda. Selesaikan tugas tepat waktu untuk hasil yang maksimal!</p>

<div class="filter-tabs">
    <a href="tasks.php?filter=semua" class="<?= $filter === 'semua' ? 'active' : '' ?>">Semua</a>
    <a href="tasks.php?filter=belum" class="<?= $filter === 'belum' ? 'active' : '' ?>">Belum Selesai</a>
    <a href="tasks.php?filter=selesai" class="<?= $filter === 'selesai' ? 'active' : '' ?>">Selesai</a>
</div>

<div class="card-grid">
    <?php if (empty($tasks)): ?>
        <p>Tidak ada tugas pada kategori ini.</p>
    <?php endif; ?>
    <?php foreach ($tasks as $task): ?>
        <div class="task-card">
            <div class="task-card-header" style="background: <?= badgeColor($task['warna']) ?>;">
                <span><?= strtoupper(e($task['nama_mapel'])) ?></span>
                <span><?= $task['status'] === 'belum' ? '⏰ ' . date('d M', strtotime($task['deadline'])) : '✅ SELESAI' ?></span>
            </div>
            <div class="task-card-body">
                <h3 class="<?= $task['status'] === 'selesai' ? 'done-title' : '' ?>"><?= e($task['judul']) ?></h3>
                <p><?= e($task['deskripsi']) ?></p>
                <div class="task-deadline">📅 Deadline: <?= date('d M Y', strtotime($task['deadline'])) ?></div>

                <?php if ($task['status'] === 'belum'): ?>
                    <div class="status-tag status-belum">BELUM DIKUMPULKAN</div>
                <?php else: ?>
                    <div class="status-tag status-selesai">SUDAH DIKUMPULKAN</div>
                <?php endif; ?>

                <div class="task-actions">
                    <a href="task-detail.php?id=<?= $task['id'] ?>" class="btn">DETAIL</a>
                    <?php if ($task['status'] === 'belum'): ?>
                        <a href="task-submit.php?id=<?= $task['id'] ?>" class="btn btn-yellow">KUMPULKAN</a>
                    <?php else: ?>
                        <a href="task-detail.php?id=<?= $task['id'] ?>" class="btn">LIHAT JAWABAN</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
