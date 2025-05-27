<?php
include('../koneksi/koneksi.php');
if ((isset($_GET['aksi'])) && (isset($_GET['data']))) {
  if ($_GET['aksi'] == 'hapus') {
    $id_master_topik = $_GET['data'];
    //hapus universitas
    $sql_dh = "delete from `master_topik`
            where `id_master_topik` = '$id_master_topik'";
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
              <h3><i class="fas fa-topik"></i> Topik</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Topik</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Daftar Topik</h3>
            <div class="card-tools">
              <a href="tambahtopik.php" class="btn btn-sm btn-info float-right"><i class="fas fa-plus"></i> Tambah
                Topik</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12">
              <form method="get" action="topik.php">
                <div class="row">
                  <div class="col-md-4 bottom-10">
                    <input type="text" class="form-control" id="kata_kunci" name="katakunci">
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
                  <th width="80%">Topik</th>
                  <th width="15%">
                    <center>Aksi</center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php
                  $batas = 2;
                  if (!isset($_GET['halaman'])) {
                    $posisi = 0;
                    $halaman = 1;
                  } else {
                    $halaman = $_GET['halaman'];
                    $posisi = ($halaman - 1) * $batas;
                  }
                  $sql_u = "SELECT `id_master_topik`,`topik` FROM `master_topik` ";
                  if (isset($_GET["katakunci"])) {
                    $katakunci_topik = $_GET["katakunci"];
                    $sql_u .= " where `topik` LIKE '%$katakunci_topik%'";
                  }
                  $sql_u .= "ORDER BY `topik` limit $posisi, $batas ";
                  $query_u = mysqli_query($koneksi, $sql_u);
                  $no = 1;
                  while ($data_u = mysqli_fetch_row($query_u)) {
                    $id_master_topik = $data_u[0];
                    $topik = $data_u[1];

                    ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $topik; ?></td>
                    <td align="center">
                      <a href="edittopik.php?data=<?php echo
                        $id_master_topik; ?>" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> Edit</a>
                      <a href="javascript:if(confirm('Anda yakin ingin menghapus data
                    <?php echo $topik; ?>?'))window.location.href =
                    'topik.php?aksi=hapus&data=<?php echo
                      $id_master_topik; ?>&notif=hapusberhasil'" class="btn btn-xs btn-warning"><i
                          class="fas fa-trash"></i>
                        Hapus</a>
                    </td>
                  </tr>
                  <?php $no++;
                  } ?>
                </tr>
              </tbody>
            </table>
          </div>

          <?php
          //hitung jumlah semua data
          $sql_jum = "SELECT `id_master_topik`,`topik` FROM `master_topik` ORDER BY `topik`";
          $query_jum = mysqli_query($koneksi, $sql_jum);
          $jum_data = mysqli_num_rows($query_jum);
          $jum_halaman = ceil($jum_data / $batas);
          ?>


          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <?php
              if ($jum_halaman == 0) {
                //tidak ada halaman
              } else if ($jum_halaman == 1) {
                echo "<li class='page-item'><a class='page-link'>1</a></li>";
              } else {
                $sebelum = $halaman - 1;
                $setelah = $halaman + 1;
                if (isset($_GET["katakunci"])) {
                  $katakunci_jenjang = $_GET["katakunci"];
                  if ($halaman != 1) {
                    echo "<li class='page-item'><a class='page-link'href='topik.php?katakunci=$katakunci_topik&halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='topik.php?katakunci=$katakunci_topik&halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link'href='topik.php?katakunci=$katakunci_topik&halaman=$i'>$i</a></li>";
                      } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                      }
                    }
                  }
                } else {
                  if ($halaman != 1) {
                    echo "<li class='page-item'><a class='page-link'href='topik.php?halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='topik.php?halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link'href='topik.php?halaman=$i'>$i</a></li>";
                      } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                      }
                    }
                  }
                  if ($halaman != $jum_halaman) {
                    echo "<li class='page-item'><a class='page-link' href='topik.php?halaman=$setelah'> »</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='kategoribuku.php?halaman=$jum_halaman'>Last</a></li>";
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