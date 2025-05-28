<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_SESSION['id_tugas'])) {
    $id_tugas = $_SESSION['id_tugas'];

    $judul_tugas = $_POST['judul_tugas'];
    $skor_tugas = $_POST['skor_tugas'];
    $deadline_tugas = $_POST['deadline_tugas'];

    if (empty($judul_tugas)) {
        header("Location:tugas_edit.php?data=$id_tugas&notif=editkosong");
    } else {
        $sql = "UPDATE tugas
            SET judul_tugas = '$judul_tugas', skor_tugas = '$skor_tugas', deadline_tugas = '$deadline_tugas'
            WHERE id_tugas = '$id_tugas'";
        mysqli_query($koneksi, $sql);
        unset($_SESSION['id_tugas']);
        header("Location:tugas.php?notif=editberhasil");
    }
}
?>