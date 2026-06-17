<?php
include_once("../includes/config.php");

// Pastikan user sudah login
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['user_id'];
    $id_produk = (int)$_POST['id_produk'];
    $qty = (int)$_POST['qty'];

    if ($qty <= 0) {
        header('Location: katalog.php');
        exit();
    }

    // Ambil info produk dan cek stok
    $q_produk = mysqli_query($conn, "SELECT stok FROM produk_roti WHERE id_produk = '$id_produk'");
    if (mysqli_num_rows($q_produk) > 0) {
        $p_data = mysqli_fetch_assoc($q_produk);
        $stok_tersedia = $p_data['stok'];

        if ($stok_tersedia <= 0) {
            echo "<script>alert('Maaf, stok produk habis!'); window.location='katalog.php';</script>";
            exit();
        }

        // Cek apakah produk sudah ada di keranjang user ini
        $cek_keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user='$id_user' AND id_produk='$id_produk'");
        
        if (mysqli_num_rows($cek_keranjang) > 0) {
            // Jika ada, tambahkan qty-nya
            $data = mysqli_fetch_assoc($cek_keranjang);
            $new_qty = $data['qty'] + $qty;
            
            // Jangan melebihi stok yang ada
            if ($new_qty > $stok_tersedia) {
                $new_qty = $stok_tersedia;
            }
            mysqli_query($conn, "UPDATE keranjang SET qty='$new_qty' WHERE id_keranjang='".$data['id_keranjang']."'");
        } else {
            // Jangan melebihi stok yang ada
            if ($qty > $stok_tersedia) {
                $qty = $stok_tersedia;
            }
            // Jika belum, insert baru
            mysqli_query($conn, "INSERT INTO keranjang (id_user, id_produk, qty) VALUES ('$id_user', '$id_produk', '$qty')");
        }
    }

    // Arahkan ke halaman keranjang
    header('Location: keranjang.php');
    exit();
}
?>