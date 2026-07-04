<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
include __DIR__ . '/../app/views/layouts/header.php';
?>

<h1>Semua Pengumuman</h1>

<?php foreach ($DUMMY_ANNOUNCEMENTS as $a): ?>
    <div class="announcement-card">
        <div class="announcement-card-top top-<?= $a['warna'] ?>"></div>
        <div class="announcement-card-body">
            <div class="announcement-author">
                <div class="avatar-circle"></div>
                <div>
                    <strong><?= strtoupper(e($a['penulis'])) ?> • <?= strtoupper(e($a['mapel'])) ?></strong>
                    <small>Postingan <?= e($a['waktu']) ?></small>
                </div>
            </div>
            <h3><?= e($a['judul']) ?></h3>
            <p><?= e($a['isi']) ?></p>
            <?php foreach ($a['tag'] as $tag): ?>
                <span class="tag-pill tag-<?= strtolower($tag) ?>"><?= e($tag) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
