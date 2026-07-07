<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

$totalUser = $db->query("SELECT COUNT(*) c FROM users WHERE role='user'")->fetch()['c'];
$totalAdmin = $db->query("SELECT COUNT(*) c FROM users WHERE role='admin'")->fetch()['c'];
$totalTasks = $db->query("SELECT COUNT(*) c FROM tasks")->fetch()['c'];
$totalSubmit = $db->query("SELECT COUNT(*) c FROM submissions WHERE status='selesai'")->fetch()['c'];

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header"><h1>Dashboard Admin</h1></div>

<div class="stat-grid">
    <div class="stat-card yellow">
        <div class="num"><?= $totalUser ?></div>
        <div>Total Siswa</div>
    </div>
    <div class="stat-card cyan">
        <div class="num"><?= $totalAdmin ?></div>
        <div>Total Admin/Guru</div>
    </div>
    <div class="stat-card pink">
        <div class="num"><?= $totalTasks ?></div>
        <div>Total Tugas</div>
    </div>
    <div class="stat-card">
        <div class="num"><?= $totalSubmit ?></div>
        <div>Tugas Terkumpul</div>
    </div>
</div>

<div class="box box-white">
    <h3>Menu Cepat</h3>
    <p>Gunakan menu di sisi kiri untuk mengelola user, tugas, pengumuman, dan jadwal kelas.</p>
    <a href="users.php" class="btn btn-yellow">Kelola User</a>
    <a href="tasks.php" class="btn">Kelola Tugas</a>
    <a href="announcements.php" class="btn">Kelola Pengumuman</a>
</div>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
