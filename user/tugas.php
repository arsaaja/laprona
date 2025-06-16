<?php
include('../koneksi/koneksi.php');
session_start();

$id_kelas = $_SESSION['id_kelas'];
$id_siswa_login = $_SESSION['id_siswa'];

// Mengambil id_subjek dari parameter URL jika ada
$id_subjek_url = isset($_GET['id_subjek']) ? intval($_GET['id_subjek']) : 0;

$query_kelas = mysqli_query($koneksi, "SELECT GROUP_CONCAT(sk.subjek_kelas SEPARATOR ', ') AS subjek_kelas
    FROM master_kelas_subjek mks
    JOIN subjek_kelas sk ON mks.id_subjek = sk.id_subjek_kelas
    WHERE mks.id_kelas = $id_kelas");

$kelas_data = mysqli_fetch_assoc($query_kelas);
$nama_kelas = $kelas_data['subjek_kelas'] ?? '-';

$query_jumlah = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa WHERE id_kelas = $id_kelas");
$jumlah_data = mysqli_fetch_assoc($query_jumlah);
$jumlah_siswa = $jumlah_data['total'] ?? 0;

$query_subjek_ids = mysqli_query($koneksi, "SELECT id_subjek FROM master_kelas_subjek WHERE id_kelas = $id_kelas");
$subjek_ids = [];

while ($row = mysqli_fetch_assoc($query_subjek_ids)) {
    $subjek_ids[] = $row['id_subjek'];
}

$subjek_id_list = implode(",", $subjek_ids);

// Modifikasi query ranking untuk memperhitungkan id_subjek jika ada
$where_subjek_ranking = "";
if ($id_subjek_url > 0) {
    $where_subjek_ranking = " AND p.id_subjek = $id_subjek_url";
}

$query = "SELECT s.id_siswa, u.nama AS nama_siswa, SUM(p.nilai) AS total_nilai
          FROM siswa s
          JOIN user u ON s.id_user = u.id_user
          LEFT JOIN penilaian p ON s.id_siswa = p.id_siswa AND p.id_subjek IN ($subjek_id_list) $where_subjek_ranking
          WHERE s.id_kelas = $id_kelas
          GROUP BY s.id_siswa
          ORDER BY total_nilai DESC";

$result = mysqli_query($koneksi, $query);

$ranking = 1;
$ranking_login = 0;
$nilai_login = 0;
$nama_login = '';

$rows = [];

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['id_siswa'] == $id_siswa_login) {
        $ranking_login = $ranking;
        $nilai_login = $row['total_nilai'];
        $nama_login = $row['nama_siswa'];
    }
    $row['ranking'] = $ranking;
    $rows[] = $row;
    $ranking++;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tugas - La Prona</title>
    <?php include("includes/head.php") ?>
</head>

<body>
    <header>
        <?php include("includes/header.php") ?>
    </header>

    <div class="content">
        <div class="performa">
            <div class="section-title">Performa Siswa</div>
            <div style="font-size: 2.5rem; margin: 1rem 0;">🏆</div>
            <p style="font-size: 1.2rem; font-weight: bold;">
                Ranking <?php echo $ranking_login; ?> dari <?php echo $jumlah_siswa; ?> siswa di
                <?php echo $nama_kelas; ?>
            </p>
            <p style="font-size: 1rem;">Luar biasa! Pertahankan prestasimu!</p>
        </div>
        <?php
        $katakunci = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, $_GET['q']) : '';

        // Query pencarian tugas, sekarang juga mempertimbangkan id_subjek dari URL
        $sql = "SELECT t.id_tugas, t.judul_tugas, t.deadline_tugas, sk.subjek_kelas
            FROM tugas t
            JOIN kelas k ON t.id_kelas = k.id_kelas
            JOIN subjek_kelas sk ON t.id_subjek = sk.id_subjek_kelas
            WHERE t.id_kelas = $id_kelas";

        if ($id_subjek_url > 0) {
            $sql .= " AND t.id_subjek = $id_subjek_url";
        }

        if ($katakunci != '') {
            $sql .= " AND (
                t.judul_tugas LIKE '%$katakunci%' OR
                sk.subjek_kelas LIKE '%$katakunci%'
            )";
        }
        $sql .= " ORDER BY t.deadline_tugas ASC";

        ?>
        <form method="GET" action="">
            <div class="search-bar">
                <input type="hidden" name="id_subjek" value="<?= $id_subjek_url ?>">
                <input type="text" name="q" placeholder="Cari Tugas"
                    value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                <input type="submit" value="Cari">
            </div>
        </form>

        <h2>Tugas Minggu Ini
            <?php
            // Menampilkan nama subjek jika id_subjek_url ada
            if ($id_subjek_url > 0) {
                $query_nama_subjek = mysqli_query($koneksi, "SELECT subjek_kelas FROM subjek_kelas WHERE id_subjek_kelas = $id_subjek_url");
                $data_nama_subjek = mysqli_fetch_assoc($query_nama_subjek);
                echo ' - ' . ($data_nama_subjek['subjek_kelas'] ?? 'Subjek Tidak Ditemukan');
            }
            ?>
        </h2>
        <div class="materi">
            <?php
            $result_tugas = mysqli_query($koneksi, $sql);

            // Tampilkan data tugas
            if (mysqli_num_rows($result_tugas) > 0) {
                while ($row = mysqli_fetch_assoc($result_tugas)) {
                    echo '<div class="card">';
                    echo '   <div class="icon"><i class="fas fa-tasks"></i></div>';
                    echo '   <h3>' . $row['judul_tugas'] . '</h3>';
                    echo '   <p>' . $row['subjek_kelas'] . '</p>';
                    echo '   <p>Deadline: ' . $row['deadline_tugas'] . '</p>';
                    echo '   <a href="pengumpulan_tugas.php?id=' . $row['id_tugas'] . '" class="button-link">Detail</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>Tidak ada tugas untuk subjek ini atau kriteria pencarian.</p>";
            }
            ?>
        </div>
    </div>
    <script src="script.js"></script>

</body>

</html>