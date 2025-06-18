<?php
session_start();
include('../koneksi/koneksi.php');

$nama_kelas = "";
$id_jenjang = "";
$selected_subjek_ids = [];

if (isset($_GET['data'])) {
    $id_kelas = mysqli_real_escape_string($koneksi, $_GET['data']);
    $_SESSION['id_kelas'] = $id_kelas; 

    $sql_kelas = "SELECT k.id_kelas, k.nama_kelas, k.id_jenjang, jp.nama_jenjang 
                  FROM kelas k
                  LEFT JOIN jenjang_pendidikan jp ON k.id_jenjang = jp.id_jenjang_pendidikan
                  WHERE k.id_kelas = '$id_kelas'";
    $query_kelas = mysqli_query($koneksi, $sql_kelas);

    if (mysqli_num_rows($query_kelas) > 0) {
        $data_kelas = mysqli_fetch_assoc($query_kelas);
        $nama_kelas = $data_kelas['nama_kelas'];
        $id_jenjang = $data_kelas['id_jenjang'];
    } else {
        header("Location: kelas.php?notif=data_tidak_ditemukan");
        exit();
    }

    
    $sql_connected_subjek = "SELECT id_subjek FROM master_kelas_subjek WHERE id_kelas = '$id_kelas'";
    $query_connected_subjek = mysqli_query($koneksi, $sql_connected_subjek);
    while ($data_subjek_terhubung = mysqli_fetch_assoc($query_connected_subjek)) {
        $selected_subjek_ids[] = $data_subjek_terhubung['id_subjek'];
    }
} else {
    header("Location: kelas.php");
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
                            <h3><i class="fas fa-edit"></i> Edit Kelas</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="kelas.php">Kelas</a></li>
                                <li class="breadcrumb-item active">Edit Kelas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit Kelas
                        </h3>
                        <div class="card-tools">
                            <a href="kelas.php" class="btn btn-sm btn-warning float-right"><i
                                    class="fas fa-arrow-alt-circle-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <?php if (!empty($_GET['notif'])): ?>
                        <?php if ($_GET['notif'] == "editkosong"): ?>
                            <div class="alert alert-danger m-3" role="alert">
                                Maaf, data kelas (nama kelas atau jenjang pendidikan) wajib diisi.
                            </div>
                        <?php elseif ($_GET['notif'] == "subjekkosong"): ?>
                            <div class="alert alert-danger m-3" role="alert">
                                Maaf, minimal satu subjek kelas harus dipilih.
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form class="form-horizontal" method="post" action="kelas_konfirmasiedit.php">
                        <div class="card-body">
                            <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">

                            <div class="form-group row">
                                <label for="nama_kelas" class="col-sm-3 col-form-label">Nama Kelas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="nama_kelas" name="nama_kelas"
                                        value="<?php echo htmlspecialchars($nama_kelas); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="subjek_kelas" class="col-sm-3 col-form-label">Subjek Kelas</label>
                                <div class="col-sm-7">
                                    <?php
                               
                                    $sql_all_subjek = "SELECT id_subjek_kelas, subjek_kelas FROM subjek_kelas ORDER BY subjek_kelas";
                                    $query_all_subjek = mysqli_query($koneksi, $sql_all_subjek);

                                    if (mysqli_num_rows($query_all_subjek) > 0) {
                                        while ($data_subjek = mysqli_fetch_assoc($query_all_subjek)) {
                                            
                                            $checked = in_array($data_subjek['id_subjek_kelas'], $selected_subjek_ids) ? 'checked' : '';
                                            ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_subjek[]"
                                                    value="<?php echo htmlspecialchars($data_subjek['id_subjek_kelas']); ?>"
                                                    id="subjek_<?php echo htmlspecialchars($data_subjek['id_subjek_kelas']); ?>"
                                                    <?php echo $checked; ?>>
                                                <label class="form-check-label"
                                                    for="subjek_<?php echo htmlspecialchars($data_subjek['id_subjek_kelas']); ?>">
                                                    <?php echo htmlspecialchars($data_subjek['subjek_kelas']); ?>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<p>Tidak ada subjek tersedia. Silakan tambahkan subjek terlebih dahulu.</p>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_jenjang_pendidikan" class="col-sm-3 col-form-label">Jenjang
                                    Pendidikan</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="id_jenjang_pendidikan" name="id_jenjang_pendidikan"
                                        required>
                                        <option value="">-- Pilih Jenjang Pendidikan --</option>
                                        <?php
                                        $sql_jenjang = "SELECT id_jenjang_pendidikan, nama_jenjang FROM jenjang_pendidikan ORDER BY nama_jenjang";
                                        $query_jenjang = mysqli_query($koneksi, $sql_jenjang);
                                        while ($data_jenjang = mysqli_fetch_assoc($query_jenjang)) {
                                            $selected = ($data_jenjang['id_jenjang_pendidikan'] == $id_jenjang) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($data_jenjang['id_jenjang_pendidikan']) . "' " . $selected . ">" . htmlspecialchars($data_jenjang['nama_jenjang']) . "</option>";
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