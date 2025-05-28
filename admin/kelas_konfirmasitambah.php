<?php
include('../koneksi/koneksi.php');
$nama_kelas = $_POST['nama_kelas'];
$subjek_kelas = $_POST['subjek_kelas'];
$id_jenjang = $_POST['id_jenjang_pendidikan'];

if (empty($nama_kelas)) {
    header("Location:kelas_tambah.php?notif=tambahkosong");
} else if (empty($subjek_kelas)) {
    header("Location:kelas_tambah.php?notif=tambahkosong");
} else {
    $sql = "insert into `kelas` (`nama_kelas`,`subjek_kelas`,`id_jenjang`)
        values ('$nama_kelas', '$subjek_kelas','$id_jenjang')";
    mysqli_query($koneksi, $sql);
    header("Location:kelas.php?notif=tambahberhasil");
}
?>