<?php
include_once("config.php");
if (!isLoggedIn()) { header('Location: login.php'); exit(); }

$id_user = $_SESSION['user_id'];

// Ambil data keranjang untuk dihitung totalnya
$query = "SELECT k.qty, p.id_produk, p.harga FROM keranjang k JOIN produk_roti p ON k.id_produk = p.id_produk WHERE k.id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$total_pembayaran = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $total_pembayaran += ($row['harga'] * $row['qty']);
}

// Jika keranjang kosong, tidak boleh checkout
if ($total_pembayaran == 0) { header('Location: keranjang.php'); exit(); }

// JIKA FORM CHECKOUT DISUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $tanggal_pesanan = date('Y-m-d H:i:s');
    $status = 'pending';
    
    // Proses Upload Bukti Bayar
    $bukti_path = "";
    if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == 0) {
        $file_name = $_FILES['bukti_bayar']['name'];
        $file_size = $_FILES['bukti_bayar']['size'];
        $file_tmp = $_FILES['bukti_bayar']['tmp_name'];
        
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['png', 'jpg', 'jpeg'];
        
        if (!in_array($ext, $allowed_ext)) {
            echo "<script>alert('Format bukti transfer tidak valid! Hanya menerima JPG, JPEG, atau PNG.'); window.history.back();</script>";
            exit();
        }
        
        if ($file_size > 2 * 1024 * 1024) { // 2MB
            echo "<script>alert('Ukuran bukti transfer terlalu besar! Maksimal 2MB.'); window.history.back();</script>";
            exit();
        }
        
        $nama_file = time() . '_' . $file_name;
        $bukti_path = 'uploads/bukti/' . $nama_file;
        move_uploaded_file($file_tmp, $bukti_path);
    } else {
        echo "<script>alert('Anda harus mengunggah bukti transfer!'); window.history.back();</script>";
        exit();
    }

    // 1. Insert ke tabel pesanan
    $sql_pesanan = "INSERT INTO pesanan (id_user, tanggal_pesanan, total_pembayaran, alamat_pengiriman, bukti_bayar, status) 
                    VALUES ('$id_user', '$tanggal_pesanan', '$total_pembayaran', '$alamat', '$bukti_path', '$status')";
    
    if (mysqli_query($conn, $sql_pesanan)) {
        $id_pesanan = mysqli_insert_id($conn); // Ambil ID pesanan yang baru saja terbuat

        // 2. Insert ke detail_pesanan & kurangi stok produk
        mysqli_data_seek($result, 0); // Reset pointer loop keranjang
        while ($row = mysqli_fetch_assoc($result)) {
            $id_produk = $row['id_produk'];
            $qty = $row['qty'];
            $harga = $row['harga'];
            
            mysqli_query($conn, "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah_beli, harga_satuan) VALUES ('$id_pesanan', '$id_produk', '$qty', '$harga')");
            mysqli_query($conn, "UPDATE produk_roti SET stok = stok - $qty WHERE id_produk = '$id_produk'");
        }

        // 3. Kosongkan keranjang user
        mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user'");
        
        echo "<script>alert('Pesanan berhasil dibuat! Menunggu konfirmasi admin.'); window.location='index.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Roti Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="assets/css/style_index_user.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FAF6F0; color: #3E2723; }
        .checkout-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="katalog.php">Katalog</a></li>
                    <?php if(isLoggedIn()): ?>
                        <?php if($_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item d-lg-none"><a class="nav-link text-warning fw-bold" href="admin/index.php"><i class="fa-solid fa-gauge me-2"></i>Panel Admin</a></li>
                        <?php else: ?>
                            <li class="nav-item d-lg-none"><a class="nav-link" href="keranjang.php"><i class="fa-solid fa-cart-shopping me-2"></i>Keranjang</a></li>
                        <?php endif; ?>
                        <li class="nav-item d-lg-none"><a class="nav-link text-danger" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Keluar (<?= htmlspecialchars($_SESSION['full_name']); ?>)</a></li>
                    <?php else: ?>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="login.php"><i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Masuk</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <?php if(isLoggedIn()): ?>
                        <?php if($_SESSION['role'] === 'admin'): ?>
                            <a href="admin/index.php" class="btn btn-warning text-white" style="border-radius: 25px; padding: 6px 20px; font-weight:600;">Panel Admin</a>
                        <?php else: ?>
                            <a href="keranjang.php" class="nav-link position-relative me-3 text-dark" title="Keranjang Belanja">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                    <?php 
                                    $q_cart_count = mysqli_query($conn, "SELECT SUM(qty) as total FROM keranjang WHERE id_user='$id_user'");
                                    $r_cart_count = mysqli_fetch_assoc($q_cart_count);
                                    echo $r_cart_count['total'] ? $r_cart_count['total'] : '0';
                                    ?>
                                </span>
                            </a>
                        <?php endif; ?>
                        <span class="fw-medium text-dark">Halo, <?= htmlspecialchars($_SESSION['full_name']); ?>!</span>
                        <a href="logout.php" class="btn btn-outline-danger" style="border-radius: 25px; padding: 6px 20px; font-weight:600;">Keluar</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-outline-primary-custom">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5" style="min-height: 60vh;">
        <h2 class="fw-bold mb-4 text-center">Pengiriman & Pembayaran</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="checkout-card">
                    
                    <div class="alert alert-info mb-4">
                        Silakan transfer sebesar <strong>Rp <?= number_format($total_pembayaran, 0, ',', '.'); ?></strong> ke rekening <strong>BCA 1234567890 a.n. Roti Nusantara</strong>
                    </div>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Pengiriman Lengkap</label>
                            <textarea class="form-control" name="alamat" rows="4" placeholder="Masukkan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan kota." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Bukti Transfer</label>
                            <input type="file" class="form-control" name="bukti_bayar" accept="image/png, image/jpeg, image/jpg" required>
                            <div class="form-text">Hanya menerima format JPG, JPEG, PNG. Maksimal 2MB.</div>
                        </div>
                        <button type="submit" name="checkout" class="btn w-100" style="background-color: #E67E22; color: white; font-weight: 600; padding: 12px; border-radius: 10px;">
                            Selesaikan Pesanan
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4 bg-white border-top">
        <div class="container text-center">
            <p class="m-0 text-muted" style="font-size: 0.9rem;">&copy; 2026 Roti Nusantara. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>