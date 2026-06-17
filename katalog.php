<?php 
include_once("config.php"); 

// Ambil parameter filter & pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? intval($_GET['kategori']) : 0;
$stok_filter = isset($_GET['stok']) ? (array)$_GET['stok'] : [];
$harga_max = isset($_GET['harga_max']) ? intval($_GET['harga_max']) : 100000;

// Base query
$query_katalog = "
    SELECT p.*, k.nama_kategori 
    FROM produk_roti p 
    JOIN kategori_roti k ON p.id_kategori = k.id_kategori 
    WHERE p.is_tampil = 1
";

if (!empty($search)) {
    $query_katalog .= " AND p.nama_produk LIKE '%$search%'";
}

if ($kategori_filter > 0) {
    $query_katalog .= " AND p.id_kategori = '$kategori_filter'";
}

if ($harga_max > 0) {
    $query_katalog .= " AND p.harga <= '$harga_max'";
}

// Filter stok jika ada
if (!empty($stok_filter)) {
    $stok_cond = [];
    foreach ($stok_filter as $s) {
        if ($s === 'tersedia') {
            $stok_cond[] = "p.stok > 5";
        } elseif ($s === 'hampir_habis') {
            $stok_cond[] = "(p.stok > 0 AND p.stok <= 5)";
        } elseif ($s === 'habis') {
            $stok_cond[] = "p.stok = 0";
        }
    }
    if (!empty($stok_cond)) {
        $query_katalog .= " AND (" . implode(" OR ", $stok_cond) . ")";
    }
}

$query_katalog .= " ORDER BY p.id_produk DESC";
$result_katalog = mysqli_query($conn, $query_katalog);

// Ambil data kategori untuk filter
$categories_res = mysqli_query($conn, "SELECT * FROM kategori_roti");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style_katalog.css" rel="stylesheet">
</head>
<body>

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
                    <li class="nav-item"><a class="nav-link active" href="#">Katalog</a></li>
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

    <section class="page-header">
        <div class="container" data-aos="fade-up">
            <h1>Katalog Produk</h1>
            <p>Temukan roti favoritmu di sini</p>
            <div class="breadcrumb-custom">
                <a href="index.php">Beranda</a> <span><i class="fa-solid fa-chevron-right" style="font-size:0.7rem;"></i></span> Katalog
            </div>
        </div>
    </section>

    <div class="container" style="margin-top: -30px;">
        <div class="row g-4">
            
            <div class="col-lg-3">
                <div class="offcanvas-lg offcanvas-start sidebar-filter h-100" tabindex="-1" id="filterSidebar">
                    
                    <div class="offcanvas-header d-lg-none border-bottom mb-3 pb-3">
                        <h5 class="offcanvas-title fw-bold">Filter Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar"></button>
                    </div>
                    
                    <form action="katalog.php" method="GET" class="offcanvas-body flex-column p-0 p-lg-1">
                        <?php if(!empty($search)): ?>
                            <input type="hidden" name="search" value="<?= htmlspecialchars($search); ?>">
                        <?php endif; ?>
                        
                        <div class="mb-4">
                            <h6 class="filter-section-title">Kategori</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="kategori" id="cat_all" value="0" <?= ($kategori_filter == 0) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="cat_all">Semua Kategori</label>
                            </div>
                            <?php 
                            mysqli_data_seek($categories_res, 0);
                            while ($cat = mysqli_fetch_assoc($categories_res)): 
                            ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="kategori" id="cat_<?= $cat['id_kategori'] ?>" value="<?= $cat['id_kategori'] ?>" <?= ($kategori_filter == $cat['id_kategori']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="cat_<?= $cat['id_kategori'] ?>"><?= htmlspecialchars($cat['nama_kategori']) ?></label>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="mb-4">
                            <h6 class="filter-section-title">Rentang Harga</h6>
                            <div class="range-slider-wrapper">
                                <input type="range" class="form-range" min="0" max="100000" step="5000" id="priceRange" name="harga_max" value="<?= $harga_max ?>" style="accent-color: var(--primary-color);">
                                <div class="range-values">
                                    <span>Rp 0</span>
                                    <span class="fw-bold text-dark" id="priceValue">Rp <?= number_format($harga_max, 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="filter-section-title">Status Stok</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="stok[]" value="tersedia" id="stock1" <?= in_array('tersedia', $stok_filter) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="stock1">Tersedia (> 5)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="stok[]" value="hampir_habis" id="stock2" <?= in_array('hampir_habis', $stok_filter) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="stock2">Hampir Habis (1 - 5)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="stok[]" value="habis" id="stock3" <?= in_array('habis', $stok_filter) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="stock3">Habis (0)</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top gap-2">
                            <a href="katalog.php" class="btn btn-sm btn-outline-secondary text-decoration-none w-50 text-center" style="border-radius: 8px; padding: 6px 0;"><i class="fa-solid fa-rotate-right me-1"></i> Reset</a>
                            <button type="submit" class="btn btn-sm btn-primary w-50" style="background-color: var(--primary-color); border:none; border-radius:8px; padding: 6px 0;">Terapkan</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-9 pt-4 pt-lg-0">
                
                <form action="katalog.php" method="GET" class="d-flex gap-2 mb-3">
                    <?php if ($kategori_filter > 0): ?>
                        <input type="hidden" name="kategori" value="<?= $kategori_filter ?>">
                    <?php endif; ?>
                    <?php if ($harga_max < 100000): ?>
                        <input type="hidden" name="harga_max" value="<?= $harga_max ?>">
                    <?php endif; ?>
                    <?php foreach ($stok_filter as $sf): ?>
                        <input type="hidden" name="stok[]" value="<?= htmlspecialchars($sf) ?>">
                    <?php endforeach; ?>
                    <div class="search-container flex-grow-1">
                        <input type="search" name="search" placeholder="Cari nama roti..." value="<?= htmlspecialchars($search); ?>">
                    </div>
                    <button type="submit" class="btn text-white" style="background-color: var(--primary-color); border:none; border-radius:10px; padding: 0 15px;"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <button type="button" class="btn-filter-mobile d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                        <i class="fa-solid fa-sliders"></i> Filter
                    </button>
                </form>

                <div class="category-scroll-wrapper mb-4">
                    <a href="katalog.php?kategori=0<?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" class="cat-pill <?= ($kategori_filter == 0) ? 'active' : '' ?>">Semua</a>
                    <?php 
                    mysqli_data_seek($categories_res, 0);
                    while ($cat = mysqli_fetch_assoc($categories_res)): 
                    ?>
                        <a href="katalog.php?kategori=<?= $cat['id_kategori'] ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" class="cat-pill <?= ($kategori_filter == $cat['id_kategori']) ? 'active' : '' ?>">
                            <?= htmlspecialchars($cat['nama_kategori']) ?>
                        </a>
                    <?php endwhile; ?>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 justify-content-center">
                    <?php if(mysqli_num_rows($result_katalog) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_katalog)): ?>
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

                                        <img src="<?= htmlspecialchars($row['gambar'] != '' ? 'admin/' . $row['gambar'] : 'https://via.placeholder.com/600'); ?>" alt="Produk">
                                    </div>
                                    <div class="product-body">
                                        <h3 class="product-title"><?= htmlspecialchars($row['nama_produk']); ?></h3>
                                        <p class="product-desc"><?= htmlspecialchars($row['deskripsi']); ?></p>
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
                            <h5 class="text-muted">Belum ada produk di katalog.</h5>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="text-center mt-5 mb-2 text-muted" style="font-size: 0.9rem;">Halaman 1 dari 2</div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1"><i class="fa-solid fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 col-md-12">
                    <a href="index.php" class="footer-brand">
                        <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
                    </a>
                    <p class="footer-text">Roti segar berkualitas tinggi, dipanggang dengan cinta setiap hari.</p>
                    <p class="text-muted" style="font-size: 0.8rem;">&copy; 2026 Roti Nusantara. Hak cipta dilindungi.</p>
                </div>
                <div class="col-lg-2 col-md-4 offset-lg-4 footer-links">
                    <h6>Tautan</h6>
                    <ul>
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="#">Katalog</a></li>
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
        // Inisialisasi AOS
        AOS.init({
            once: true,
            offset: 30,
        });

        // Script sederhana untuk interaksi label harga pada range input
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        
        if(priceRange) {
            priceRange.addEventListener('input', function() {
                // Format angka ke format Rupiah
                let val = parseInt(this.value).toLocaleString('id-ID');
                priceValue.textContent = 'Rp ' + val;
            });
        }
    </script>
</body>
</html>