<?php
session_start();
include('../koneksi/koneksi.php');
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $deskripsi = $_POST['deskripsi'];
    $soft_skill = $_POST['soft_skill'];
    $hard_skill = $_POST['hard_skill'];
    //get foto
    $sql_f = "SELECT `foto` FROM `user` WHERE `id_user`='$id_user'";
    $query_f = mysqli_query($koneksi, $sql_f);
    while ($data_f = mysqli_fetch_row($query_f)) {
        $foto = $data_f[0];
        //echo $foto;
    }
    if (empty($nama)) {
        header("Location:editprofil.php?notif=editkosong&jenis=nama");
    } else if (empty($email)) {
        header("Location:editprofil.php?notif=editkosong&jenis=email");
    } else {
        $lokasi_file = $_FILES['foto']['tmp_name'];
        $nama_file = $_FILES['foto']['name'];
        $direktori = 'foto/' . $nama_file;
        if (move_uploaded_file($lokasi_file, $direktori)) {

            if (!empty($foto)) {
                unlink("foto/$foto");
            }
            $sql = "update `user` set `nama`='$nama',
`email`='$email', `foto`='$nama_file',`deskripsi`='$deskripsi'
where `id_user`='$id_user'";
            //echo $sql;
            mysqli_query($koneksi, $sql);
        } else {

            $sql = "update `user` set `nama`='$nama',
`email`='$email',`deskripsi`='$deskripsi'

where `id_user`='$id_user'";
            //echo $sql;
            mysqli_query($koneksi, $sql);
        }
        //ubah soft skill
        if (!empty($_POST['soft_skill'])) {
            //hapus soft skill
            $sql_ds = "DELETE from `soft_skill` where `id_user`='$id_user'";
            mysqli_query($koneksi, $sql_ds);
            foreach ($_POST['soft_skill'] as $id_master_soft_skill) {
                $sql_is = "INSERT INTO `soft_skill`
(`id_master_soft_skill`, `id_user`)

values ('$id_master_soft_skill', '$id_user')";
                mysqli_query($koneksi, $sql_is);
            }
        }
        //ubah hard skill
        if (!empty($_POST['hard_skill'])) {
            //hapus hard skill
            $sql_dh = "DELETE from `hard_skill` where `id_user`='$id_user'";
            mysqli_query($koneksi, $sql_dh);
            foreach ($_POST['hard_skill'] as $id_master_hard_skill) {
                $sql_ih = "INSERT INTO `hard_skill`
(`id_master_hard_skill`, `id_user`)

values ('$id_master_hard_skill', '$id_user')";
                mysqli_query($koneksi, $sql_ih);
            }
        }
        header("Location:profil.php?notif=editberhasil");
    }
}
?>