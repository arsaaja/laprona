<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_SESSION['id_materi'])) {
    $id_materi = $_SESSION['id_materi'];
    $nama_materi = $_POST['nama_materi'];
    $isi_materi = $_POST['isi_materi'];

    if (empty($nama_materi)) {
        header("Location:materi_edit.php?data=$id_materi&notif=editkosong");
    } else {
        $sql = "UPDATE materi
            SET nama_materi = '$nama_materi', isi_materi = '$isi_materi'
            WHERE id_materi = '$id_materi'";
        mysqli_query($koneksi, $sql);
        unset($_SESSION['id_materi']);
        header("Location:materi.php?notif=editberhasil");
    }
}
?>