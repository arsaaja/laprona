<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();
$user = currentUser();
$db = getDB();

$id = (int) ($_GET['id'] ?? 0);

$stmt = $db->prepare('SELECT t.*, sub.nama_mapel FROM tasks t JOIN subjects sub ON sub.id = t.subject_id WHERE t.id = ?');
$stmt->execute([$id]);
$task = $stmt->fetch();

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $task) {
    $catatan = trim($_POST['catatan'] ?? '');
    $filePath = null;

    if (!empty($_FILES['file_jawaban']['name'])) {
        $ext = pathinfo($_FILES['file_jawaban']['name'], PATHINFO_EXTENSION);
        $filename = 'task' . $id . '_user' . $user['id'] . '_' . time() . '.' . $ext;
        $target = __DIR__ . '/../uploads/submissions/' . $filename;
        if (move_uploaded_file($_FILES['file_jawaban']['tmp_name'], $target)) {
            $filePath = 'uploads/submissions/' . $filename;
        }
    }

    // Cek apakah sudah pernah submit sebelumnya
    $stmt = $db->prepare('SELECT id FROM submissions WHERE task_id = ? AND user_id = ?');
    $stmt->execute([$id, $user['id']]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $db->prepare('UPDATE submissions SET file_path = ?, catatan = ?, status = "selesai", submitted_at = NOW() WHERE id = ?');
        $stmt->execute([$filePath, $catatan, $existing['id']]);
    } else {
        $stmt = $db->prepare('INSERT INTO submissions (task_id, user_id, file_path, catatan, status, submitted_at) VALUES (?,?,?,?,"selesai",NOW())');
        $stmt->execute([$id, $user['id'], $filePath, $catatan]);
    }

    $success = true;
}

include __DIR__ . '/../app/views/layouts/header.php';
?>

<div class="box box-white" style="max-width:500px;">
    <h2>Kumpulkan Tugas</h2>

    <?php if (!$task): ?>
        <p>Tugas tidak ditemukan.</p>
    <?php elseif ($success): ?>
        <p style="color:#1a7a4c; font-weight:700;">Tugas berhasil dikumpulkan!</p>
        <a href="tasks.php" class="btn btn-yellow">Kembali ke Daftar Tugas</a>
    <?php else: ?>
        <p><strong><?= e($task['nama_mapel']) ?>:</strong> <?= e($task['judul']) ?></p>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Upload File Jawaban</label>
                <input type="file" name="file_jawaban">
            </div>
            <div class="form-group">
                <label>Catatan (opsional)</label>
                <textarea name="catatan" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-yellow">Submit Jawaban</button>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
