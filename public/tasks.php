<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();

$filter = $_GET['filter'] ?? 'semua'; // semua | belum | selesai

$tasks = $DUMMY_TASKS;
if ($filter === 'belum') {
    $tasks = array_filter($tasks, fn($t) => $t['status'] === 'belum');
} elseif ($filter === 'selesai') {
    $tasks = array_filter($tasks, fn($t) => $t['status'] === 'selesai');
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
    <?php foreach ($tasks as $task): ?>
        <div class="task-card">
            <div class="task-card-header" style="background: <?= badgeColor($task['warna']) ?>;">
                <span><?= strtoupper(e($task['mapel'])) ?></span>
                <span><?= $task['sisa_waktu'] ? '⏰ ' . e($task['sisa_waktu']) : '✅ SELESAI' ?></span>
            </div>
            <div class="task-card-body">
                <h3 class="<?= $task['status'] === 'selesai' ? 'done-title' : '' ?>"><?= e($task['judul']) ?></h3>
                <p><?= e($task['deskripsi']) ?></p>
                <div class="task-deadline">📅 <?= e($task['deadline']) ?></div>

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
