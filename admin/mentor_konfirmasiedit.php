<?php
session_start();
include('../koneksi/koneksi.php');

if (isset($_SESSION['id_mentor'])) {
    $id_mentor = $_SESSION['id_mentor'];

    $id_user_for_mentor = $_SESSION['id_user_for_mentor'];

    $nama_mentor_baru = mysqli_real_escape_string($koneksi, $_POST['nama_mentor']);
    $id_bidang_ajar_baru = mysqli_real_escape_string($koneksi, $_POST['id_bidang_ajar']);

    if (empty($nama_mentor_baru) || empty($id_bidang_ajar_baru)) { 
        header("Location:mentor_edit.php?data=$id_mentor&notif=editkosong");
        exit(); 
    } else {
        if (!empty($id_user_for_mentor)) {
            $sql_update_user = "UPDATE `user`
                                SET `nama` = '$nama_mentor_baru'
                                WHERE `id_user` = '$id_user_for_mentor'";
            mysqli_query($koneksi, $sql_update_user);
        }

        $sql_update_mentor = "UPDATE `mentor`
                              SET `id_bidang_ajar` = '$id_bidang_ajar_baru'
                              WHERE `id_mentor` = '$id_mentor'";
        mysqli_query($koneksi, $sql_update_mentor);
        unset($_SESSION['id_mentor']);
        unset($_SESSION['id_user_for_mentor']);

        header("Location:mentor.php?notif=editberhasil");
        exit(); 
    }
} else {
    header("Location:mentor.php?notif=error");
    exit();
}
?>