<?php
include('../koneksi/koneksi.php');
$nama_mentor = $_POST['nama_mentor'];
if (empty($nama_mentor)) {
    header("Location:mentor_tambah.php?notif=tambahkosong");
} else {
    $sql = "insert into `mentor` (`nama_mentor`)
        values ('$nama_mentor')";
    mysqli_query($koneksi, $sql);
    header("Location:mentor.php?notif=tambahberhasil");
}
?>