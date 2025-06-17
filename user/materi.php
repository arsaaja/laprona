<?php
include('../koneksi/koneksi.php');
session_start();

$id_kelas = $_SESSION['id_kelas'] ?? 0;

$id_subjek_url = isset($_GET['id_subjek']) ? intval($_GET['id_subjek']) : 0;

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Materi - La Prona</title>
    <?php include("includes/head.php") ?>
</head>

<body>

    <header>
        <?php include("includes/header.php") ?>
    </header>

    <h2>Daftar Materi
        <?php
        if ($id_subjek_url > 0) {
            $query_nama_subjek = mysqli_query($koneksi, "SELECT subjek_kelas FROM subjek_kelas WHERE id_subjek_kelas = $id_subjek_url");
            $data_nama_subjek = mysqli_fetch_assoc($query_nama_subjek);
            echo ' - ' . ($data_nama_subjek['subjek_kelas'] ?? 'Subjek Tidak Ditemukan');
        }
        ?>
    </h2>

    <form method="GET" action="">
        <div class="search-bar">
            <input type="hidden" name="id_subjek" value="<?= $id_subjek_url ?>">
            <input type="text" name="q" placeholder="Cari Materi"
                value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
        </div>
    </form>

    <div class="materi-list">
        <?php
        $katakunci = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, $_GET['q']) : '';

        $query_materi = "SELECT
            materi.id_materi,
            materi.nama_materi,
            materi.isi_materi,
            subjek_kelas.subjek_kelas
        FROM
            materi
        JOIN
            kelas ON materi.id_kelas = kelas.id_kelas
        JOIN
            subjek_kelas ON materi.id_subjek = subjek_kelas.id_subjek_kelas
        WHERE
            materi.id_kelas = $id_kelas";

        if ($id_subjek_url > 0) {
            $query_materi .= " AND materi.id_subjek = $id_subjek_url";
        }

        if ($katakunci != '') {
            $query_materi .= " AND (
                materi.nama_materi LIKE '%$katakunci%' OR
                materi.isi_materi LIKE '%$katakunci%' OR
                subjek_kelas.subjek_kelas LIKE '%$katakunci%'
            )";
        }

        $query_materi .= " ORDER BY materi.id_materi DESC";
        $query_materi .= " LIMIT 10";

        $result_materi = mysqli_query($koneksi, $query_materi);

        if (mysqli_num_rows($result_materi) > 0) {
            while ($row = mysqli_fetch_assoc($result_materi)) {
                echo '<div class="materi-card">';
                echo '    <div class="materi-icon"><i class="fas fa-file-alt"></i></div>';
                echo '    <div class="materi-info">';
                echo '        <h4><strong>' . htmlspecialchars($row['nama_materi']) . '</strong></h4>';
                echo '        <p><em>' . htmlspecialchars($row['subjek_kelas']) . '</em></p>';
                echo '    </div>';
                echo '    <a href="' . htmlspecialchars($row['isi_materi']) . '" target="_blank" class="unduh-btn">Unduh</a>';
                echo '</div>';
            }
        } else {
            echo "<p>Tidak ada materi untuk subjek ini atau kriteria pencarian.</p>";
        }
        ?>
    </div>

</body>

</html>