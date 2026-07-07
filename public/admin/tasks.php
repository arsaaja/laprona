<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

if (isset($_GET['delete'])) {
    $db->prepare('DELETE FROM tasks WHERE id = ?')->execute([(int) $_GET['delete']]);
    flash('success', 'Tugas berhasil dihapus.');
    header('Location: tasks.php');
    exit;
}

$tasks = $db->query('SELECT t.*, sub.nama_mapel, c.nama_kelas,
        (SELECT COUNT(*) FROM submissions WHERE task_id = t.id AND status = "selesai") as total_selesai
    FROM tasks t
    JOIN subjects sub ON sub.id = t.subject_id
    JOIN classes c ON c.id = t.class_id
    ORDER BY t.deadline DESC')->fetchAll();

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header">
    <h1>Kelola Tugas</h1>
    <a href="task-form.php" class="btn btn-yellow">+ Tambah Tugas</a>
</div>

<table class="data-table">
    <tr>
        <th>Judul</th><th>Mapel</th><th>Kelas</th><th>Deadline</th><th>Terkumpul</th><th>Aksi</th>
    </tr>
    <?php foreach ($tasks as $t): ?>
        <tr>
            <td><?= e($t['judul']) ?></td>
            <td><?= e($t['nama_mapel']) ?></td>
            <td><?= e($t['nama_kelas']) ?></td>
            <td><?= date('d M Y', strtotime($t['deadline'])) ?></td>
            <td><?= $t['total_selesai'] ?> siswa</td>
            <td>
                <a href="submissions.php?task_id=<?= $t['id'] ?>" class="btn btn-sm">Lihat</a>
                <a href="task-form.php?id=<?= $t['id'] ?>" class="btn btn-sm">Edit</a>
                <a href="tasks.php?delete=<?= $t['id'] ?>" class="btn btn-sm btn-red" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
