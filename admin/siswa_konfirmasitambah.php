<?php
include('../koneksi/koneksi.php');
$nama_siswa = $_POST['nama_siswa'];
$id_kelas_siswa = $_POST['id_kelas'];

if (empty($nama_siswa)) {
    header("Location:siswa_tambah.php?notif=tambahkosong");
} else {
   $sql_user = "INSERT INTO `user` (`nama`) 
                 VALUES ('$nama_siswa', '-', '-', 'siswa')";
    mysqli_query($koneksi, $sql_user);

    $id_user = mysqli_insert_id($koneksi);

    $sql_siswa = "INSERT INTO `siswa` (`id_user`, `id_kelas`) 
                  VALUES ('$id_user', '$id_kelas_siswa')";
    mysqli_query($koneksi, $sql_siswa);
    header("Location:siswa.php?notif=tambahberhasil");
}
?>