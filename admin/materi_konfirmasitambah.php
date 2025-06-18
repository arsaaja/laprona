<?php
include('../koneksi/koneksi.php');

$nama_materi = $_POST['nama_materi'];
$isi_materi = $_POST['isi_materi'];
$id_subjek = $_POST['id_subjek'];
$id_kelas = $_POST['id_kelas'];

if (empty($nama_materi)) {
    header("Location:materi_tambah.php?notif=tambahkosong&jenis=nama_materi");
    exit();
} else if (empty($isi_materi)) {
    header("Location:materi_tambah.php?notif=tambahkosong&jenis=isi_materi");
    exit();
} else if (empty($id_subjek)) {
    header("Location:materi_tambah.php?notif=tambahkosong&jenis=id_subjek");
    exit();
} else if (empty($id_kelas)) {
    header("Location:materi_tambah.php?notif=tambahkosong&jenis=id_kelas");
    exit();
} else {
    $nama_materi = mysqli_real_escape_string($koneksi, $nama_materi);
    $isi_materi = mysqli_real_escape_string($koneksi, $isi_materi);
    $id_subjek = mysqli_real_escape_string($koneksi, $id_subjek);
    $id_kelas = mysqli_real_escape_string($koneksi, $id_kelas);

    $sql = "INSERT INTO `materi` (`nama_materi`, `isi_materi`, `id_subjek`, `id_kelas`)
            VALUES ('$nama_materi', '$isi_materi', '$id_subjek', '$id_kelas')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location:materi.php?notif=tambahberhasil");
        exit();
    } else {
        error_log("Error inserting new materi: " . mysqli_error($koneksi));
        header("Location:materi_tambah.php?notif=gagalinput"); // Notifikasi gagal input
        exit();
    }
}
?>