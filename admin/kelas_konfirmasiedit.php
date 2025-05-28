<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_SESSION['id_kelas'])) {
    $id_kelas = $_SESSION['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $subjek_kelas = $_POST['subjek_kelas'];
    $id_jenjang = $_POST['id_jenjang_pendidikan'];

    if (empty($nama_kelas)) {
        header("Location:kelas_edit.php?data=$id_kelas&notif=editkosong");
    } else {
        $sql = "UPDATE kelas
            SET nama_kelas = '$nama_kelas', subjek_kelas = '$subjek_kelas', id_jenjang = '$id_jenjang'
            WHERE id_kelas = '$id_kelas'";
        mysqli_query($koneksi, $sql);
        unset($_SESSION['id_kelas']);
        header("Location:kelas.php?notif=editberhasil");
    }
}
?>