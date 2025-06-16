<?php
session_start();
include('../koneksi/koneksi.php');

if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$query = "SELECT * FROM user WHERE id_user = $id_user";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Data user tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profil Saya - La Prona</title>
    <?php include("includes/head.php"); ?>
</head>

<body>

    <header>
        <?php include("includes/header.php"); ?>
    </header>
    <div class="profile-container">
        <div class="profile-avatar">
            <i class="fas fa-user"></i>
        </div>
        <h2><?= htmlspecialchars($data['nama'] ?? '') ?></h2>
        <div class="profile-info">
            <strong>Email:</strong><br><?= htmlspecialchars($data['email'] ?? '') ?>
        </div>
        <div class="profile-info">
            <strong>Role:</strong> <?= htmlspecialchars($data['role'] ?? '') ?>
        </div>

        <a href="profil_edit.php" class="button-link">Edit Profil</a>
    </div>

</body>

</html>