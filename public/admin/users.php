<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

// Hapus user
if (isset($_GET['delete'])) {
    $delId = (int) $_GET['delete'];
    if ($delId === $_SESSION['user_id']) {
        flash('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
    } else {
        $db->prepare('DELETE FROM users WHERE id = ?')->execute([$delId]);
        flash('success', 'User berhasil dihapus.');
    }
    header('Location: users.php');
    exit;
}

$users = $db->query('SELECT * FROM users ORDER BY role, nama')->fetchAll();

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header">
    <h1>Kelola User</h1>
    <a href="user-form.php" class="btn btn-yellow">+ Tambah User</a>
</div>

<table class="data-table">
    <tr>
        <th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th>
    </tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= e($u['nama']) ?></td>
            <td><?= e($u['email']) ?></td>
            <td><span class="role-pill role-<?= $u['role'] ?>"><?= strtoupper($u['role']) ?></span></td>
            <td>
                <a href="user-form.php?id=<?= $u['id'] ?>" class="btn btn-sm">Edit</a>
                <a href="users.php?delete=<?= $u['id'] ?>" class="btn btn-sm btn-red" onclick="return confirm('Hapus user ini?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
