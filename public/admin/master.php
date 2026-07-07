<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

// Tambah kelas
if (isset($_POST['add_class'])) {
    $db->prepare('INSERT INTO classes (nama_kelas, deskripsi) VALUES (?,?)')
       ->execute([trim($_POST['nama_kelas']), trim($_POST['deskripsi'])]);
    flash('success', 'Kelas berhasil ditambahkan.');
    header('Location: master.php'); exit;
}

// Tambah mapel
if (isset($_POST['add_subject'])) {
    $db->prepare('INSERT INTO subjects (nama_mapel, warna) VALUES (?,?)')
       ->execute([trim($_POST['nama_mapel']), $_POST['warna']]);
    flash('success', 'Mata pelajaran berhasil ditambahkan.');
    header('Location: master.php'); exit;
}

// Hapus
if (isset($_GET['delete_class'])) {
    $db->prepare('DELETE FROM classes WHERE id = ?')->execute([(int) $_GET['delete_class']]);
    header('Location: master.php'); exit;
}
if (isset($_GET['delete_subject'])) {
    $db->prepare('DELETE FROM subjects WHERE id = ?')->execute([(int) $_GET['delete_subject']]);
    header('Location: master.php'); exit;
}

$classes = $db->query('SELECT * FROM classes ORDER BY nama_kelas')->fetchAll();
$subjects = $db->query('SELECT * FROM subjects ORDER BY nama_mapel')->fetchAll();

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header"><h1>Kelas & Mata Pelajaran</h1></div>

<div class="grid-2">
    <div>
        <h3>Daftar Kelas</h3>
        <table class="data-table" style="margin-bottom:20px;">
            <tr><th>Nama Kelas</th><th>Deskripsi</th><th>Aksi</th></tr>
            <?php foreach ($classes as $c): ?>
                <tr>
                    <td><?= e($c['nama_kelas']) ?></td>
                    <td><?= e($c['deskripsi']) ?></td>
                    <td><a href="master.php?delete_class=<?= $c['id'] ?>" class="btn btn-sm btn-red" onclick="return confirm('Hapus kelas ini?')">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="form-box">
            <h4>Tambah Kelas</h4>
            <form method="post">
                <div class="form-group">
                    <label>Nama Kelas</label>
                    <input type="text" name="nama_kelas" placeholder="12-IPA-2" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="deskripsi" placeholder="Ruang Kelas 12-IPA-2">
                </div>
                <button type="submit" name="add_class" class="btn btn-yellow">Tambah</button>
            </form>
        </div>
    </div>

    <div>
        <h3>Daftar Mata Pelajaran</h3>
        <table class="data-table" style="margin-bottom:20px;">
            <tr><th>Nama Mapel</th><th>Warna</th><th>Aksi</th></tr>
            <?php foreach ($subjects as $s): ?>
                <tr>
                    <td><?= e($s['nama_mapel']) ?></td>
                    <td><span class="task-card-header" style="background:<?= badgeColor($s['warna']) ?>; display:inline-block; padding:4px 10px; border-radius:6px;"><?= e($s['warna']) ?></span></td>
                    <td><a href="master.php?delete_subject=<?= $s['id'] ?>" class="btn btn-sm btn-red" onclick="return confirm('Hapus mapel ini?')">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="form-box">
            <h4>Tambah Mata Pelajaran</h4>
            <form method="post">
                <div class="form-group">
                    <label>Nama Mapel</label>
                    <input type="text" name="nama_mapel" placeholder="Biologi" required>
                </div>
                <div class="form-group">
                    <label>Warna Label</label>
                    <select name="warna">
                        <option value="teal">Teal</option>
                        <option value="cyan">Cyan</option>
                        <option value="yellow">Yellow</option>
                        <option value="gray">Gray</option>
                    </select>
                </div>
                <button type="submit" name="add_subject" class="btn btn-yellow">Tambah</button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
