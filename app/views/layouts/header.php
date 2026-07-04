<?php
// app/views/layouts/header.php
$currentPage = basename($_SERVER['PHP_SELF']);
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
    </nav>
    <div class="navbar-user">
        <img src="<?= BASE_URL ?>/assets/img/avatars/alex.png" alt="avatar" class="avatar" onerror="this.style.display='none'">
        <span><?= e($CURRENT_USER['nama']) ?></span>
        <a href="logout.php" class="btn btn-outline">Logout</a>
    </div>
</header>
<main class="container">
