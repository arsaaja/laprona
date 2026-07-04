<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
include __DIR__ . '/../app/views/layouts/header.php';
?>

<div class="grid-2">
    <div class="box box-yellow">
        <h1>Selamat Datang, <?= explode(' ', $CURRENT_USER['nama'])[0] ?>!</h1>
        <p>Your academic journey is <?= $CURRENT_USER['progress'] ?>% complete this semester. Keep the momentum going!</p>
        <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width: <?= $CURRENT_USER['progress'] ?>%;"></div>
        </div>
        <div class="rank-card" style="margin-top:20px; width:220px;">
            <small>CURRENT RANK</small>
            <div class="rank-number">#<?= $CURRENT_USER['rank'] ?></div>
            <small>Out of <?= $CURRENT_USER['total_siswa'] ?> Students</small>
        </div>
    </div>
    <div class="box box-pink">
        <h2>🎓</h2>
        <h2>Active Class</h2>
        <span class="btn" style="background:#111; color:#fff;"><?= e($CURRENT_USER['kelas']) ?></span>
    </div>
</div>

<h3>Ringkasan Tugas Terbaru</h3>
<div class="card-grid">
    <?php foreach (array_slice($DUMMY_TASKS, 0, 3) as $task): ?>
        <div class="task-card">
            <div class="task-card-header" style="background: <?= badgeColor($task['warna']) ?>;">
                <?= strtoupper(e($task['mapel'])) ?>
            </div>
            <div class="task-card-body">
                <h3><?= e($task['judul']) ?></h3>
                <div class="task-deadline <?= $task['status'] === 'belum' ? 'warn' : '' ?>">
                    📅 <?= e($task['deadline']) ?>
                </div>
                <a href="task-detail.php?id=<?= $task['id'] ?>" class="btn">Lihat Detail</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
