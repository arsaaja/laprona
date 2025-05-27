<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_SESSION['id_mentor'])) {
    $id_mentor = $_SESSION['id_mentor'];
    $nama_mentor = $_POST['nama_mentor'];
    $id_bidang_ajar = $_POST['id_bidang_ajar'];

    if (empty($nama_mentor)) {
        header("Location:mentor_edit.php?data=$id_mentor&notif=editkosong");
    } else {
        $sql = "UPDATE mentor
            SET nama_mentor = '$nama_mentor', id_bidang_ajar = '$id_bidang_ajar'
            WHERE id_mentor = '$id_mentor'";
        mysqli_query($koneksi, $sql);
        unset($_SESSION['id_mentor']);
        header("Location:mentor.php?notif=editberhasil");
    }
}
?>