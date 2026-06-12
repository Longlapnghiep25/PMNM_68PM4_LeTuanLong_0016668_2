<?php
session_start();

// ===== CONFIG =====
define('BASE_URL', 'http://localhost/PMNM_68PM4_LeTuanLong_0016668_2/public');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'qlsv');
define('PAGE_SIZE', 2);

// ===== CORE =====
require_once __DIR__ . '/../app/core/DB.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/App.php';

// ===== RUN =====
new App();