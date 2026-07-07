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
    <style>
        .admin-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ddd;
            /* Warna default font text (putih redup/abu) */
        }

        /* 1. MENGUBAH ICON JADI PUTIH DEFAULT */
        .admin-menu a img.menu-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
            filter: invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);
            transition: filter 0.1s ease;
        }

        /* 2. MENGUBAH ICON JADI HITAM SAAT ACTIVE ATAU HOVER */
        .admin-menu a.active img.menu-icon,
        .admin-menu a:hover img.menu-icon {
            filter: invert(0%) brightness(0%);
            /* Kembalikan ke warna asli hitam #111 */
        }

        /* 3. MENYESUAIKAN FONT TEXT JADI PUTIH DAN HOVER JADI HITAM */
        .admin-menu a {
            color: #fff !important;
            /* Memaksa font text default jadi putih bersih */
        }

        .admin-menu a.active,
        .admin-menu a:hover {
            color: #111 !important;
            /* Memaksa font text saat active/hover jadi hitam pekat */
        }
    </style>
</head>

<body class="admin-body">
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-brand"><?= APP_NAME ?><br><small>Admin Panel</small></div>
            <nav class="admin-menu">
                <a href="dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">
                    <img src="https://unpkg.com/bootstrap-icons@1.11.3/icons/speedometer2.svg" alt="Dashboard"
                        class="menu-icon"> Dashboard
                </a>
                <a href="users.php"
                    class="<?= in_array($currentPage, ['users.php', 'user-form.php']) ? 'active' : '' ?>">
                    <img src="https://unpkg.com/bootstrap-icons@1.11.3/icons/people-fill.svg" alt="Users"
                        class="menu-icon"> Kelola User
                </a>
                <a href="tasks.php"
                    class="<?= in_array($currentPage, ['tasks.php', 'task-form.php', 'submissions.php']) ? 'active' : '' ?>">
                    <img src="https://unpkg.com/bootstrap-icons@1.11.3/icons/file-earmark-text.svg" alt="Tasks"
                        class="menu-icon"> Kelola Tugas
                </a>
                <a href="announcements.php"
                    class="<?= in_array($currentPage, ['announcements.php', 'announcement-form.php']) ? 'active' : '' ?>">
                    <img src="https://unpkg.com/bootstrap-icons@1.11.3/icons/megaphone.svg" alt="Announcements"
                        class="menu-icon"> Pengumuman
                </a>
                <a href="schedule.php"
                    class="<?= in_array($currentPage, ['schedule.php', 'schedule-form.php']) ? 'active' : '' ?>">
                    <img src="https://unpkg.com/bootstrap-icons@1.11.3/icons/calendar3.svg" alt="Schedule"
                        class="menu-icon"> Jadwal
                </a>
                <a href="master.php" class="<?= $currentPage === 'master.php' ? 'active' : '' ?>">
                    <img src="https://unpkg.com/bootstrap-icons@1.11.3/icons/tags.svg" alt="Master" class="menu-icon">
                    Kelas & Mapel
                </a>
                <hr>
                <a href="<?= BASE_URL ?>/dashboard.php">
                    <img src="https://unpkg.com/bootstrap-icons@1.11.3/icons/arrow-left-square.svg" alt="Back"
                        class="menu-icon"> Kembali ke Situs User
                </a>
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