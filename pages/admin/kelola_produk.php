<?php
include_once("../../includes/config.php");
// Proteksi Admin
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

// Paginasi
$limit = 10; // Tampilkan 10 produk per halaman
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

$total_all_query = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM produk_roti WHERE is_tampil = 1");
$total_all = mysqli_fetch_assoc($total_all_query)['cnt'];
$total_records = $total_all;

$total_pages = ceil($total_records / $limit);
if ($total_pages < 1) $total_pages = 1;
if ($page > $total_pages) $page = $total_pages;

$offset = ($page - 1) * $limit;
$no = $offset + 1;

// Query JOIN dengan paginasi
$query_produk = "
    SELECT p.*, k.nama_kategori 
    FROM produk_roti p 
    JOIN kategori_roti k ON p.id_kategori = k.id_kategori 
    WHERE p.is_tampil = 1
    ORDER BY p.id_produk DESC
    LIMIT $limit OFFSET $offset
";
$result_produk = mysqli_query($conn, $query_produk);

// Helper untuk URL paginasi
function getPageUrl($p) {
    $params = $_GET;
    $params['page'] = $p;
    return 'kelola_produk.php?' . http_build_query($params);
}

// Hitung Statistik Produk
$total_all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM produk_roti WHERE is_tampil = 1"))['cnt'];
$total_aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM produk_roti WHERE is_tampil = 1"))['cnt'];
$total_habis = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM produk_roti WHERE stok = 0 AND is_tampil = 1"))['cnt'];
$total_unggulan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM produk_roti WHERE is_unggulan = 1 AND is_tampil = 1"))['cnt'];

// Count pending orders for badge
$pesanan_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM pesanan WHERE status='pending'"))['cnt'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="../../assets/css/style_kelola_produk.css" rel="stylesheet">
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <a href="../../index.php" class="sidebar-brand">
            <div class="icon-bg"><i class="fa-solid fa-bread-slice"></i></div>
            Roti Nusantara <span class="badge-admin">ADMIN</span>
        </a>
        
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            
            <li class="has-submenu">
                <a href="#" id="toggleProduk">
                    <div class="menu-left"><i class="fa-solid fa-box"></i> Kelola Produk</div>
                    <i class="fa-solid fa-chevron-up" id="iconProduk" style="font-size: 0.7rem;"></i>
                </a>
                <ul class="submenu show" id="submenuProduk">
                    <li><a href="kelola_produk.php" class="active"><i class="fa-solid fa-list" style="font-size: 0.65rem; margin-right: 5px;"></i> Daftar Produk</a></li>
                    <li><a href="tambah_produk.php"><i class="fa-solid fa-plus" style="font-size: 0.65rem; margin-right: 5px;"></i> Tambah Produk</a></li>
                    <li><a href="kelola_kategori.php"><i class="fa-solid fa-tags" style="font-size: 0.65rem; margin-right: 5px;"></i> Kel. Kategori</a></li>
                </ul>
            </li>

            <li><a href="kelola_pesanan.php"><i class="fa-solid fa-clipboard-list"></i> Kelola Pesanan <?php if($pesanan_pending > 0): ?><span class="badge-notif"><?= $pesanan_pending; ?></span><?php endif; ?></a></li>
        </ul>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="avatar-circle">AD</div>
                <div class="user-details">
                    <h6>Admin Utama</h6>
                    <p>admin@rotinusantara.com</p>
                </div>
            </div>
            <a href="../logout.php" class="btn-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
        </div>
    </aside>

    <main class="main-content">
        
        <header class="top-header" data-aos="fade-down">
            <div class="header-left">
                <button class="btn-menu-mobile d-lg-none" id="mobileMenuBtn"><i class="fa-solid fa-bars"></i></button>
                <div class="page-title">
                    <h2>Kelola Produk</h2>
                    <p>Admin &rsaquo; Kelola Produk &rsaquo; Daftar Produk</p>
                </div>
            </div>
            <div class="avatar-circle d-lg-none" style="width:35px; height:35px; font-size:0.8rem;">AD</div>
        </header>

        <div class="row g-3 mb-2" data-aos="fade-up" data-aos-delay="100">
            <div class="col-6 col-md-3">
                <div class="stat-card border-orange">
                    <div class="stat-value"><?= $total_all; ?></div>
                    <div class="stat-title">Total Produk</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-green">
                    <div class="stat-value"><?= $total_aktif; ?></div>
                    <div class="stat-title">Produk Aktif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-red">
                    <div class="stat-value"><?= $total_habis; ?></div>
                    <div class="stat-title">Stok Habis</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-blue">
                    <div class="stat-value"><?= $total_unggulan; ?></div>
                    <div class="stat-title">Produk Unggulan</div>
                </div>
            </div>
        </div>

        <div class="admin-card" data-aos="fade-up" data-aos-delay="200">
            <?php if (isset($_GET['pesan'])): ?>
                <?php if ($_GET['pesan'] == 'tambah_sukses'): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px;">
                        <i class="fa-solid fa-circle-check me-2"></i> Produk berhasil ditambahkan!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif ($_GET['pesan'] == 'edit_sukses'): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px;">
                        <i class="fa-solid fa-circle-check me-2"></i> Perubahan produk berhasil disimpan!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif ($_GET['pesan'] == 'hapus_sukses'): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px;">
                        <i class="fa-solid fa-circle-check me-2"></i> Produk berhasil dihapus!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif ($_GET['pesan'] == 'hapus_gagal'): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px;">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> Gagal menghapus produk!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <div class="control-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari nama produk...">
                </div>
                <a href="tambah_produk.php" class="btn-add-product">
                    <i class="fa-solid fa-plus"></i> Tambah Produk Baru
                </a>
            </div>

            <div class="filter-pills">
                <button class="btn-pill active">Semua</button>
                <button class="btn-pill">Roti Tawar</button>
                <button class="btn-pill">Roti Manis</button>
                <button class="btn-pill">Roti Gurih</button>
                <button class="btn-pill">Kue Kering</button>
            </div>

            <div class="desktop-table-wrapper table-responsive">
                <table class="table table-borderless table-produk mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 80px;">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result_produk)): ?>
                        <tr data-category="<?= htmlspecialchars($row['nama_kategori']); ?>">
                            <td class="text-muted"><?= $no++; ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($row['gambar'] != '' ? '../../' . $row['gambar'] : 'https://via.placeholder.com/100'); ?>" class="img-thumbnail-custom" alt="Gambar">
                            </td>
                            <td>
                                <p class="product-name-td"><?= htmlspecialchars($row['nama_produk']); ?></p>
                            </td>
                            <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                            <td class="fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?= $row['stok']; ?> buah</td>
                            <td>
                                <?php if($row['stok'] > 0): ?>
                                    <span class="status-badge status-tersedia">Tersedia</span>
                                <?php else: ?>
                                    <span class="status-badge status-habis">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="edit_produk.php?id=<?= $row['id_produk']; ?>" class="btn-action-sm icon-blue d-flex align-items-center justify-content-center" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>" class="btn-action-sm icon-red d-flex align-items-center justify-content-center" style="background:#FDEDEC;" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" title="Hapus"><i class="fa-regular fa-trash-can"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="mobile-list-wrapper">
                <?php 
                mysqli_data_seek($result_produk, 0);
                if (mysqli_num_rows($result_produk) > 0):
                    while($row = mysqli_fetch_assoc($result_produk)):
                ?>
                    <div class="mobile-product-card" data-category="<?= htmlspecialchars($row['nama_kategori']); ?>">
                        <img src="<?= htmlspecialchars($row['gambar'] != '' ? '../../' . $row['gambar'] : 'https://via.placeholder.com/100'); ?>" class="mob-img" alt="Roti">
                        <div class="mob-details">
                            <div class="mob-title"><?= htmlspecialchars($row['nama_produk']); ?></div>
                            <div class="mob-meta">Stok: <?= $row['stok']; ?> buah • 
                                <?php if($row['stok'] > 0): ?>
                                    <span class="text-success fw-bold">Tersedia</span>
                                <?php else: ?>
                                    <span class="text-danger fw-bold">Habis</span>
                                <?php endif; ?>
                            </div>
                            <div class="mob-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
                        </div>
                        <div class="mob-actions">
                            <a href="edit_produk.php?id=<?= $row['id_produk']; ?>" class="btn-action-sm icon-blue d-flex align-items-center justify-content-center"><i class="fa-solid fa-pen"></i></a>
                            <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>" class="btn-action-sm icon-red d-flex align-items-center justify-content-center" style="background:#FDEDEC;" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"><i class="fa-regular fa-trash-can"></i></a>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else: 
                ?>
                    <p class="text-muted text-center py-3">Belum ada produk.</p>
                <?php endif; ?>
            </div>

            <div class="pagination-wrapper">
                <div class="pagination-info">Menampilkan <?= $total_records > 0 ? $offset + 1 : 0; ?>–<?= min($offset + $limit, $total_records); ?> dari <?= $total_records; ?> produk</div>
                <ul class="pagination mb-0">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?= ($page <= 1) ? '#' : htmlspecialchars(getPageUrl($page - 1)); ?>"><i class="fa-solid fa-chevron-left"></i></a>
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
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../../assets/js/admin_kelola_produk.js"></script>
</body>
</html>