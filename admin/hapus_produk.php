<?php
include_once("../config.php");

// Proteksi halaman: pastikan hanya admin yang bisa akses
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Mengecek apakah ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id_produk = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Soft Delete: Jangan gunakan DELETE FROM, cukup ubah is_tampil menjadi 0
    $query = "UPDATE produk_roti SET is_tampil = 0 WHERE id_produk = '$id_produk'";
    
    if (mysqli_query($conn, $query)) {
        // Redirect kembali dengan pesan sukses
        header('Location: kelola_produk.php?pesan=hapus_sukses');
    } else {
        // Redirect dengan pesan error
        header('Location: kelola_produk.php?pesan=hapus_gagal');
    }
} else {
    header('Location: kelola_produk.php');
}
exit();
?>