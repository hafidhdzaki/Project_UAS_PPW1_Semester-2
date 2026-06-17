<?php
include_once("config.php");

// Ambil 4 produk yang ditandai sebagai "Produk Unggulan" oleh Admin
$q_unggulan = mysqli_query($conn, "
    SELECT p.*, k.nama_kategori 
    FROM produk_roti p 
    JOIN kategori_roti k ON p.id_kategori = k.id_kategori 
    WHERE p.is_tampil = 1 AND p.is_unggulan = 1 
    LIMIT 4
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style_index_user.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="katalog.php">Katalog</a></li>
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
                        <a href="login.php" class="btn-outline-primary-custom">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="hero-title">Roti Segar<br>Setiap Hari</h1>
                    <p class="hero-text">Pesan roti favoritmu dengan mudah. Dibuat dengan cinta, dikirim ke pintu rumahmu.</p>
                    <a href="katalog.php" class="btn btn-hero">Lihat Katalog <i class="fa-solid fa-chevron-right ms-2"></i></a>
                    
                    <div class="hero-stats">
                        <div class="stat-item">
                            <h4>500+</h4>
                            <p>Produk</p>
                        </div>
                        <div class="stat-item">
                            <h4>10K+</h4>
                            <p>Pelanggan</p>
                        </div>
                        <div class="stat-item">
                            <h4>15+</h4>
                            <p>Tahun</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 d-none d-md-block" data-aos="zoom-in" data-aos-duration="1200">
                    <div class="hero-image-container">
                        <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Roti Segar">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5 pb-4">
        <div class="text-center mb-4" data-aos="fade-up">
            <p class="section-subtitle">Jelajahi Pilihan</p>
            <h2 class="section-title">Kategori Roti</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="category-card">
                    <div class="category-icon"><i class="fa-solid fa-bread-slice"></i></div>
                    <h5>Roti Tawar</h5>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="category-card">
                    <div class="category-icon"><i class="fa-solid fa-cake-candles"></i></div>
                    <h5>Roti Manis</h5>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="category-card">
                    <div class="category-icon"><i class="fa-solid fa-burger"></i></div>
                    <h5>Roti Gurih</h5>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="category-card">
                    <div class="category-icon"><i class="fa-solid fa-cookie"></i></div>
                    <h5>Kue Kering</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5 pb-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Pilihan Terbaik Kami</p>
            <h2 class="section-title">Produk Unggulan</h2>
            <p class="text-muted max-w-50 mx-auto">Dari roti tawar premium hingga pastry artisan — setiap produk dibuat dengan standar kualitas tertinggi.</p>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-4 justify-content-center">
            <?php if(mysqli_num_rows($q_unggulan) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($q_unggulan)): ?>
                    <div class="col" data-aos="fade-up">
                        <div class="card product-card">
                            <div class="product-img-wrapper">
                                <span class="badge-kategori"><?= htmlspecialchars($row['nama_kategori']); ?></span>
                                
                                <?php if($row['stok'] > 5): ?>
                                    <span class="badge-status bg-tersedia"><i class="fa-solid fa-check"></i> Tersedia</span>
                                <?php elseif($row['stok'] > 0 && $row['stok'] <= 5): ?>
                                    <span class="badge-status bg-hampir-habis"><i class="fa-solid fa-fire"></i> Hampir Habis</span>
                                <?php else: ?>
                                    <span class="badge-status bg-habis"><i class="fa-solid fa-xmark"></i> Habis</span>
                                <?php endif; ?>

                                <img src="<?= htmlspecialchars($row['gambar'] != '' ? 'admin/' . $row['gambar'] : 'https://via.placeholder.com/600'); ?>" alt="<?= htmlspecialchars($row['nama_produk']); ?>">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title text-truncate" title="<?= htmlspecialchars($row['nama_produk']); ?>">
                                    <?= htmlspecialchars($row['nama_produk']); ?>
                                </h3>
                                <p class="product-desc line-clamp-2">
                                    <?= htmlspecialchars($row['deskripsi']); ?>
                                </p>
                                <div class="mt-auto">
                                    <div class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
                                    <a href="detail_produk.php?id=<?= $row['id_produk']; ?>" class="btn-card-action d-block text-center text-decoration-none">
                                        <i class="fa-regular fa-eye me-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Belum ada produk unggulan yang ditampilkan.</h5>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="container mb-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="section-subtitle">Mengapa Memilih Kami</p>
            <h2 class="section-title">Keunggulan Kami</h2>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-wheat-awn"></i></div>
                    <h5>Bahan Berkualitas</h5>
                    <p>Tepung premium dan bahan alami pilihan dari petani lokal terpercaya. Tanpa pengawet.</p>
                </div>
            </div>
            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                    <h5>Pengiriman Cepat</h5>
                    <p>Roti sampai dalam 2 jam setelah dipanggang. Same-day delivery tersedia.</p>
                </div>
            </div>
            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-star"></i></div>
                    <h5>Selalu Segar</h5>
                    <p>Dipanggang setiap pagi mulai jam 4 subuh. Garansi kesegaran 100%.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 col-md-12">
                    <a href="#" class="footer-brand">
                        <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
                    </a>
                    <p class="footer-text">Roti segar berkualitas tinggi, dipanggang dengan cinta setiap hari.</p>
                    <p class="text-muted" style="font-size: 0.8rem;">&copy; 2026 Roti Nusantara. Hak cipta dilindungi.</p>
                </div>
                <div class="col-lg-2 col-md-4 offset-lg-4 footer-links">
                    <h6>Tautan</h6>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="katalog.php">Katalog</a></li>
                        <li><a href="login.php">Masuk</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                Dibuat dengan <i class="fa-solid fa-heart" style="color: #e74c3c;"></i> sebagai proyek bakery lokal Indonesia
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi Animasi AOS
        AOS.init({
            once: true, // Animasi hanya berjalan sekali saat di-scroll
            offset: 50, // Jarak trigger animasi
        });
    </script>
</body>
</html>