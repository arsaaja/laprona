<?php
session_start();
include('../koneksi/koneksi.php');

$nama_mentor = '';       // Initialize variables
$id_bidang_ajar = '';    // to prevent undefined notices
$_SESSION['id_user_for_mentor'] = ''; // Initialize session variable

if (isset($_GET['data'])) {
    $id_mentor = mysqli_real_escape_string($koneksi, $_GET['data']); // Sanitize input
    $_SESSION['id_mentor'] = $id_mentor;

    // Fetch mentor data, joining with 'user' table for 'nama'
    $sql_d = "SELECT m.id_mentor, u.nama AS nama_mentor, m.id_bidang_ajar, u.id_user
              FROM `mentor` m
              LEFT JOIN `user` u ON m.id_user = u.id_user
              WHERE m.id_mentor = '$id_mentor'";

    $query_d = mysqli_query($koneksi, $sql_d);

    // Check if any row was returned
    if (mysqli_num_rows($query_d) > 0) {
        $data_d = mysqli_fetch_assoc($query_d); // Use mysqli_fetch_assoc for easier access by column name

        $nama_mentor = $data_d['nama_mentor'];
        $id_bidang_ajar = $data_d['id_bidang_ajar'];
        $_SESSION['id_user_for_mentor'] = $data_d['id_user']; // Store id_user in session for konfirmasiedit
    } else {
        // Handle case where no mentor found with the given ID
        header("Location:mentor.php?notif=dataNotFound");
        exit(); // Always exit after a header redirect
    }
} else {
    // Redirect if no data parameter is provided (e.g., direct access)
    header("Location:mentor.php");
    exit(); // Always exit after a header redirect
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
                            <h3><i class="fas fa-edit"></i> Edit Mentor</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="mentor.php">Mentor</a></li>
                                <li class="breadcrumb-item active">Edit Mentor</li>
                            </ol>
                        </div>
                    </div>
                </div></section>

            <section class="content">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit Mentor
                        </h3>
                        <div class="card-tools">
                            <a href="mentor.php" class="btn btn-sm btn-warning float-right"><i
                                    class="fas fa-arrow-alt-circle-left"></i>
                                Kembali</a>
                        </div>
                    </div>
                    </br>
                    <?php if (!empty($_GET['notif'])) { ?>
                        <?php if ($_GET['notif'] == "editkosong") { ?>
                            <div class="alert alert-danger" role="alert">
                                Maaf data mentor wajib di isi</div>
                        <?php } ?>
                    <?php } ?>
                    <form class="form-horizontal" method="post" action="mentor_konfirmasiedit.php">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="mentor" class="col-sm-3 col-form-label">Mentor</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="mentor" name="nama_mentor"
                                        value="<?php echo htmlspecialchars($nama_mentor); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bidang_ajar" class="col-sm-3 col-form-label">Bidang Ajar</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="id_bidang_ajar" required>
                                        <option value="">-- Pilih Bidang Ajar --</option>
                                        <?php
                                        $sql_b = "SELECT id_bidang_ajar, bidang_ajar FROM bidang_ajar ORDER BY bidang_ajar";
                                        $query_b = mysqli_query($koneksi, $sql_b);
                                        while ($data_b = mysqli_fetch_array($query_b)) {
                                            $selected = ($data_b['id_bidang_ajar'] == $id_bidang_ajar) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($data_b['id_bidang_ajar']) . "' $selected>" . htmlspecialchars($data_b['bidang_ajar']) . "</option>";
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