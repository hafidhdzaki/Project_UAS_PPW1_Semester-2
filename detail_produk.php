<?php 
include_once("config.php"); 

// Ambil ID produk dari URL (misal: detail_produk.php?id=1)
$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data dari database
$query = "SELECT p.*, k.nama_kategori FROM produk_roti p JOIN kategori_roti k ON p.id_kategori = k.id_kategori WHERE p.id_produk = '$id_produk'";
$result = mysqli_query($conn, $query);

// Jika produk tidak ditemukan, kembalikan ke katalog
if(mysqli_num_rows($result) == 0) {
    header('Location: katalog.php');
    exit();
}
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama_produk']); ?> - Roti Nusantara</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style_detail_produk.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fa-solid fa-bread-slice"></i> Roti Nusantara</a>
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
                                    $id_user_cart = $_SESSION['user_id'];
                                    $q_cart_count = mysqli_query($conn, "SELECT SUM(qty) as total FROM keranjang WHERE id_user='$id_user_cart'");
                                    $r_cart_count = mysqli_fetch_assoc($q_cart_count);
                                    echo $r_cart_count['total'] ? $r_cart_count['total'] : '0';
                                    ?>
                                </span>
                            </a>
                        <?php endif; ?>
                        <span class="fw-medium text-dark">Halo, <?= htmlspecialchars($_SESSION['full_name']); ?>!</span>
                        <a href="logout.php" class="btn btn-outline-danger" style="border-radius: 25px; padding: 6px 20px; font-weight:600;">Keluar</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-primary-custom">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-2">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item"><a href="katalog.php">Katalog</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($data['nama_produk']); ?></li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="main-image-wrapper">
                    <span class="badge-kategori-img"><?= htmlspecialchars($data['nama_kategori']); ?></span>
                    <?php if($data['stok'] > 0): ?>
                        <span class="badge-status-img"><i class="fa-solid fa-check"></i> Tersedia</span>
                    <?php else: ?>
                        <span class="badge-status-img" style="background:#FEE4E2; color:#E74C3C;"><i class="fa-solid fa-xmark"></i> Habis</span>
                    <?php endif; ?>
                    <img id="mainImage" src="<?= htmlspecialchars($data['gambar'] ? 'admin/' . $data['gambar'] : 'https://via.placeholder.com/800'); ?>" alt="Produk">
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <span class="product-badge-text"><?= htmlspecialchars($data['nama_kategori']); ?></span>
                <h1 class="product-title"><?= htmlspecialchars($data['nama_produk']); ?></h1>
                
                <div class="rating-box">
                    <div class="stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span class="rating-text">4.8</span>
                </div>

                <div class="product-price">
                    Rp <?= number_format($data['harga'], 0, ',', '.'); ?> <span class="price-unit">/ buah</span>
                </div>
                
                <div class="stock-status <?= $data['stok'] > 0 ? '' : 'text-danger'; ?>">
                    <i class="fa-solid fa-box-open"></i> Stok tersedia: <?= $data['stok']; ?> buah
                </div>

                <div class="product-desc-short mb-4">
                    <strong>Deskripsi Produk</strong><br>
                    <?= nl2br(htmlspecialchars($data['deskripsi'])); ?>
                </div>

                <form action="tambah_keranjang.php" method="POST" class="action-box">
                    <input type="hidden" name="id_produk" value="<?= $data['id_produk']; ?>">
                    
                    <label class="qty-label">Jumlah</label>
                    <div class="qty-selector">
                        <button type="button" class="btn-qty" onclick="updateQty(-1)">-</button>
                        <input type="text" class="input-qty" id="qtyInput" name="qty" value="1" readonly>
                        <button type="button" class="btn-qty" onclick="updateQty(1)">+</button>
                    </div>

                    <div class="total-box">
                        <span class="total-label">Total Pembayaran</span>
                        <span class="total-price" id="totalPrice">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></span>
                    </div>

                    <button type="submit" class="btn-pesan" <?= $data['stok'] == 0 ? 'disabled style="background:gray;"' : ''; ?>>
                        <i class="fa-solid fa-cart-shopping"></i> Masukkan Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 30 });

        // JS DINAMIS BACA HARGA DAN STOK DARI DATABASE!
        const basePrice = <?= $data['harga']; ?>;
        const maxStok = <?= $data['stok']; ?>;
        let currentQty = 1;

        function updateQty(change) {
            if(maxStok === 0) return; // Jika habis jangan jalan
            
            let newQty = currentQty + change;
            if(newQty >= 1 && newQty <= maxStok) {
                currentQty = newQty;
                document.getElementById('qtyInput').value = currentQty;
                
                let totalPrice = basePrice * currentQty;
                document.getElementById('totalPrice').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
            }
        }
    </script>
</body>
</html>