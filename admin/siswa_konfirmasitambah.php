<?php
include('../koneksi/koneksi.php');
$nama_siswa = $_POST['nama_siswa'];
$id_kelas_siswa = $_POST['id_kelas'];

if (empty($nama_siswa)) {
    header("Location:siswa_tambah.php?notif=tambahkosong");
} else {
    $sql = "insert into `siswa` (`nama_siswa`,`id_kelas`)
        values ('$nama_siswa', '$id_kelas_siswa')";
    mysqli_query($koneksi, $sql);
    header("Location:siswa.php?notif=tambahberhasil");
}
?>