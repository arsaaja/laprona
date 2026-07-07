<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

if (isset($_GET['delete'])) {
    $db->prepare('DELETE FROM announcements WHERE id = ?')->execute([(int) $_GET['delete']]);
    flash('success', 'Pengumuman berhasil dihapus.');
    header('Location: announcements.php');
    exit;
}

$items = $db->query('SELECT a.*, c.nama_kelas, sub.nama_mapel
    FROM announcements a
    JOIN classes c ON c.id = a.class_id
    LEFT JOIN subjects sub ON sub.id = a.subject_id
    ORDER BY a.created_at DESC')->fetchAll();

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header">
    <h1>Kelola Pengumuman</h1>
    <a href="announcement-form.php" class="btn btn-yellow">+ Tambah Pengumuman</a>
</div>

<table class="data-table">
    <tr><th>Judul</th><th>Kelas</th><th>Mapel</th><th>Tanggal</th><th>Aksi</th></tr>
    <?php foreach ($items as $a): ?>
        <tr>
            <td><?= e($a['judul']) ?></td>
            <td><?= e($a['nama_kelas']) ?></td>
            <td><?= e($a['nama_mapel'] ?? '-') ?></td>
            <td><?= date('d M Y', strtotime($a['created_at'])) ?></td>
            <td>
                <a href="announcement-form.php?id=<?= $a['id'] ?>" class="btn btn-sm">Edit</a>
                <a href="announcements.php?delete=<?= $a['id'] ?>" class="btn btn-sm btn-red" onclick="return confirm('Hapus pengumuman ini?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
