<?php
session_start();
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