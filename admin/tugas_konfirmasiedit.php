<?php
session_start();
include('../koneksi/koneksi.php');

if (isset($_SESSION['id_tugas'])) {
    $id_tugas = $_SESSION['id_tugas'];

    $judul_tugas = mysqli_real_escape_string($koneksi, $_POST['judul_tugas']);
    $tugas_content = mysqli_real_escape_string($koneksi, $_POST['tugas_content']); 
    $skor_tugas = mysqli_real_escape_string($koneksi, $_POST['skor_tugas']);
    $deadline_tugas = mysqli_real_escape_string($koneksi, $_POST['deadline_tugas']);
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);       
    $id_subjek = mysqli_real_escape_string($koneksi, $_POST['id_subjek']);    

    if (empty($judul_tugas) || empty($tugas_content) || empty($skor_tugas) || empty($deadline_tugas)) {
        header("Location:tugas_edit.php?data=$id_tugas&notif=editkosong");
        exit(); 
    } elseif (empty($id_kelas)) {
        header("Location:tugas_edit.php?data=$id_tugas&notif=kelasKosong");
        exit();
    } elseif (empty($id_subjek)) {
        header("Location:tugas_edit.php?data=$id_tugas&notif=subjekKosong");
        exit();
    } else {
        $sql = "UPDATE `tugas` SET
                    `judul_tugas` = '$judul_tugas',
                    `tugas` = '$tugas_content',
                    `skor_tugas` = '$skor_tugas',
                    `deadline_tugas` = '$deadline_tugas',
                    `id_kelas` = '$id_kelas',
                    `id_subjek` = '$id_subjek'
                WHERE `id_tugas` = '$id_tugas'";

        if (mysqli_query($koneksi, $sql)) {
            unset($_SESSION['id_tugas']); 
            header("Location:tugas.php?notif=editberhasil");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location:tugas.php");
    exit();
}
?>