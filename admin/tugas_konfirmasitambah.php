<?php
include('../koneksi/koneksi.php');
$judul_tugas = $_POST['judul_tugas'];
$skor_tugas = $_POST['skor_tugas'];
$deadline_tugas = $_POST['deadline_tugas'];

if (empty($judul_tugas)) {
    header("Location:tugas_tambah.php?notif=tambahkosong");
} else {
    $sql = "insert into `tugas` (`judul_tugas`,`skor_tugas`,`deadline_tugas`)
        values ('$judul_tugas', '$skor_tugas', '$deadline_tugas')";
    mysqli_query($koneksi, $sql);
    header("Location:tugas.php?notif=tambahberhasil");
}
?>