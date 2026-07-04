<?php
require_once __DIR__ . '/../config/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dummy check, semua kombinasi diterima
    $_SESSION['user_id'] = 1;
    $_SESSION['nama'] = $_POST['username'] ?: 'Alex Jordan';
    header('Location: dashboard.php');
    exit;
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
    <?php if ($error): ?><p style="color:red;"><?= e($error) ?></p><?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" value="Alex Jordan">
        <input type="password" name="password" placeholder="Password" value="dummy123">
        <button type="submit" class="btn btn-yellow" style="width:100%;">Login</button>
    </form>
</div>
</body>
</html>
