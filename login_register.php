<?php
session_start();
require_once 'koneksi/koneksi.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $koneksi->query("SELECT email FROM user WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
    } else {
        $koneksi->query("INSERT INTO user (nama, email, password, role) VALUES('$nama', '$email', '$password','$role')");
    }

    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $koneksi->query("SELECT * FROM user WHERE email ='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: user/user_page.php");
            }
            exit();
        }
    }
    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_error'] = 'login';
    header("Location: index.php");
    exit();
}
?>