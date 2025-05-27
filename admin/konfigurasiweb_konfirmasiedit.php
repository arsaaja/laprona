<?php
session_start();
include('../koneksi/koneksi.php');

$nama_web = $_POST['nama_web'];
$tahun = $_POST['tahun'];

$id_konfigurasi_web = 1;

if (empty($nama_web)) {
    header("Location:konfigurasiweb.php?data=" . $id_konfigurasi_web . "&notif=editkosong");
} else if (empty($tahun)) {
    header("Location:konfigurasiweb.php?data=" . $id_konfigurasi_web . "&notif=editkosong");
} else {
    $sql = "UPDATE `konfigurasi_web` 
            SET `nama_web` = '$nama_web',
                `tahun` = '$tahun' 
            WHERE `id_konfigurasi_web` = $id_konfigurasi_web";
    mysqli_query($koneksi, $sql);

    header("Location:konfigurasiweb.php?notif=editberhasil");
}
?>