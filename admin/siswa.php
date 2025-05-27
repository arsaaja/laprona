<?php
include('../koneksi/koneksi.php');
if ((isset($_GET['aksi'])) && (isset($_GET['data']))) {
  if ($_GET['aksi'] == 'hapus') {
    $id_siswa = $_GET['data'];
    $sql_dh = "delete from `siswa`
            where `id_siswa` = '$id_siswa'";
    mysqli_query($koneksi, $sql_dh);
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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3><i class="fas fa-jenjang"></i> Siswa</h3>

            </div>

          </div>
          <a href="mentor_tambah.php" class="btn btn-primary mb-3">+ Tambah Siswa</a>

        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <!-- /.card-header -->
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
                </div><!-- .row -->
              </form>
            </div><br>

            <div class="col-sm-12">
              <?php if (!empty($_GET['notif'])) { ?>
                <?php if ($_GET['notif'] == "tambahberhasil") { ?>
                  <div class="alert alert-success" role="alert">
                    Data Berhasil Ditambahkan</div>
                <?php } else if ($_GET['notif'] == "editberhasil") { ?>
                    <div class="alert alert-success" role="alert">
                      Data Berhasil Diubah</div>
                <?php } else if ($_GET['notif'] == "hapusberhasil") { ?>
                      <div class="alert alert-success" role="alert">
                        Data Berhasil Dihapus</div>
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
                $batas = 2;
                if (!isset($_GET['halaman'])) {
                  $posisi = 0;
                  $halaman = 1;
                } else {
                  $halaman = $_GET['halaman'];
                  $posisi = ($halaman - 1) * $batas;
                }
                $sql_u = "SELECT siswa.*, kelas.nama_kelas FROM siswa LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas ";
                if (isset($_GET["katakunci"])) {
                  $katakunci_siswa = $_GET["katakunci"];
                  $sql_u .= " where siswa.nama_siswa LIKE '%$katakunci_siswa%' OR kelas.nama_kelas LIKE '%$katakunci_siswa%'";
                }
                $sql_u .= "ORDER BY nama_siswa limit $posisi, $batas ";
                $query_u = mysqli_query($koneksi, $sql_u);
                $no = 1;
                while ($data_u = mysqli_fetch_row($query_u)) {
                  $id_siswa = $data_u[0];
                  $nama_siswa = $data_u[1];
                  $id_kelas = $data_u[2];
                  $nama_kelas = $data_u[3];

                  ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $nama_siswa; ?></td>
                    <td><?php echo $nama_kelas; ?></td>
                    <td align="center">
                      <a href="siswa_edit.php?data=<?php echo
                        $id_siswa ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                      <a href="javascript:if(confirm('Anda yakin ingin menghapus data
                    <?php echo $nama_siswa; ?>?'))window.location.href =
                    'siswa.php?aksi=hapus&data=<?php echo
                      $id_siswa; ?>&notif=hapusberhasil'" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                        Hapus</a>
                    </td>
                  </tr>
                  <?php $no++;
                } ?>
              </tbody>
            </table>
          </div>


          <?php
          //hitung jumlah semua data
          
          $sql_jum = "SELECT siswa.*, kelas.nama_kelas FROM siswa LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas ORDER BY nama_siswa";
          if (isset($_GET["katakunci"])) {
            $katakunci_siswa = $_GET["katakunci"];
            $sql_jum .= " WHERE siswa.nama_siswa LIKE '%$katakunci_siswa%' OR kelas.nama_kelas LIKE '%$katakunci_siswa%'";
          }

          $query_jum = mysqli_query($koneksi, $sql_jum);
          $jum_data = mysqli_num_rows($query_jum);
          $jum_halaman = ceil($jum_data / $batas);
          ?>


          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination justify-content-center mt-3">
              <?php
              if ($jum_halaman == 0) {
                //tidak ada halaman
              } else if ($jum_halaman == 1) {
                echo "<li class='page-item'><a class='page-link'>1</a></li>";
              } else {
                $sebelum = $halaman - 1;
                $setelah = $halaman + 1;
                if (isset($_GET["katakunci"])) {
                  $katakunci_siswa = $_GET["katakunci"];
                  if ($halaman != 1) {
                    echo "<li class='page-item'><a class='page-link'href='siswa.php?katakunci=$katakunci_siswa&halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='siswa.php?katakunci=$katakunci_siswa&halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link'href='siswa.php?katakunci=$katakunci_siswa&halaman=$i'>$i</a></li>";
                      } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                      }
                    }
                  }
                } else {
                  if ($halaman != 1) {
                    echo "<li class='page-item'><a class='page-link'href='siswa.php?halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='siswa.php?halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link'href='siswa.php?halaman=$i'>$i</a></li>";
                      } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                      }
                    }
                  }
                  if ($halaman != $jum_halaman) {
                    echo "<li class='page-item'><a class='page-link' href='siswa.php?halaman=$setelah'> »</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='siswa.php?halaman=$jum_halaman'>Last</a></li>";
                  }
                }
              } ?>
            </ul>
          </div>
        </div>
        <!-- /.card -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("includes/footer.php") ?>

  </div>
  <!-- ./wrapper -->

  <?php include("includes/script.php") ?>
</body>

</html>