<?php
session_start();
include('../koneksi/koneksi.php');

if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    if (empty($nama)) {
        header("Location:profil_edit.php?notif=editkosong&jenis=nama");
    } else if (empty($email)) {
        header("Location:profil_edit.php?notif=editkosong&jenis=email");
    } else {
        $sql = "UPDATE `user` SET `nama`='$nama', `email`='$email' WHERE `id_user`='$id_user'";

        if (mysqli_query($koneksi, $sql)) {
            header("Location:profil.php?notif=editberhasil");
        } else {
            echo "Error updating record: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location:login.php");
}
?>