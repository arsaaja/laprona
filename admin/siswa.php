<?php
include('../koneksi/koneksi.php');

if ((isset($_GET['aksi'])) && (isset($_GET['data']))) {
  if ($_GET['aksi'] == 'hapus') {
    $id_siswa = $_GET['data'];
    $sql_dh = "DELETE FROM `siswa` WHERE `id_siswa` = ?";
    $stmt = mysqli_prepare($koneksi, $sql_dh);
    mysqli_stmt_bind_param($stmt, 'i', $id_siswa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
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
              <h3><i class="fas fa-jenjang"></i> Siswa</h3>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="card">
          <div class="card-body">
            <div class="col-md-12">
              <form method="get" action="siswa.php">
                <div class="row">
                  <div class="col-md-4 bottom-10">
                    <input type="text" class="form-control" placeholder="Cari siswa..." id="kata_kunci"
                      name="katakunci">
                  </div>
                  <div class="col-md-5 bottom-10">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp; Search</button>
                  </div>
                </div>
              </form>
            </div><br>

            <div class="col-sm-12">
              <?php if (!empty($_GET['notif'])) { ?>
                <?php if ($_GET['notif'] == "tambahberhasil") { ?>
                  <div class="alert alert-success" role="alert">Data Berhasil Ditambahkan</div>
                <?php } else if ($_GET['notif'] == "editberhasil") { ?>
                    <div class="alert alert-success" role="alert">Data Berhasil Diubah</div>
                <?php } else if ($_GET['notif'] == "hapusberhasil") { ?>
                      <div class="alert alert-success" role="alert">Data Berhasil Dihapus</div>
                <?php } ?>
              <?php } ?>
            </div>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="35%">Nama Siswa</th>
                  <th width="35%">Kelas Siswa</th>
                  <th width="15%">
                    <center>Aksi</center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $batas = 5;
                $halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
                $posisi = ($halaman - 1) * $batas;

                $katakunci = isset($_GET['katakunci']) ? $_GET['katakunci'] : '';

                $sql = "SELECT siswa.id_siswa, user.nama AS nama_siswa, kelas.nama_kelas 
                    FROM siswa 
                    LEFT JOIN user ON siswa.id_user = user.id_user 
                    LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas";

                if (!empty($katakunci)) {
                  $sql .= " WHERE user.nama LIKE '%$katakunci%' OR kelas.nama_kelas LIKE '%$katakunci%'";
                }

                $sql .= " ORDER BY user.nama ASC LIMIT $posisi, $batas";

                $query = mysqli_query($koneksi, $sql);
                $no = $posisi + 1;

                while ($data = mysqli_fetch_assoc($query)) {
                  $id_siswa = $data['id_siswa'];
                  $nama_siswa = $data['nama_siswa'];
                  $nama_kelas = $data['nama_kelas'];
                  ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $nama_siswa; ?></td>
                    <td><?php echo $nama_kelas; ?></td>
                    <td align="center">
                      <a href="siswa_edit.php?data=<?php echo $id_siswa ?>" class="btn btn-sm btn-warning"><i
                          class="fas fa-edit"></i> Edit</a>
                      <a href="javascript:if(confirm('Anda yakin ingin menghapus data <?php echo $nama_siswa; ?>?'))window.location.href='siswa.php?aksi=hapus&data=<?php echo $id_siswa; ?>&notif=hapusberhasil'"
                        class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

            <?php
            $sql_jum = "SELECT COUNT(*) AS total FROM siswa 
                    LEFT JOIN user ON siswa.id_user = user.id_user 
                    LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas";

            if (!empty($katakunci)) {
              $sql_jum .= " WHERE user.nama LIKE '%$katakunci%' OR kelas.nama_kelas LIKE '%$katakunci%'";
            }

            $query_jum = mysqli_query($koneksi, $sql_jum);
            $data_jum = mysqli_fetch_assoc($query_jum);
            $jum_data = $data_jum['total'];
            $jum_halaman = ceil($jum_data / $batas);
            ?>

            <div class="card-footer clearfix">
              <ul class="pagination justify-content-center mt-3">
                <?php
                $url = "siswa.php";
                if (!empty($katakunci)) {
                  $url .= "?katakunci=$katakunci&";
                } else {
                  $url .= "?";
                }

                if ($halaman > 1) {
                  echo "<li class='page-item'><a class='page-link' href='{$url}halaman=1'>First</a></li>";
                  echo "<li class='page-item'><a class='page-link' href='{$url}halaman=" . ($halaman - 1) . "'>«</a></li>";
                }

                for ($i = 1; $i <= $jum_halaman; $i++) {
                  if ($i == $halaman) {
                    echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
                  } else {
                    echo "<li class='page-item'><a class='page-link' href='{$url}halaman=$i'>$i</a></li>";
                  }
                }

                if ($halaman < $jum_halaman) {
                  echo "<li class='page-item'><a class='page-link' href='{$url}halaman=" . ($halaman + 1) . "'>»</a></li>";
                  echo "<li class='page-item'><a class='page-link' href='{$url}halaman=$jum_halaman'>Last</a></li>";
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include("includes/footer.php") ?>
  </div>
  <?php include("includes/script.php") ?>
</body>

</html>