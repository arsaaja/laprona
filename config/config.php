<?php
// config/config.php

session_start();

define('BASE_URL', '');
define('APP_NAME', 'La Prona');

date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../app/helpers/functions.php';
