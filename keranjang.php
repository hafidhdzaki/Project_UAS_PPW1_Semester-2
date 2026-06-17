<?php
include_once("config.php");
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['user_id'];

// Hapus item dari keranjang jika ada request
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang='$id_hapus' AND id_user='$id_user'");
    header('Location: keranjang.php');
    exit();
}

// Ambil data keranjang beserta detail produknya
$query = "SELECT k.id_keranjang, k.qty, p.id_produk, p.nama_produk, p.harga, p.gambar 
          FROM keranjang k 
          JOIN produk_roti p ON k.id_produk = p.id_produk 
          WHERE k.id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$total_belanja = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Roti Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="assets/css/style_index_user.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FAF6F0; color: #3E2723; }
        .cart-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
        .cart-img { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; }
        .btn-checkout { background-color: #E67E22; color: white; font-weight: 600; border-radius: 10px; padding: 12px; transition: 0.3s; }
        .btn-checkout:hover { background-color: #D35400; color: white; }
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
                    <li class="nav-item"><a class="nav-link" href="katalog.php">Katalog</a></li>
                    <?php if(isLoggedIn()): ?>
                        <?php if($_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item d-lg-none"><a class="nav-link text-warning fw-bold" href="admin/index.php"><i class="fa-solid fa-gauge me-2"></i>Panel Admin</a></li>
                        <?php else: ?>
                            <li class="nav-item d-lg-none"><a class="nav-link active" href="keranjang.php"><i class="fa-solid fa-cart-shopping me-2"></i>Keranjang</a></li>
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
                            <a href="keranjang.php" class="nav-link position-relative me-3 text-dark active" title="Keranjang Belanja">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                    <?php 
                                    mysqli_data_seek($result, 0);
                                    $c_total = 0;
                                    while($r_c = mysqli_fetch_assoc($result)) { $c_total += $r_c['qty']; }
                                    echo $c_total;
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
        <h2 class="fw-bold mb-4">Keranjang Belanja</h2>
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-card">
                    <?php 
                    mysqli_data_seek($result, 0);
                    if (mysqli_num_rows($result) > 0): 
                    ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): 
                                        $subtotal = $row['harga'] * $row['qty'];
                                        $total_belanja += $subtotal;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="<?= htmlspecialchars($row['gambar'] ? 'admin/' . $row['gambar'] : 'https://via.placeholder.com/100'); ?>" class="cart-img" alt="Produk">
                                                <span class="fw-semibold"><?= htmlspecialchars($row['nama_produk']); ?></span>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                        <td><?= $row['qty']; ?></td>
                                        <td class="fw-bold" style="color: #E67E22;">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                                        <td>
                                            <a href="keranjang.php?hapus=<?= $row['id_keranjang']; ?>" class="text-danger" onclick="return confirm('Hapus produk ini?');"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <h5 class="text-muted">Keranjang Anda masih kosong.</h5>
                            <a href="katalog.php" class="btn btn-outline-primary mt-3" style="border-color: #E67E22; color: #E67E22;">Belanja Sekarang</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-card">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Harga</span>
                        <span class="fw-bold fs-5" style="color: #E67E22;">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></span>
                    </div>
                    <?php if ($total_belanja > 0): ?>
                        <a href="checkout.php" class="btn btn-checkout w-100 d-block text-center text-decoration-none">Lanjut ke Checkout</a>
                    <?php endif; ?>
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