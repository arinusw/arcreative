<?php
// DATABASE CONFIGURATION - DUPLICATE FILE UNTUK TEMPLATE
// COPY INI MENJADI config.php DAN EDIT DENGAN CREDENTIALS ANDA

define('BASE_URL', 'http://localhost/arcreative/');
define('ADMIN_URL', BASE_URL . 'admin/');
define('API_URL', BASE_URL . 'api/');

// ⚠️ JANGAN UPLOAD FILE INI KE GITHUB - HANYA CONFIG.PHP YANG REAL
// Database Configuration (GANTI DENGAN CREDENTIALS ANDA)
$db_host = 'localhost';         // Your database host
$db_user = 'root';              // Your database username
$db_pass = '';                  // Your database password
$db_name = 'arcreative_cms';    // Database name

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset('utf8mb4');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// SESSION CONFIGURATION
session_start();
define('SESSION_TIMEOUT', 3600); // 1 hour

// SECURITY FUNCTIONS
function isLoggedIn() {
    return isset($_SESSION['admin_id']) && 
           isset($_SESSION['admin_email']) && 
           (time() - $_SESSION['last_activity']) < SESSION_TIMEOUT;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . ADMIN_URL . 'login.php');
        exit();
    }
}

function sanitize($data) {
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(trim($data)));
}

function validateToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function generateToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function jsonResponse($success = true, $message = '', $data = []) {
    header('Content-Type: application/json');
    return json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
}

// Update session activity
$_SESSION['last_activity'] = time();
?>
