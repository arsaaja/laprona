<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_SESSION['id_siswa'])) {
    $id_siswa = $_SESSION['id_siswa'];
    $nama_siswa = $_POST['nama_siswa'];
    $id_kelas = $_POST['nama_kelas'];

    if (empty($nama_siswa)) {
        header("Location:siswa_edit.php?data=$id_siswa&notif=editkosong");
    } else {
        $sql = "UPDATE siswa
            SET nama_siswa = '$nama_siswa', id_kelas = '$id_kelas'
            WHERE id_siswa = '$id_siswa'";
        mysqli_query($koneksi, $sql);
        unset($_SESSION['id_siswa']);
        header("Location:siswa.php?notif=editberhasil");
    }
}
?>