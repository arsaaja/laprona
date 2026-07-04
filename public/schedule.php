<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
include __DIR__ . '/../app/views/layouts/header.php';
?>

<h1><?= e($DUMMY_CLASS_INFO['nama_kelas']) ?></h1>
<p>Selamat datang di pusat informasi kelas. Tetap update dengan pengumuman dan jadwal terbaru!</p>

<div class="grid-2">
    <div>
        <h2>📢 Pengumuman Terbaru</h2>
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
    </div>

    <div>
        <div class="box box-yellow" style="text-align:center; margin-bottom:20px;">
            <div style="font-size:28px;">🧑‍🤝‍🧑</div>
            <h2><?= $DUMMY_CLASS_INFO['total_siswa'] ?> Siswa</h2>
            <small>TOTAL ANGGOTA KELAS</small>
        </div>

        <div class="classmate-list">
            <div class="classmate-list-header">👥 TEMAN SEKELAS</div>
            <?php foreach ($DUMMY_CLASSMATES as $c): ?>
                <div class="classmate-item">
                    <div class="avatar-circle" style="width:32px; height:32px;"></div>
                    <div>
                        <strong><?= e($c['nama']) ?></strong><br>
                        <small>Absen <?= e($c['absen']) ?> • <?= e($c['jabatan']) ?></small>
                    </div>
                    <span class="dot <?= $c['online'] ? 'dot-online' : 'dot-offline' ?>"></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<h2>🗓️ Jadwal Pelajaran</h2>
<table class="schedule-table">
    <tr>
        <th>WAKTU</th>
        <?php foreach ($DUMMY_DAYS as $day): ?>
            <th><?= $day ?></th>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($DUMMY_SCHEDULE as $waktu => $isi): ?>
        <tr>
            <td><strong><?= $waktu ?></strong></td>
            <?php if ($isi === 'ISTIRAHAT'): ?>
                <td colspan="5" class="cell-istirahat">ISTIRAHAT</td>
            <?php else: ?>
                <?php foreach ($isi as $mapel): ?>
                    <td><?= e($mapel) ?></td>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
