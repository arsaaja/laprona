<?php
session_start();
include('../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_penilaian = $_POST['id_penilaian'];
    $nilai = $_POST['nilai'];

    if (empty($nilai) && $nilai !== '0') {
        header("Location: penilaian_form.php?data=$id_penilaian&notif=nilaikosong");
        exit();
    }

    $id_penilaian_bersih = mysqli_real_escape_string($koneksi, $id_penilaian);
    $nilai_bersih = mysqli_real_escape_string($koneksi, $nilai);

    if (!is_numeric($nilai_bersih) || $nilai_bersih < 0 || $nilai_bersih > 100) {
        header("Location: penilaian_form.php?data=$id_penilaian&notif=invalidnilai");
        exit();
    }

    $sql_update = "UPDATE `penilaian` SET `nilai` = '$nilai_bersih' WHERE `id_penilaian` = '$id_penilaian_bersih'";

    if (mysqli_query($koneksi, $sql_update)) {
        header("Location: penilaian.php?notif=editberhasil");
        exit();
    } else {
        header("Location: penilaian.php?notif=editgagal");
        exit();
    }
} else {
    header("Location: penilaian.php");
    exit();
}
?>