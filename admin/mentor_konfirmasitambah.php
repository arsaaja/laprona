<?php
include('../koneksi/koneksi.php');
$nama_mentor = $_POST['nama_mentor'];
$id_bidang_ajar = $_POST['id_bidang_ajar'];

if (empty($nama_mentor)) {
    header("Location:mentor_tambah.php?notif=tambahkosong");
} else {
    $sql = "insert into `mentor` (`nama_mentor`,`id_bidang_ajar`)
        values ('$nama_mentor', '$id_bidang_ajar')";
    mysqli_query($koneksi, $sql);
    header("Location:mentor.php?notif=tambahberhasil");
}
?>