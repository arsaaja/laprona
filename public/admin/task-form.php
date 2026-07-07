<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

$id = (int) ($_GET['id'] ?? 0);
$task = null;
if ($id) {
    $stmt = $db->prepare('SELECT * FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    $task = $stmt->fetch();
}

$subjects = $db->query('SELECT * FROM subjects ORDER BY nama_mapel')->fetchAll();
$classes = $db->query('SELECT * FROM classes ORDER BY nama_kelas')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);
    $subjectId = $_POST['subject_id'];
    $classId = $_POST['class_id'];
    $deadline = $_POST['deadline'];

    if ($id) {
        $stmt = $db->prepare('UPDATE tasks SET judul=?, deskripsi=?, subject_id=?, class_id=?, deadline=? WHERE id=?');
        $stmt->execute([$judul, $deskripsi, $subjectId, $classId, $deadline, $id]);
    } else {
        $stmt = $db->prepare('INSERT INTO tasks (judul, deskripsi, subject_id, class_id, deadline, guru_id) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$judul, $deskripsi, $subjectId, $classId, $deadline, $_SESSION['user_id']]);
    }

    flash('success', 'Tugas berhasil disimpan.');
    header('Location: tasks.php');
    exit;
}

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header"><h1><?= $task ? 'Edit Tugas' : 'Tambah Tugas' ?></h1></div>

<div class="form-box">
    <form method="post">
        <div class="form-group">
            <label>Judul Tugas</label>
            <input type="text" name="judul" value="<?= e($task['judul'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" required><?= e($task['deskripsi'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Mata Pelajaran</label>
            <select name="subject_id" required>
                <?php foreach ($subjects as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= ($task['subject_id'] ?? '') == $s['id'] ? 'selected' : '' ?>><?= e($s['nama_mapel']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <select name="class_id" required>
                <?php foreach ($classes as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($task['class_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= e($c['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Deadline</label>
            <input type="datetime-local" name="deadline"
                value="<?= $task ? date('Y-m-d\TH:i', strtotime($task['deadline'])) : '' ?>" required>
        </div>
        <button type="submit" class="btn btn-yellow">Simpan</button>
        <a href="tasks.php" class="btn">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
