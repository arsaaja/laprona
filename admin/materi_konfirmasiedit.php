<?php
session_start();
include('../koneksi/koneksi.php');

if (isset($_SESSION['id_materi'])) {
    $id_materi = $_SESSION['id_materi'];
    $nama_materi = $_POST['nama_materi'];
    $isi_materi = $_POST['isi_materi'];
    $id_subjek = $_POST['id_subjek']; 
    $id_kelas = $_POST['id_kelas'];  

    $nama_materi_sanitized = mysqli_real_escape_string($koneksi, $nama_materi);
    $isi_materi_sanitized = mysqli_real_escape_string($koneksi, $isi_materi);
    $id_subjek_sanitized = mysqli_real_escape_string($koneksi, $id_subjek);
    $id_kelas_sanitized = mysqli_real_escape_string($koneksi, $id_kelas);

    if (empty($nama_materi) || empty($isi_materi) || empty($id_subjek) || empty($id_kelas)) {
        header("Location:materi_edit.php?data=$id_materi&notif=editkosong");
        exit();
    } else {
        $sql = "UPDATE `materi`
                SET 
                    `nama_materi` = '$nama_materi_sanitized', 
                    `isi_materi` = '$isi_materi_sanitized',
                    `id_subjek` = '$id_subjek_sanitized',
                    `id_kelas` = '$id_kelas_sanitized'
                WHERE `id_materi` = '$id_materi'";
        
        if (mysqli_query($koneksi, $sql)) {
            unset($_SESSION['id_materi']); 
            header("Location:materi.php?notif=editberhasil");
            exit();
        } else {
            error_log("Error updating materi: " . mysqli_error($koneksi)); 
            header("Location:materi_edit.php?data=$id_materi&notif=gagalupdate"); 
            exit();
        }
    }
} else {
    header("Location:materi.php");
    exit();
}
?>