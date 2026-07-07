<?php
// app/views/layouts/admin-header.php
$currentPage = basename($_SERVER['PHP_SELF']);
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin | <?= APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body class="admin-body">
<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="admin-brand"><?= APP_NAME ?><br><small>Admin Panel</small></div>
        <nav class="admin-menu">
            <a href="dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">📊 Dashboard</a>
            <a href="users.php" class="<?= in_array($currentPage, ['users.php','user-form.php']) ? 'active' : '' ?>">👤 Kelola User</a>
            <a href="tasks.php" class="<?= in_array($currentPage, ['tasks.php','task-form.php','submissions.php']) ? 'active' : '' ?>">📝 Kelola Tugas</a>
            <a href="announcements.php" class="<?= in_array($currentPage, ['announcements.php','announcement-form.php']) ? 'active' : '' ?>">📢 Pengumuman</a>
            <a href="schedule.php" class="<?= in_array($currentPage, ['schedule.php','schedule-form.php']) ? 'active' : '' ?>">🗓 Jadwal</a>
            <a href="master.php" class="<?= $currentPage === 'master.php' ? 'active' : '' ?>">🏷 Kelas & Mapel</a>
            <hr>
            <a href="<?= BASE_URL ?>/dashboard.php">⬅ Kembali ke Situs User</a>
        </nav>
    </aside>
    <div class="admin-content">
        <header class="admin-topbar">
            <span>Selamat datang, <strong><?= e($user['nama']) ?></strong></span>
            <a href="<?= BASE_URL ?>/logout.php" class="btn btn-outline">Logout</a>
        </header>
        <main class="admin-main">
            <?php if ($msg = flash('success')): ?>
                <div class="alert alert-success"><?= e($msg) ?></div>
            <?php endif; ?>
            <?php if ($msg = flash('error')): ?>
                <div class="alert alert-error"><?= e($msg) ?></div>
            <?php endif; ?>
