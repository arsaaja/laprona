<?php include('../koneksi/koneksi.php');
$query = mysqli_query($koneksi, "SELECT logo FROM konfigurasi_web LIMIT 1");
$data = mysqli_fetch_assoc($query);
$logo = $data['logo'];
?>

<a href="index.php" class="brand-link">
    <img src="/laprona/images/<?php echo $logo; ?>" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
</a>
<nav>
    <a href="kelas.php">Kelas</a>
    <a href="tugas.php">Tugas</a>
    <a href="materi.php">Materi</a>
    <a href="materi.php">Pesan</a>
</nav>
<div class="profile-menu">
    <div class="avatar" id="avatarBtn">
        <i class="fas fa-user"></i>
    </div>
    <div class="dropdown" id="dropdownMenu">
        <a href="profil_lihat.php">Lihat Profil</a>
        <a href="profil_edit.php">Edit Profil</a>
        <a href="/laprona/index.php">Logout</a>
    </div>
</div>