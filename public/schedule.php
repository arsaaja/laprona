<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
$user = currentUser();
$db = getDB();

$stmt = $db->prepare('SELECT c.* FROM classes c JOIN class_members cm ON cm.class_id = c.id WHERE cm.user_id = ? LIMIT 1');
$stmt->execute([$user['id']]);
$myClass = $stmt->fetch();

$announcements = [];
$classmates = [];
$schedule = [];
$days = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];

if ($myClass) {
    $stmt = $db->prepare('SELECT a.*, u.nama as penulis, sub.nama_mapel, sub.warna
        FROM announcements a
        JOIN users u ON u.id = a.guru_id
        LEFT JOIN subjects sub ON sub.id = a.subject_id
        WHERE a.class_id = ? ORDER BY a.created_at DESC');
    $stmt->execute([$myClass['id']]);
    $announcements = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT u.nama, cm.no_absen, cm.jabatan
        FROM class_members cm JOIN users u ON u.id = cm.user_id
        WHERE cm.class_id = ? ORDER BY cm.no_absen ASC');
    $stmt->execute([$myClass['id']]);
    $classmates = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT s.*, sub.nama_mapel FROM schedules s
        LEFT JOIN subjects sub ON sub.id = s.subject_id
        WHERE s.class_id = ? ORDER BY s.jam ASC');
    $stmt->execute([$myClass['id']]);
    $rows = $stmt->fetchAll();
    foreach ($rows as $r) {
        $schedule[$r['jam']][$r['hari']] = $r['keterangan'] ?: $r['nama_mapel'];
    }
}

include __DIR__ . '/../app/views/layouts/header.php';
?>

<h1>Ruang Kelas <?= e($myClass['nama_kelas'] ?? '-') ?></h1>
<p>Selamat datang di pusat informasi kelas. Tetap update dengan pengumuman dan jadwal terbaru!</p>

<div class="grid-2">
    <div>
        <h2>📢 Pengumuman Terbaru</h2>
        <?php if (empty($announcements)): ?><p>Belum ada pengumuman.</p><?php endif; ?>
        <?php foreach ($announcements as $a): ?>
            <div class="announcement-card">
                <div class="announcement-card-top top-<?= $a['warna'] ?? 'cyan' ?>"></div>
                <div class="announcement-card-body">
                    <div class="announcement-author">
                        <div class="avatar-circle"></div>
                        <div>
                            <strong><?= strtoupper(e($a['penulis'])) ?><?= $a['nama_mapel'] ? ' • ' . strtoupper(e($a['nama_mapel'])) : '' ?></strong>
                            <small><?= date('d M Y, H:i', strtotime($a['created_at'])) ?></small>
                        </div>
                    </div>
                    <h3><?= e($a['judul']) ?></h3>
                    <p><?= e($a['isi']) ?></p>
                    <?php foreach (explode(',', $a['tag'] ?? '') as $tag): if (!$tag) continue; ?>
                        <span class="tag-pill tag-<?= strtolower(trim($tag)) ?>"><?= e(trim($tag)) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div>
        <div class="box box-yellow" style="text-align:center; margin-bottom:20px;">
            <div style="font-size:28px;">🧑‍🤝‍🧑</div>
            <h2><?= count($classmates) ?> Siswa</h2>
            <small>TOTAL ANGGOTA KELAS</small>
        </div>

        <div class="classmate-list">
            <div class="classmate-list-header">👥 TEMAN SEKELAS</div>
            <?php foreach ($classmates as $c): ?>
                <div class="classmate-item">
                    <div class="avatar-circle" style="width:32px; height:32px;"></div>
                    <div>
                        <strong><?= e($c['nama']) ?></strong><br>
                        <small>Absen <?= str_pad($c['no_absen'], 2, '0', STR_PAD_LEFT) ?> • <?= e($c['jabatan']) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<h2>🗓️ Jadwal Pelajaran</h2>
<table class="schedule-table">
    <tr>
        <th>WAKTU</th>
        <?php foreach ($days as $day): ?><th><?= $day ?></th><?php endforeach; ?>
    </tr>
    <?php foreach ($schedule as $jam => $row): ?>
        <tr>
            <td><strong><?= $jam ?></strong></td>
            <?php foreach ($days as $day):
                $val = $row[$day] ?? '';
            ?>
                <?php if (strtoupper($val) === 'ISTIRAHAT'): ?>
                    <td class="cell-istirahat">ISTIRAHAT</td>
                <?php else: ?>
                    <td><?= e($val) ?></td>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
