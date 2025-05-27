<?php
include('../koneksi/koneksi.php');
if ((isset($_GET['aksi'])) && (isset($_GET['data']))) {
  if ($_GET['aksi'] == 'hapus') {
    $id_kontak = $_GET['data'];
    //hapus 
    $sql_dh = "delete from `pesan_masuk`
            where `id_pesan` = '$id_pesan'";
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
              <h3><i class="fa fa-envelope-o"></i> Pesan</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Pesan</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Daftar Pesan</h3>
            <div class="card-tools">
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12">
              <form method="get" action="pesan.php">
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
              <?php
              if (isset($_GET['notif']) && $_GET['notif'] == "hapusberhasil") {
                ?>
                <div class="alert alert-success" role="alert">
                  Data Berhasil Dihapus
                </div>
                <?php
              }
              ?>
            </div>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="20%">Nama</th>
                  <th width="20%">Email</th>
                  <th width="40%">Pesan</th>
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
                $sql_k = "SELECT id_pesan, username, email,isi_masukkan
                    FROM pesan_masuk ";
                if (isset($_GET["katakunci"])) {
                  $katakunci_kontak = $_GET["katakunci"];
                  $sql_k .= " where `username` LIKE '%$katakunci_pesan%'  
                  or `email` LIKE '%$katakunci_pesan%'  or `pesan` LIKE '%$katakunci_pesan%'";
                }

                $sql_k .= " ORDER BY `id_pesan` limit $posisi, $batas ";
                $query_k = mysqli_query($koneksi, $sql_k);
                $no = 1;
                while ($data_u = mysqli_fetch_row($query_k)) {
                  $id_pesan = $data_u[0];
                  $nama = $data_u[1];
                  $email = $data_u[2];
                  $isi_masukkan = $data_u[3];
                  ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $nama; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $pesan; ?></td>
                    <td align="center">
                      <a href="javascript:if(confirm('Anda yakin ingin menghapus data
                    <?php echo $pesan; ?>?'))window.location.href =
                    'pesan.php?aksi=hapus&data=<?php echo
                      $id_pesan; ?>&notif=hapusberhasil'" class="btn btn-xs btn-warning"><i class="fas fa-trash"></i>
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
          
          $sql_jum = "SELECT id_pesan, username, email, pesan
                    FROM pesan ORDER BY `id_pesan`";
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
                  $katakunci_kontak = $_GET["katakunci"];
                  if ($halaman != 1) {
                    echo "<li class='page-item'><a class='page-link'href='pesan.php?katakunci=$katakunci_pesan&halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='pesan.php?katakunci=$katakunci_pesan&halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link'href='pesan.php?katakunci=$katakunci_pesan&halaman=$i'>$i</a></li>";
                      } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                      }
                    }
                  }
                } else {
                  if ($halaman != 1) {
                    echo "<li class='page-item'><a class='page-link'href='pesan.php?halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='pesan.php?halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link'href='pesan.php?halaman=$i'>$i</a></li>";
                      } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                      }
                    }
                  }
                  if ($halaman != $jum_halaman) {
                    echo "<li class='page-item'><a class='page-link' href='pesan.php?halaman=$setelah'> »</a></li>";
                    echo "<li class='page-item'><a class='page-link'href='pesan.php?halaman=$jum_halaman'>Last</a></li>";
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