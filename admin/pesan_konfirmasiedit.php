<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_SESSION['id_master_topik'])) {
    $id_master_topik = $_SESSION['id_master_topik'];
    $topik = $_POST['topik'];

    if (empty($topik)) {
        header("Location:edittopik.php?data=" . $id_master_topik . "&notif
=editkosong");
    } else {
        $sql = "update `master_topik` set
        `topik`='$topik'
        where `id_master_topik`='$id_master_topik'";
        mysqli_query($koneksi, $sql);
        unset($_SESSION['id_master_topik']);
        header("Location:topik.php?notif=editberhasil");
    }
}
?>