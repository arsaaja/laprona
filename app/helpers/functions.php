<?php
// app/helpers/functions.php

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function currentUser()
{
    if (!isLoggedIn()) return null;
    return [
        'id'    => $_SESSION['user_id'],
        'nama'  => $_SESSION['nama'],
        'email' => $_SESSION['email'],
        'role'  => $_SESSION['role'],
    ];
}

function isAdmin()
{
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/login.php');
        exit;
    }
}

function requireAdmin()
{
    requireLogin();
    if (!isAdmin()) {
        header('Location: ' . BASE_URL . '/dashboard.php');
        exit;
    }
}

function e($string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function badgeColor($warna)
{
    $map = [
        'teal'   => '#0f6b5c',
        'cyan'   => '#5ce1e6',
        'gray'   => '#e5e5e5',
        'yellow' => '#f6c90e',
    ];
    return $map[$warna] ?? '#e5e5e5';
}

function flash($key, $message = null)
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return;
    }
    if (!empty($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}
