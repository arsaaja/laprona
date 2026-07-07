<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

if (isset($_GET['delete'])) {
    $db->prepare('DELETE FROM schedules WHERE id = ?')->execute([(int) $_GET['delete']]);
    flash('success', 'Jadwal berhasil dihapus.');
    header('Location: schedule.php');
    exit;
}

$rows = $db->query('SELECT s.*, c.nama_kelas, sub.nama_mapel
    FROM schedules s
    JOIN classes c ON c.id = s.class_id
    LEFT JOIN subjects sub ON sub.id = s.subject_id
    ORDER BY c.nama_kelas, FIELD(s.hari,"SENIN","SELASA","RABU","KAMIS","JUMAT"), s.jam')->fetchAll();

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header">
    <h1>Kelola Jadwal</h1>
    <a href="schedule-form.php" class="btn btn-yellow">+ Tambah Jadwal</a>
</div>

<table class="data-table">
    <tr><th>Kelas</th><th>Hari</th><th>Jam</th><th>Mapel / Keterangan</th><th>Aksi</th></tr>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= e($r['nama_kelas']) ?></td>
            <td><?= e($r['hari']) ?></td>
            <td><?= e($r['jam']) ?></td>
            <td><?= e($r['keterangan'] ?: $r['nama_mapel']) ?></td>
            <td>
                <a href="schedule-form.php?id=<?= $r['id'] ?>" class="btn btn-sm">Edit</a>
                <a href="schedule.php?delete=<?= $r['id'] ?>" class="btn btn-sm btn-red" onclick="return confirm('Hapus jadwal ini?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
