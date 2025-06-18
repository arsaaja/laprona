<?php
session_start();
include('../koneksi/koneksi.php');

$nama_siswa = ''; 
$id_kelas_siswa = ''; 

if (isset($_GET['data'])) {
    $id_siswa = $_GET['data'];
    $_SESSION['id_siswa'] = $id_siswa;

    $sql_d = "SELECT siswa.id_siswa, user.nama AS nama_siswa, kelas.id_kelas, kelas.nama_kelas, user.id_user
              FROM siswa
              LEFT JOIN user ON siswa.id_user = user.id_user
              LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
              WHERE siswa.id_siswa = '" . mysqli_real_escape_string($koneksi, $id_siswa) . "'";

    $query_d = mysqli_query($koneksi, $sql_d);

    if (mysqli_num_rows($query_d) > 0) {
        $data_d = mysqli_fetch_assoc($query_d);

        $nama_siswa = $data_d['nama_siswa'];
        $id_kelas_siswa = $data_d['id_kelas']; 
        $_SESSION['id_user_for_siswa'] = $data_d['id_user']; 
    } else {
        header("Location:siswa.php?notif=dataNotFound");
        exit();
    }
} else {
    header("Location:siswa.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include("includes/head.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("includes/header.php") ?>
        <?php include("includes/sidebar.php") ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3><i class="fas fa-edit"></i> Edit Siswa</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="siswa.php">Siswa</a></li>
                                <li class="breadcrumb-item active">Edit Siswa</li>
                            </ol>
                        </div>
                    </div>
                </div></section>

            <section class="content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit Siswa
                        </h3>
                        <div class="card-tools">
                            <a href="siswa.php" class="btn btn-sm btn-warning float-right"><i
                                    class="fas fa-arrow-alt-circle-left"></i>
                                Kembali</a>
                        </div>
                    </div>
                    </br>
                    <?php if (!empty($_GET['notif'])) { ?>
                        <?php if ($_GET['notif'] == "editkosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Maaf data siswa wajib di isi</div>
                        <?php } ?>
                    <?php } ?>
                    <form class="form-horizontal" method="post" action="siswa_konfirmasiedit.php">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="siswa" class="col-sm-3 col-form-label">Siswa</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="siswa" name="nama_siswa"
                                        value="<?php echo htmlspecialchars($nama_siswa); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_kelas" class="col-sm-3 col-form-label">Nama Kelas</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="id_kelas" required> <option value="">-- Pilih Nama Kelas --</option>
                                        <?php
                                        $sql_b = "SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas";
                                        $query_b = mysqli_query($koneksi, $sql_b);
                                        while ($data_b = mysqli_fetch_array($query_b)) {
                                            $selected = ($data_b['id_kelas'] == $id_kelas_siswa) ? 'selected' : '';
                                            echo "<option value='" . $data_b['id_kelas'] . "' $selected>" . htmlspecialchars($data_b['nama_kelas']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-info float-right"><i class="fas fa-save"></i>
                                    Simpan</button>
                            </div>
                        </div>
                        </form>
                </div>
                </section>
            </div>
        <?php include("includes/footer.php") ?>
    </div>
    <?php include("includes/script.php") ?>
</body>
</html>