<?php
session_start();
include('../koneksi/koneksi.php');

if (isset($_POST['id_kelas'])) {
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama_kelas']);
    $id_jenjang = mysqli_real_escape_string($koneksi, $_POST['id_jenjang_pendidikan']);

    $selected_subjek_ids = isset($_POST['id_subjek']) ? $_POST['id_subjek'] : [];

    if (empty($nama_kelas) || empty($id_jenjang)) {
        header("Location:kelas_edit.php?data=" . $id_kelas . "&notif=editkosong");
        exit();
    } else if (empty($selected_subjek_ids)) {
        header("Location:kelas_edit.php?data=" . $id_kelas . "&notif=subjekkosong");
        exit();
    } else {
        mysqli_begin_transaction($koneksi);

        try {
            $sql_update_kelas = "UPDATE kelas
                                 SET nama_kelas = '$nama_kelas', id_jenjang = '$id_jenjang'
                                 WHERE id_kelas = '$id_kelas'";

            if (!mysqli_query($koneksi, $sql_update_kelas)) {
                throw new Exception("Gagal mengupdate data kelas: " . mysqli_error($koneksi));
            }

            $sql_delete_old_subjek = "DELETE FROM master_kelas_subjek WHERE id_kelas = '$id_kelas'";
            if (!mysqli_query($koneksi, $sql_delete_old_subjek)) {
                throw new Exception("Gagal menghapus relasi subjek lama: " . mysqli_error($koneksi));
            }

            foreach ($selected_subjek_ids as $id_subjek_from_checkbox) {
                $id_subjek_sanitized = mysqli_real_escape_string($koneksi, $id_subjek_from_checkbox);
                $sql_insert_new_subjek = "INSERT INTO master_kelas_subjek (id_kelas, id_subjek) 
                                          VALUES ('$id_kelas', '$id_subjek_sanitized')";
                if (!mysqli_query($koneksi, $sql_insert_new_subjek)) {
                    throw new Exception("Gagal menambahkan relasi subjek baru: " . mysqli_error($koneksi));
                }
            }

            mysqli_commit($koneksi);

            if (isset($_SESSION['id_kelas'])) {
                unset($_SESSION['id_kelas']);
            }

            header("Location: kelas.php?notif=editberhasil");
            exit();

        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            error_log("Error editing class (ID: $id_kelas): " . $e->getMessage());
            header("Location: kelas_edit.php?data=" . $id_kelas . "&notif=editgagal&pesan=" . urlencode($e->getMessage()));
            exit();
        }

    }
} else {
    header("Location: kelas.php");
    exit();
}
?>