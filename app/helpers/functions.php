<?php
// app/helpers/functions.php

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/login.php');
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
