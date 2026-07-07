<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
$user = currentUser();
$db = getDB();

$stmt = $db->prepare('SELECT c.id FROM classes c JOIN class_members cm ON cm.class_id = c.id WHERE cm.user_id = ? LIMIT 1');
$stmt->execute([$user['id']]);
$myClass = $stmt->fetch();

$announcements = [];
if ($myClass) {
    $stmt = $db->prepare('SELECT a.*, u.nama as penulis, sub.nama_mapel, sub.warna
        FROM announcements a
        JOIN users u ON u.id = a.guru_id
        LEFT JOIN subjects sub ON sub.id = a.subject_id
        WHERE a.class_id = ? ORDER BY a.created_at DESC');
    $stmt->execute([$myClass['id']]);
    $announcements = $stmt->fetchAll();
}

include __DIR__ . '/../app/views/layouts/header.php';
?>

<h1>Semua Pengumuman</h1>

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

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
