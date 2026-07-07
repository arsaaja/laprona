<?php
// config/database.php
// Sesuaikan kredensial berikut dengan MySQL di komputer kamu (XAMPP/Laragon dsb)

define('DB_HOST', 'localhost');
define('DB_NAME', 'bimbel_online');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDB()
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . $e->getMessage() .
                '<br>Pastikan MySQL sudah jalan dan database "bimbel_online" sudah di-import dari database/bimbel_online.sql');
        }
    }
    return $pdo;
}
