<?php
// app/views/layouts/header.php
$currentPage = basename($_SERVER['PHP_SELF']);
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= APP_NAME ?> | Bimbel Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<header class="navbar">
    <div class="navbar-brand"><?= APP_NAME ?></div>
    <nav class="navbar-menu">
        <a href="dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
        <a href="tasks.php" class="<?= $currentPage === 'tasks.php' ? 'active' : '' ?>">Tasks</a>
        <a href="schedule.php" class="<?= $currentPage === 'schedule.php' ? 'active' : '' ?>">Schedule</a>
        <a href="announcements.php" class="<?= $currentPage === 'announcements.php' ? 'active' : '' ?>">Announcements</a>
        <?php if (isAdmin()): ?>
            <a href="admin/dashboard.php" class="badge-admin">⚙ Admin Panel</a>
        <?php endif; ?>
    </nav>
    <div class="navbar-user">
        <span class="role-pill role-<?= $user['role'] ?>"><?= strtoupper($user['role']) ?></span>
        <span><?= e($user['nama']) ?></span>
        <a href="logout.php" class="btn btn-outline">Logout</a>
    </div>
</header>
<main class="container">
    <?php if ($msg = flash('success')): ?>
        <div class="alert alert-success"><?= e($msg) ?></div>
    <?php endif; ?>
    <?php if ($msg = flash('error')): ?>
        <div class="alert alert-error"><?= e($msg) ?></div>
    <?php endif; ?>
