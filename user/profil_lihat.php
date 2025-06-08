<?php
include('../koneksi/koneksi.php');
session_start();

$id_user = $_SESSION['id_user'] ?? 1;
$query = "SELECT * FROM user WHERE id_user = $id_user";
$result = mysqli_query($koneksi, $query);
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
        <h2><?= htmlspecialchars($data['nama']) ?></h2>
        <div class="profile-info">
            <strong>Email:</strong><br>
            <?= htmlspecialchars($data['email']) ?>
        </div>


        <div class="profile-info">Role: <?= htmlspecialchars($data['role']) ?></div>

        <a href="profil_edit.php" class="button-link">Edit Profil</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <script src="/laprona/js/script.js"></script>
</body>

</html>