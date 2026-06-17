<?php
session_start();

// Hitung kedalaman path script untuk meresolusi tautan relatif (BASE_PATH)
$relative_path = "";
$current_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if (preg_match('/\/pages\/admin$/i', $current_dir)) {
    $relative_path = "../../";
} elseif (preg_match('/\/pages$/i', $current_dir)) {
    $relative_path = "../";
}
define('BASE_PATH', $relative_path);

$host = "localhost";
$user = "root";
$pass = "";
$db = "manajemen_roti";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

function isLoggedIn() {
    date_default_timezone_set('Asia/Jakarta');
    return isset($_SESSION['user_id']);
}
?>