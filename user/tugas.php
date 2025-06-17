<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_kelas']) || !isset($_SESSION['id_siswa'])) {
    header('Location: /laprona/index.php');
    exit();
}

$id_kelas = intval($_SESSION['id_kelas']);
$id_siswa_login = intval($_SESSION['id_siswa']);

$id_subjek_url = isset($_GET['id_subjek']) ? intval($_GET['id_subjek']) : 0;
$katakunci = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, $_GET['q']) : '';

$subject_title_name = '';
if ($id_subjek_url > 0) {
    $query_nama_subjek_stmt = mysqli_prepare($koneksi, "SELECT subjek_kelas FROM subjek_kelas WHERE id_subjek_kelas = ?");
    if ($query_nama_subjek_stmt) {
        mysqli_stmt_bind_param($query_nama_subjek_stmt, "i", $id_subjek_url);
        mysqli_stmt_execute($query_nama_subjek_stmt);
        $data_nama_subjek = mysqli_fetch_assoc(mysqli_stmt_get_result($query_nama_subjek_stmt));
        $subject_title_name = $data_nama_subjek['subjek_kelas'] ?? 'Subjek Tidak Ditemukan';
        mysqli_stmt_close($query_nama_subjek_stmt);
    } else {
        error_log("Error preparing subject name query: " . mysqli_error($koneksi));
    }
}

$nama_kelas_performa = '-';
if ($id_subjek_url > 0 && $subject_title_name != 'Subjek Tidak Ditemukan') {
    $nama_kelas_performa = $subject_title_name;
} else {
    $query_kelas_stmt = mysqli_prepare($koneksi, "SELECT GROUP_CONCAT(DISTINCT sk.subjek_kelas SEPARATOR ', ') AS subjek_kelas
                                                   FROM tugas t
                                                   JOIN subjek_kelas sk ON t.id_subjek = sk.id_subjek_kelas
                                                   WHERE t.id_kelas = ?");
    if ($query_kelas_stmt) {
        mysqli_stmt_bind_param($query_kelas_stmt, "i", $id_kelas);
        mysqli_stmt_execute($query_kelas_stmt);
        $kelas_data = mysqli_fetch_assoc(mysqli_stmt_get_result($query_kelas_stmt));
        $nama_kelas_performa = $kelas_data['subjek_kelas'] ?? '-';
        mysqli_stmt_close($query_kelas_stmt);
    } else {
        error_log("Error preparing class subjects query for performance section: " . mysqli_error($koneksi));
    }
}

$jumlah_siswa = 0;
$query_jumlah = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa WHERE id_kelas = $id_kelas");
if ($query_jumlah) {
    $jumlah_data = mysqli_fetch_assoc($query_jumlah);
    $jumlah_siswa = $jumlah_data['total'] ?? 0;
} else {
    error_log("Error fetching total students: " . mysqli_error($koneksi));
}

$subjek_ids = [];
$query_subjek_ids = mysqli_query($koneksi, "SELECT id_subjek FROM master_kelas_subjek WHERE id_kelas = $id_kelas");
if ($query_subjek_ids) {
    while ($row = mysqli_fetch_assoc($query_subjek_ids)) {
        $subjek_ids[] = $row['id_subjek'];
    }
} else {
    error_log("Error fetching subject IDs: " . mysqli_error($koneksi));
}

$subjek_id_list = !empty($subjek_ids) ? implode(",", $subjek_ids) : 'NULL';

$where_subjek_ranking = "";
if ($id_subjek_url > 0) {
    $where_subjek_ranking = " AND p.id_subjek = $id_subjek_url";
}

$query_ranking_sql = "SELECT s.id_siswa, u.nama AS nama_siswa, SUM(p.nilai) AS total_nilai
                      FROM siswa s
                      JOIN user u ON s.id_user = u.id_user
                      LEFT JOIN penilaian p ON s.id_siswa = p.id_siswa AND p.id_subjek IN ($subjek_id_list) $where_subjek_ranking
                      WHERE s.id_kelas = $id_kelas
                      GROUP BY s.id_siswa
                      ORDER BY total_nilai DESC";

$result_ranking = mysqli_query($koneksi, $query_ranking_sql);

$ranking = 1;
$ranking_login = 0;
$nilai_login = 0;
$nama_login = '';
$rows = [];

if ($result_ranking) {
    while ($row = mysqli_fetch_assoc($result_ranking)) {
        if ($row['id_siswa'] == $id_siswa_login) {
            $ranking_login = $ranking;
            $nilai_login = $row['total_nilai'] ?? 0;
            $nama_login = $row['nama_siswa'];
        }
        $row['ranking'] = $ranking;
        $rows[] = $row;
        $ranking++;
    }
} else {
    error_log("Error executing ranking query: " . mysqli_error($koneksi));
}

$subject_title_name = '';
if ($id_subjek_url > 0) {
    $query_nama_subjek = mysqli_query($koneksi, "SELECT subjek_kelas FROM subjek_kelas WHERE id_subjek_kelas = $id_subjek_url");
    if ($query_nama_subjek) {
        $data_nama_subjek = mysqli_fetch_assoc($query_nama_subjek);
        $subject_title_name = $data_nama_subjek['subjek_kelas'] ?? 'Subjek Tidak Ditemukan';
    } else {
        error_log("Error fetching subject name: " . mysqli_error($koneksi));
    }
}

$sql_assignments = "SELECT t.id_tugas, t.judul_tugas, t.deadline_tugas, t.tugas, sk.subjek_kelas
                    FROM tugas t
                    JOIN kelas k ON t.id_kelas = k.id_kelas
                    JOIN subjek_kelas sk ON t.id_subjek = sk.id_subjek_kelas
                    WHERE t.id_kelas = $id_kelas";

if ($id_subjek_url > 0) {
    $sql_assignments .= " AND t.id_subjek = $id_subjek_url";
}

if ($katakunci != '') {
    $sql_assignments .= " AND (t.judul_tugas LIKE '%$katakunci%' OR sk.subjek_kelas LIKE '%$katakunci%')";
}
$sql_assignments .= " ORDER BY t.deadline_tugas ASC";

$result_tugas = mysqli_query($koneksi, $sql_assignments);

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
                Ranking <?php echo htmlspecialchars($ranking_login); ?> dari
                <?php echo htmlspecialchars($jumlah_siswa); ?> siswa di
                <?php echo htmlspecialchars($nama_kelas_performa); ?>
            </p>
            <p style="font-size: 1rem;">Luar biasa! Pertahankan prestasimu!</p>
        </div>

        <form method="GET" action="">
            <div class="search-bar">
                <input type="hidden" name="id_subjek" value="<?= htmlspecialchars($id_subjek_url) ?>">
                <input type="text" name="q" placeholder="Cari Tugas"
                    value="<?php echo htmlspecialchars($katakunci); ?>">
            </div>
        </form>

        <h2>Tugas Minggu Ini
            <?php
            if ($subject_title_name != '') {
                echo ' - ' . htmlspecialchars($subject_title_name);
            }
            ?>
        </h2>
        <div class="materi">
            <?php
            if ($result_tugas && mysqli_num_rows($result_tugas) > 0) {
                while ($row = mysqli_fetch_assoc($result_tugas)) {
                    echo '<div class="card">';
                    echo '    <div class="icon"><i class="fas fa-tasks"></i></div>';
                    echo '    <h3>' . htmlspecialchars($row['judul_tugas']) . '</h3>';
                    echo '    <p>' . htmlspecialchars($row['subjek_kelas']) . '</p>';
                    echo '    <p>Deadline: ' . htmlspecialchars($row['deadline_tugas']) . '</p>';
                    if (!empty($row['tugas'])) {
                        echo '    <a href="' . htmlspecialchars($row['tugas']) . '" target="_blank" class="button-link">Detail</a>';
                    } else {
                        echo '    <span class="button-link disabled">Detail (Tidak Tersedia)</span>';
                    }
                    echo '    <a href="pengumpulan_tugas.php?id=' . htmlspecialchars($row['id_tugas']) . '" class="button-link">Kumpulkan</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>Tidak ada tugas untuk subjek ini atau kriteria pencarian. Coba ubah filter subjek atau kata kunci pencarian Anda.</p>";
            }
            ?>
        </div>
    </div>
    <script src="script.js"></script>

</body>

</html>