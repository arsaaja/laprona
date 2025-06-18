<?php
session_start();
include('../koneksi/koneksi.php');

if (isset($_SESSION['id_siswa'])) {
    $id_siswa = $_SESSION['id_siswa'];

    $nama_siswa_baru = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $id_kelas_baru = mysqli_real_escape_string($koneksi, $_POST['id_kelas']); 
    $sql_get_id_user = "SELECT id_user FROM `siswa` WHERE `id_siswa` = '" . mysqli_real_escape_string($koneksi, $id_siswa) . "'";
    $query_get_id_user = mysqli_query($koneksi, $sql_get_id_user);
    $data_get_id_user = mysqli_fetch_assoc($query_get_id_user);
    $id_user = $data_get_id_user['id_user'];

    if (empty($nama_siswa_baru) || empty($id_kelas_baru)) {
        header("Location:siswa_edit.php?data=$id_siswa&notif=editkosong");
        exit();
    } else {
        if ($id_user) {
            $sql_update_user = "UPDATE `user` SET `nama` = '$nama_siswa_baru' WHERE `id_user` = '" . mysqli_real_escape_string($koneksi, $id_user) . "'";
            mysqli_query($koneksi, $sql_update_user);
        }

        $sql_update_siswa = "UPDATE `siswa` SET `id_kelas` = '$id_kelas_baru' WHERE `id_siswa` = '" . mysqli_real_escape_string($koneksi, $id_siswa) . "'";
        mysqli_query($koneksi, $sql_update_siswa);

        unset($_SESSION['id_siswa']);
        header("Location:siswa.php?notif=editberhasil");
        exit();
    }
} else {
    header("Location:siswa.php?notif=error");
    exit();
}
?>