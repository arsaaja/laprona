<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
$user = currentUser();
$db = getDB();

// Ambil kelas siswa ini (ambil kelas pertama tempat dia terdaftar)
$stmt = $db->prepare('SELECT c.* FROM classes c
    JOIN class_members cm ON cm.class_id = c.id
    WHERE cm.user_id = ? LIMIT 1');
$stmt->execute([$user['id']]);
$myClass = $stmt->fetch();

// Ranking dummy sederhana: hitung jumlah submission "selesai" milik semua siswa di kelas yang sama
$rank = 1;
$totalSiswa = 0;
if ($myClass) {
    $stmt = $db->prepare('SELECT cm.user_id, COUNT(s.id) as total_selesai
        FROM class_members cm
        LEFT JOIN submissions s ON s.user_id = cm.user_id AND s.status = "selesai"
        WHERE cm.class_id = ?
        GROUP BY cm.user_id
        ORDER BY total_selesai DESC');
    $stmt->execute([$myClass['id']]);
    $rows = $stmt->fetchAll();
    $totalSiswa = count($rows);
    foreach ($rows as $i => $row) {
        if ($row['user_id'] == $user['id']) { $rank = $i + 1; break; }
    }
}

// Progress: persentase tugas yang sudah dikumpulkan dari seluruh tugas kelas
$totalTugas = 0; $totalSelesai = 0;
if ($myClass) {
    $stmt = $db->prepare('SELECT COUNT(*) as total FROM tasks WHERE class_id = ?');
    $stmt->execute([$myClass['id']]);
    $totalTugas = (int) $stmt->fetch()['total'];

    $stmt = $db->prepare('SELECT COUNT(*) as total FROM submissions WHERE user_id = ? AND status = "selesai"');
    $stmt->execute([$user['id']]);
    $totalSelesai = (int) $stmt->fetch()['total'];
}
$progress = $totalTugas > 0 ? round(($totalSelesai / $totalTugas) * 100) : 0;

// 3 tugas terbaru untuk kelasnya
$recentTasks = [];
if ($myClass) {
    $stmt = $db->prepare('SELECT t.*, sub.nama_mapel, sub.warna,
            (SELECT status FROM submissions WHERE task_id = t.id AND user_id = ?) as my_status
        FROM tasks t
        JOIN subjects sub ON sub.id = t.subject_id
        WHERE t.class_id = ?
        ORDER BY t.deadline ASC LIMIT 3');
    $stmt->execute([$user['id'], $myClass['id']]);
    $recentTasks = $stmt->fetchAll();
}

include __DIR__ . '/../app/views/layouts/header.php';
?>

<div class="grid-2">
    <div class="box box-yellow">
        <h1>Selamat Datang, <?= e(explode(' ', $user['nama'])[0]) ?>!</h1>
        <p>Progres tugas kamu sudah <?= $progress ?>% selesai. Terus semangat!</p>
        <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width: <?= $progress ?>%;"></div>
        </div>
        <div class="rank-card" style="margin-top:20px; width:220px;">
            <small>CURRENT RANK</small>
            <div class="rank-number">#<?= $rank ?></div>
            <small>Out of <?= $totalSiswa ?> Students</small>
        </div>
    </div>
    <div class="box box-pink">
        <h2>🎓</h2>
        <h2>Active Class</h2>
        <span class="btn" style="background:#111; color:#fff;"><?= e($myClass['nama_kelas'] ?? '-') ?></span>
    </div>
</div>

<h3>Tugas Terbaru</h3>
<div class="card-grid">
    <?php if (empty($recentTasks)): ?>
        <p>Belum ada tugas untuk kelasmu.</p>
    <?php endif; ?>
    <?php foreach ($recentTasks as $task): ?>
        <div class="task-card">
            <div class="task-card-header" style="background: <?= badgeColor($task['warna']) ?>;">
                <?= strtoupper(e($task['nama_mapel'])) ?>
            </div>
            <div class="task-card-body">
                <h3><?= e($task['judul']) ?></h3>
                <div class="task-deadline <?= $task['my_status'] !== 'selesai' ? 'warn' : '' ?>">
                    📅 <?= date('d M Y', strtotime($task['deadline'])) ?>
                </div>
                <a href="task-detail.php?id=<?= $task['id'] ?>" class="btn">Lihat Detail</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
