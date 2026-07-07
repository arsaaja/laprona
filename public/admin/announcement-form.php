<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

$id = (int) ($_GET['id'] ?? 0);
$item = null;
if ($id) {
    $stmt = $db->prepare('SELECT * FROM announcements WHERE id = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch();
}

$classes = $db->query('SELECT * FROM classes ORDER BY nama_kelas')->fetchAll();
$subjects = $db->query('SELECT * FROM subjects ORDER BY nama_mapel')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $isi = trim($_POST['isi']);
    $classId = $_POST['class_id'];
    $subjectId = $_POST['subject_id'] ?: null;
    $tag = trim($_POST['tag']);

    if ($id) {
        $stmt = $db->prepare('UPDATE announcements SET judul=?, isi=?, class_id=?, subject_id=?, tag=? WHERE id=?');
        $stmt->execute([$judul, $isi, $classId, $subjectId, $tag, $id]);
    } else {
        $stmt = $db->prepare('INSERT INTO announcements (judul, isi, class_id, subject_id, tag, guru_id) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$judul, $isi, $classId, $subjectId, $tag, $_SESSION['user_id']]);
    }

    flash('success', 'Pengumuman berhasil disimpan.');
    header('Location: announcements.php');
    exit;
}

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header"><h1><?= $item ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?></h1></div>

<div class="form-box">
    <form method="post">
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" value="<?= e($item['judul'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Isi Pengumuman</label>
            <textarea name="isi" rows="4" required><?= e($item['isi'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <select name="class_id" required>
                <?php foreach ($classes as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($item['class_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= e($c['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Mata Pelajaran (opsional)</label>
            <select name="subject_id">
                <option value="">-- Umum --</option>
                <?php foreach ($subjects as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= ($item['subject_id'] ?? '') == $s['id'] ? 'selected' : '' ?>><?= e($s['nama_mapel']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tag (pisahkan dengan koma, contoh: URGENT,PRAKTIKUM)</label>
            <input type="text" name="tag" value="<?= e($item['tag'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-yellow">Simpan</button>
        <a href="announcements.php" class="btn">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
