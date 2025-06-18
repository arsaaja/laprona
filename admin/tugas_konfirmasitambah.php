<?php
include('../koneksi/koneksi.php');

$judul_tugas = mysqli_real_escape_string($koneksi, $_POST['judul_tugas']);
$tugas_content = mysqli_real_escape_string($koneksi, $_POST['tugas_content']); 
$skor_tugas = mysqli_real_escape_string($koneksi, $_POST['skor_tugas']);
$deadline_tugas = mysqli_real_escape_string($koneksi, $_POST['deadline_tugas']);
$id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);       
$id_subjek = mysqli_real_escape_string($koneksi, $_POST['id_subjek']);     

if (empty($judul_tugas) || empty($tugas_content) || empty($skor_tugas) || empty($deadline_tugas)) {
    header("Location:tugas_tambah.php?notif=tambahkosong");
    exit(); 
} elseif (empty($id_kelas)) {
    header("Location:tugas_tambah.php?notif=kelasKosong");
    exit();
} elseif (empty($id_subjek)) {
    header("Location:tugas_tambah.php?notif=subjekKosong");
    exit();
} else {
    $sql = "INSERT INTO `tugas`
                (`judul_tugas`, `tugas`, `skor_tugas`, `deadline_tugas`, `id_kelas`, `id_subjek`)
            VALUES
                ('$judul_tugas', '$tugas_content', '$skor_tugas', '$deadline_tugas', '$id_kelas', '$id_subjek')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location:tugas.php?notif=tambahberhasil");
        exit();
    } else {
        echo "Error adding record: " . mysqli_error($koneksi);
       
    }
}
?>