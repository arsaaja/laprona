<?php
include('../koneksi/koneksi.php');
$nama_materi = $_POST['nama_materi'];
$isi_materi = $_POST['isi_materi'];

if (empty($nama_materi)) {
    header("Location:materi_tambah.php?notif=tambahkosong");
} else if (empty($isi_materi)) {
    header("Location:materi_tambah.php?notif=tambahkosong");
} else {
    $sql = "insert into `materi` (`nama_materi`,`isi_materi`)
        values ('$nama_materi', '$isi_materi')";
    mysqli_query($koneksi, $sql);
    header("Location:materi.php?notif=tambahberhasil");
}
?>