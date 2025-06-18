<?php
session_start();
include('../koneksi/koneksi.php');

if (isset($_POST['nama_kelas'])) {
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama_kelas']);
    $id_jenjang = mysqli_real_escape_string($koneksi, $_POST['id_jenjang_pendidikan']);
    $selected_subjek_ids = isset($_POST['id_subjek_kelas']) ? $_POST['id_subjek_kelas'] : array();

    if (empty($nama_kelas) || empty($id_jenjang)) {
        header("Location:tambah_kelas.php?notif=tambahkosong");
        exit();
    }
    if (empty($selected_subjek_ids)) {
        header("Location:tambah_kelas.php?notif=subjekkosong");
        exit();
    }

    $sql_insert_kelas = "INSERT INTO kelas (nama_kelas, id_jenjang) VALUES ('$nama_kelas', '$id_jenjang')";
    if (mysqli_query($koneksi, $sql_insert_kelas)) {
        $id_kelas_baru = mysqli_insert_id($koneksi);

        foreach ($selected_subjek_ids as $id_subjek_kelas) {
            $id_subjek_kelas = mysqli_real_escape_string($koneksi, $id_subjek_kelas);
            $sql_insert_master = "INSERT INTO master_kelas_subjek (id_kelas, id_subjek) VALUES ('$id_kelas_baru', '$id_subjek_kelas')";
            mysqli_query($koneksi, $sql_insert_master);
        }
        header("Location:kelas.php?notif=tambahberhasil");
        exit();
    } else {
        header("Location:tambah_kelas.php?notif=gagalinsertkelas");
        exit();
    }
} else {
    header("Location:tambah_kelas.php");
    exit();
}
?>