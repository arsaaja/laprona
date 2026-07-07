<?php
require_once __DIR__ . '/../../config/config.php';
requireAdmin();
$db = getDB();

$id = (int) ($_GET['id'] ?? 0);
$user = null;
if ($id) {
    $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
}

$classes = $db->query('SELECT * FROM classes ORDER BY nama_kelas')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];
    $classId = $_POST['class_id'] ?: null;

    if ($id) {
        if ($password) {
            $stmt = $db->prepare('UPDATE users SET nama=?, email=?, role=?, password=? WHERE id=?');
            $stmt->execute([$nama, $email, $role, $password, $id]);
        } else {
            $stmt = $db->prepare('UPDATE users SET nama=?, email=?, role=? WHERE id=?');
            $stmt->execute([$nama, $email, $role, $id]);
        }
        $userId = $id;
    } else {
        $stmt = $db->prepare('INSERT INTO users (nama, email, password, role) VALUES (?,?,?,?)');
        $stmt->execute([$nama, $email, $password ?: 'user123', $role]);
        $userId = $db->lastInsertId();
    }

    // Update keanggotaan kelas (hanya untuk role user)
    $db->prepare('DELETE FROM class_members WHERE user_id = ?')->execute([$userId]);
    if ($role === 'user' && $classId) {
        $stmt = $db->prepare('SELECT COALESCE(MAX(no_absen),0)+1 as next FROM class_members WHERE class_id = ?');
        $stmt->execute([$classId]);
        $nextAbsen = $stmt->fetch()['next'];
        $db->prepare('INSERT INTO class_members (class_id, user_id, no_absen, jabatan) VALUES (?,?,?,"Siswa")')
           ->execute([$classId, $userId, $nextAbsen]);
    }

    flash('success', 'User berhasil disimpan.');
    header('Location: users.php');
    exit;
}

// Ambil kelas user saat ini (untuk edit)
$currentClassId = null;
if ($user) {
    $stmt = $db->prepare('SELECT class_id FROM class_members WHERE user_id = ? LIMIT 1');
    $stmt->execute([$user['id']]);
    $row = $stmt->fetch();
    $currentClassId = $row['class_id'] ?? null;
}

include __DIR__ . '/../../app/views/layouts/admin-header.php';
?>

<div class="page-header"><h1><?= $user ? 'Edit User' : 'Tambah User' ?></h1></div>

<div class="form-box">
    <form method="post">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?= e($user['nama'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= e($user['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Password <?= $user ? '(kosongkan jika tidak ingin mengubah)' : '' ?></label>
            <input type="text" name="password" placeholder="<?= $user ? '••••••' : 'user123' ?>">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="user" <?= (($user['role'] ?? 'user') === 'user') ? 'selected' : '' ?>>User (Siswa)</option>
                <option value="admin" <?= (($user['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div class="form-group">
            <label>Kelas (khusus role User)</label>
            <select name="class_id">
                <option value="">-- Tidak ada kelas --</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $currentClassId == $c['id'] ? 'selected' : '' ?>><?= e($c['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-yellow">Simpan</button>
        <a href="users.php" class="btn">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../../app/views/layouts/admin-footer.php'; ?>
