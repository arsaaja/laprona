<?php
// config/config.php
// Konfigurasi global aplikasi (dummy, belum pakai database)

session_start();

define('BASE_URL', '');
define('APP_NAME', 'La Prona');

// Zona waktu
date_default_timezone_set('Asia/Jakarta');

// Autoload helper dummy data
require_once __DIR__ . '/../app/helpers/dummy-data.php';
require_once __DIR__ . '/../app/helpers/functions.php';
