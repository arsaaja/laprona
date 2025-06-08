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
    <title>Edit Profil - La Prona</title>
    <?php include("includes/head.php"); ?>
</head>

<body>
    <header>
        <?php include("includes/header.php"); ?>
    </header>

    <div class="profile-container">
        <div class="avatar">
            <i class="fas fa-user"></i>
        </div>
        <h2>Edit Profil</h2>
        <form action="simpan_profil.php" method="POST" class="edit-form">
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" placeholder="Nama Lengkap"
                required />
            <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" placeholder="Email"
                required />
            <input type="password" name="password" placeholder="Password Baru (opsional)" />
            <button type="submit" class="edit-btn">Simpan</button>
        </form>

        <a href="profil_lihat.php" class="back-link">← Kembali ke Profil</a>
    </div>

    <script src="/laprona/js/script.js"></script>
</body>

</html>