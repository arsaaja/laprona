<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

$id = (int) ($_GET['id'] ?? 0);
$item = null;
if ($id) {
    $stmt = $db->prepare('SELECT * FROM schedules WHERE id = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch();
}

$classes = $db->query('SELECT * FROM classes ORDER BY nama_kelas')->fetchAll();
$subjects = $db->query('SELECT * FROM subjects ORDER BY nama_mapel')->fetchAll();
$days = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classId = $_POST['class_id'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $subjectId = $_POST['subject_id'] ?: null;
    $keterangan = trim($_POST['keterangan']);

    if ($id) {
        $stmt = $db->prepare('UPDATE schedules SET class_id=?, hari=?, jam=?, subject_id=?, keterangan=? WHERE id=?');
        $stmt->execute([$classId, $hari, $jam, $subjectId, $keterangan ?: null, $id]);
    } else {
        $stmt = $db->prepare('INSERT INTO schedules (class_id, hari, jam, subject_id, keterangan) VALUES (?,?,?,?,?)');
        $stmt->execute([$classId, $hari, $jam, $subjectId, $keterangan ?: null]);
    }

    flash('success', 'Jadwal berhasil disimpan.');
    header('Location: schedule.php');
    exit;
}

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header"><h1><?= $item ? 'Edit Jadwal' : 'Tambah Jadwal' ?></h1></div>

<div class="form-box">
    <form method="post">
        <div class="form-group">
            <label>Kelas</label>
            <select name="class_id" required>
                <?php foreach ($classes as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($item['class_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= e($c['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Hari</label>
            <select name="hari" required>
                <?php foreach ($days as $d): ?>
                    <option value="<?= $d ?>" <?= ($item['hari'] ?? '') === $d ? 'selected' : '' ?>><?= $d ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Jam (contoh: 07:30)</label>
            <input type="text" name="jam" value="<?= e($item['jam'] ?? '') ?>" placeholder="07:30" required>
        </div>
        <div class="form-group">
            <label>Mata Pelajaran (kosongkan jika mengisi Keterangan)</label>
            <select name="subject_id">
                <option value="">-- Tidak ada --</option>
                <?php foreach ($subjects as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= ($item['subject_id'] ?? '') == $s['id'] ? 'selected' : '' ?>><?= e($s['nama_mapel']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Keterangan (contoh: ISTIRAHAT, UPACARA)</label>
            <input type="text" name="keterangan" value="<?= e($item['keterangan'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-yellow">Simpan</button>
        <a href="schedule.php" class="btn">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
