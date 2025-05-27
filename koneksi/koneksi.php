<?php
$koneksi = mysqli_connect("localhost", "root", "", "laprona");
// cek koneksi
if (!$koneksi) {
  die("Error koneksi: " . mysqli_connect_errno());
}
?>