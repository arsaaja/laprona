<?php
include('../koneksi/koneksi.php');
$topik = $_POST['topik'];
if (empty($topik)) {
    header("Location:tambahtopik.php?notif=tambahkosong");
} else {
    $sql = "insert into `master_topik` (`topik`)
        values ('$topik')";
    mysqli_query($koneksi, $sql);
    header("Location:topik.php?notif=tambahberhasil");
}
?>