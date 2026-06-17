<?php
include_once("../../includes/config.php");


// Proteksi Admin
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama        = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $harga       = floatval($_POST['harga']);
    $stok        = intval($_POST['stok']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Toggle switches (jika dicentang nilainya 1, jika tidak 0)
    $is_tampil   = isset($_POST['is_tampil']) ? 1 : 0;
    $is_unggulan = isset($_POST['is_unggulan']) ? 1 : 0;

    // Proses Upload Gambar
    $gambar_path = "";
    if (isset($_FILES['gambar_produk']) && $_FILES['gambar_produk']['error'] == 0) {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'webp');
        $nama_file = $_FILES['gambar_produk']['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['gambar_produk']['size'];
        $file_tmp = $_FILES['gambar_produk']['tmp_name'];

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 2097152) { // Maksimal 2MB
                $nama_file_baru = time() . '_' . $nama_file;
                $gambar_path = 'assets/img/' . $nama_file_baru;
                
                move_uploaded_file($file_tmp, '../../' . $gambar_path);
            } else {
                echo "<script>alert('UKURAN FILE TERLALU BESAR!'); window.location='tambah_produk.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('EKSTENSI FILE TIDAK DIPERBOLEHKAN!'); window.location='tambah_produk.php';</script>";
            exit();
        }
    }

    // Insert ke Database
    $query = "INSERT INTO produk_roti (id_kategori, nama_produk, deskripsi, harga, stok, gambar, is_tampil, is_unggulan) 
              VALUES ('$id_kategori', '$nama', '$deskripsi', '$harga', '$stok', '$gambar_path', '$is_tampil', '$is_unggulan')";
              
    if (mysqli_query($conn, $query)) {
        header('Location: kelola_produk.php?pesan=tambah_sukses');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>