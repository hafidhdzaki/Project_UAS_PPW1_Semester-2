include_once("../includes/config.php"); 

// Ambil parameter filter & pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? intval($_GET['kategori']) : 0;
$stok_filter = isset($_GET['stok']) ? (array)$_GET['stok'] : [];
$harga_max = isset($_GET['harga_max']) ? intval($_GET['harga_max']) : 100000;

// Paginasi
$limit = 9; // Tampilkan 9 produk per halaman
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Base query untuk hitung total
$query_count = "
    SELECT COUNT(p.id_produk) as total 
    FROM produk_roti p 
    JOIN kategori_roti k ON p.id_kategori = k.id_kategori 
    WHERE p.is_tampil = 1
";

// Base query untuk data
$query_katalog = "
    SELECT p.*, k.nama_kategori 
    FROM produk_roti p 
    JOIN kategori_roti k ON p.id_kategori = k.id_kategori 
    WHERE p.is_tampil = 1
";

$filter_sql = "";
if (!empty($search)) {
    $filter_sql .= " AND p.nama_produk LIKE '%$search%'";
}

if ($kategori_filter > 0) {
    $filter_sql .= " AND p.id_kategori = '$kategori_filter'";
}

if ($harga_max > 0) {
    $filter_sql .= " AND p.harga <= '$harga_max'";
}

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
        $filter_sql .= " AND (" . implode(" OR ", $stok_cond) . ")";
    }
}

$query_count .= $filter_sql;
$total_records = mysqli_fetch_assoc(mysqli_query($conn, $query_count))['total'];
$total_pages = ceil($total_records / $limit);
if ($total_pages < 1) $total_pages = 1;
if ($page > $total_pages) $page = $total_pages;

$offset = ($page - 1) * $limit;

$query_katalog .= $filter_sql . " ORDER BY p.id_produk DESC LIMIT $limit OFFSET $offset";
$result_katalog = mysqli_query($conn, $query_katalog);

// Ambil data kategori untuk filter
$categories_res = mysqli_query($conn, "SELECT * FROM kategori_roti");

// Helper untuk URL paginasi
function getPageUrl($p) {
    $params = $_GET;
    $params['page'] = $p;
    return 'katalog.php?' . http_build_query($params);
}
?>
<?php
$page_title = "Katalog Produk - Roti Nusantara";
$active_page = "katalog";
$custom_css = "assets/css/style_katalog.css";
include_once("../includes/header.php");
?>

    <section class="page-header">
        <div class="container" data-aos="fade-up">
            <h1>Katalog Produk</h1>
            <p>Temukan roti favoritmu di sini</p>
            <div class="breadcrumb-custom">
                <a href="<?= BASE_PATH; ?>index.php">Beranda</a> <span><i class="fa-solid fa-chevron-right" style="font-size:0.7rem;"></i></span> Katalog
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

                                        <img src="<?= htmlspecialchars($row['gambar'] != '' ? BASE_PATH . $row['gambar'] : 'https://via.placeholder.com/600'); ?>" alt="Produk">
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

                <div class="text-center mt-5 mb-2 text-muted" style="font-size: 0.9rem;">Halaman <?= $page; ?> dari <?= $total_pages; ?></div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?= ($page <= 1) ? '#' : htmlspecialchars(getPageUrl($page - 1)); ?>" tabindex="-1"><i class="fa-solid fa-chevron-left"></i></a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="<?= htmlspecialchars(getPageUrl($i)); ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?= ($page >= $total_pages) ? '#' : htmlspecialchars(getPageUrl($page + 1)); ?>"><i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>

<?php
$custom_js = "assets/js/katalog.js";
include_once("../includes/footer.php");
?>