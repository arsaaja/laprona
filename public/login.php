<?php
require_once __DIR__ . '/../config/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = getDB()->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Catatan: password disimpan plain text untuk kebutuhan demo.
    // Untuk produksi, gunakan password_hash() saat register dan password_verify() di sini.
    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['role']    = $user['role'];

        header('Location: ' . ($user['role'] === 'admin' ? 'admin/dashboard.php' : 'dashboard.php'));
        exit;
    } else {
        $error = 'Email atau password salah.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<div class="login-wrap">
    <h2 style="color:#1a7a4c;">La Prona</h2>
    <p>Masuk ke akun bimbel online kamu.</p>

    <div class="login-hint">
        <strong>Akun demo:</strong><br>
        Admin: admin@laprona.com / admin123<br>
        User: alex@laprona.com / user123
    </div>

    <?php if ($error): ?><p style="color:#c0392b; font-weight:700;"><?= e($error) ?></p><?php endif; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" value="<?= e($_POST['email'] ?? '') ?>" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn btn-yellow" style="width:100%;">Login</button>
    </form>
</div>
</body>
</html>
