<?php
include_once("../../includes/config.php");
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php'); exit();
}

// 1. Hitung total produk
$q_total_produk = mysqli_query($conn, "SELECT COUNT(id_produk) as total FROM produk_roti");
$total_produk = mysqli_fetch_assoc($q_total_produk)['total'];

// 2. Hitung pelanggan
$q_total_user = mysqli_query($conn, "SELECT COUNT(id_user) as total FROM users WHERE role='pelanggan'");
$total_user = mysqli_fetch_assoc($q_total_user)['total'];

// 3. Hitung stok menipis (stok <= 10)
$q_stok_menipis = mysqli_query($conn, "SELECT COUNT(id_produk) as total FROM produk_roti WHERE stok <= 10");
$stok_menipis = mysqli_fetch_assoc($q_stok_menipis)['total'];

// 4. Hitung total pendapatan (pesanan status selesai)
$q_pendapatan = mysqli_query($conn, "SELECT SUM(total_pembayaran) as total FROM pesanan WHERE status='selesai'");
$total_pendapatan = mysqli_fetch_assoc($q_pendapatan)['total'];
if (!$total_pendapatan) $total_pendapatan = 0;

// 5. Hitung total pesanan
$q_pesanan_total = mysqli_query($conn, "SELECT COUNT(id_pesanan) as total FROM pesanan");
$pesanan_total = mysqli_fetch_assoc($q_pesanan_total)['total'];

// 6. Hitung pesanan pending
$q_pending = mysqli_query($conn, "SELECT COUNT(id_pesanan) as total FROM pesanan WHERE status='pending'");
$pesanan_pending = mysqli_fetch_assoc($q_pending)['total'];

// 7. Hitung pesanan dibayar
$q_dibayar = mysqli_query($conn, "SELECT COUNT(id_pesanan) as total FROM pesanan WHERE status='dibayar'");
$pesanan_dibayar = mysqli_fetch_assoc($q_dibayar)['total'];

// 8. Hitung pesanan selesai
$q_selesai = mysqli_query($conn, "SELECT COUNT(id_pesanan) as total FROM pesanan WHERE status='selesai'");
$pesanan_selesai = mysqli_fetch_assoc($q_selesai)['total'];

// 9. Hitung pesanan batal
$q_batal = mysqli_query($conn, "SELECT COUNT(id_pesanan) as total FROM pesanan WHERE status='batal'");
$pesanan_batal = mysqli_fetch_assoc($q_batal)['total'];

// 10. Ambil pesanan terbaru (limit 3)
$q_pesanan_terbaru = mysqli_query($conn, "
    SELECT p.*, u.nama_lengkap 
    FROM pesanan p 
    JOIN users u ON p.id_user = u.id_user 
    ORDER BY p.tanggal_pesanan DESC 
    LIMIT 3
");

// 11. Ambil stok menipis (limit 3)
$q_low_stock = mysqli_query($conn, "
    SELECT * FROM produk_roti 
    WHERE stok <= 10 
    ORDER BY stok ASC 
    LIMIT 3
");

// 12. Query untuk Aktivitas Terbaru (2 pesanan terbaru, 1 produk terbaru, 1 pelanggan terbaru)
$q_act_orders = mysqli_query($conn, "
    SELECT p.id_pesanan, p.status, p.tanggal_pesanan, u.nama_lengkap 
    FROM pesanan p
    JOIN users u ON p.id_user = u.id_user
    ORDER BY p.tanggal_pesanan DESC LIMIT 2
");

$q_act_product = mysqli_query($conn, "
    SELECT nama_produk 
    FROM produk_roti 
    ORDER BY id_produk DESC LIMIT 1
");

$q_act_user = mysqli_query($conn, "
    SELECT nama_lengkap 
    FROM users 
    WHERE role='pelanggan' 
    ORDER BY id_user DESC LIMIT 1
");

$activities = [];

if ($q_act_orders) {
    while ($ord = mysqli_fetch_assoc($q_act_orders)) {
        $id_fmt = str_pad($ord['id_pesanan'], 4, '0', STR_PAD_LEFT);
        $time = date('d M Y, H:i', strtotime($ord['tanggal_pesanan']));
        $timestamp = strtotime($ord['tanggal_pesanan']);
        
        if ($ord['status'] == 'pending') {
            $desc = "Pesanan baru <strong>#{$id_fmt}</strong> dari <strong>" . htmlspecialchars($ord['nama_lengkap']) . "</strong> masuk (Pending).";
            $icon = "fa-solid fa-clipboard-list";
            $class = "bg-yellow-light text-warning";
        } elseif ($ord['status'] == 'dibayar') {
            $desc = "Pembayaran untuk pesanan <strong>#{$id_fmt}</strong> (<strong>" . htmlspecialchars($ord['nama_lengkap']) . "</strong>) telah diterima.";
            $icon = "fa-solid fa-credit-card";
            $class = "bg-blue-light text-info";
        } elseif ($ord['status'] == 'selesai') {
            $desc = "Pesanan <strong>#{$id_fmt}</strong> (<strong>" . htmlspecialchars($ord['nama_lengkap']) . "</strong>) telah selesai diproses.";
            $icon = "fa-solid fa-circle-check";
            $class = "bg-success-subtle text-success";
        } else {
            $desc = "Pesanan <strong>#{$id_fmt}</strong> (<strong>" . htmlspecialchars($ord['nama_lengkap']) . "</strong>) dibatalkan.";
            $icon = "fa-solid fa-circle-xmark";
            $class = "bg-danger-subtle text-danger";
        }
        
        $activities[] = [
            'desc' => $desc,
            'time' => $time,
            'timestamp' => $timestamp,
            'icon' => $icon,
            'class' => $class
        ];
    }
}

if ($q_act_product && mysqli_num_rows($q_act_product) > 0) {
    $prod = mysqli_fetch_assoc($q_act_product);
    $activities[] = [
        'desc' => "Produk baru <strong>'" . htmlspecialchars($prod['nama_produk']) . "'</strong> berhasil ditambahkan.",
        'time' => "Baru-baru ini",
        'timestamp' => time() - 3600,
        'icon' => "fa-solid fa-box",
        'class' => "bg-orange-light text-warning"
    ];
}

if ($q_act_user && mysqli_num_rows($q_act_user) > 0) {
    $usr = mysqli_fetch_assoc($q_act_user);
    $activities[] = [
        'desc' => "Pelanggan baru <strong>" . htmlspecialchars($usr['nama_lengkap']) . "</strong> telah bergabung.",
        'time' => "Baru-baru ini",
        'timestamp' => time() - 7200,
        'icon' => "fa-solid fa-user-plus",
        'class' => "bg-blue-light text-primary"
    ];
}

// Urutkan aktivitas berdasarkan timestamp DESC
usort($activities, function($a, $b) {
    return $b['timestamp'] - $a['timestamp'];
});
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="../../assets/css/style_index_admin.css" rel="stylesheet">
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <a href="../../index.php" class="sidebar-brand">
            <div class="icon-bg"><i class="fa-solid fa-bread-slice"></i></div>
            Roti Nusantara <span class="badge-admin">ADMIN</span>
        </a>
        
        <ul class="sidebar-menu">
            <li><a href="index.php" class="active"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            <li class="has-submenu">
                <a href="#" id="toggleProduk">
                    <div class="menu-left"><i class="fa-solid fa-box"></i>  Kelola Produk</div>
                    <i class="fa-solid fa-chevron-up" id="iconProduk" style="font-size: 0.7rem;"></i>
                </a>
                <ul class="submenu show" id="submenuProduk" style="list-style-type: none;">
                    <li><a href="kelola_produk.php"><i class="fa-solid fa-list" style="font-size: 0.65rem; margin-right: 5px;"></i> Daftar Produk</a></li>
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
            <div class="d-flex align-items-center gap-3">
                <button class="btn-icon d-lg-none border-0 shadow-sm" id="mobileMenuBtn"><i class="fa-solid fa-bars"></i></button>
                <div class="page-title">
                    <h2>Dashboard</h2>
                    <p>Admin &rsaquo; Dashboard</p>
                </div>
            </div>
            
            <div class="header-actions">
                <div class="search-bar d-none d-md-block">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari produk, pesanan...">
                </div>
                <div class="btn-icon">
                    <i class="fa-regular fa-bell"></i>
                    <span class="notif-dot">3</span>
                </div>
                <div class="btn-icon px-3 w-auto d-none d-md-flex gap-2">
                    <div class="avatar-circle" style="width: 25px; height: 25px; font-size: 0.7rem;">AD</div>
                    <span style="font-weight: 500; font-size: 0.9rem;">Admin</span> <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                </div>
            </div>
        </header>

        <div class="row g-4 mb-4">
            <div class="col-6 col-xl-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card border-orange">
                    <div class="stat-icon bg-orange-light"><i class="fa-solid fa-box"></i></div>
                    <div class="stat-value"><?= $total_produk; ?></div>
                    <div class="stat-title">Total Produk</div>
                    <div class="stat-trend text-green">Dalam Database</div>
                </div>
            </div>
            <div class="col-6 col-xl-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card border-blue">
                    <div class="stat-icon bg-blue-light"><i class="fa-solid fa-clipboard-list"></i></div>
                    <div class="stat-value"><?= $pesanan_total; ?></div>
                    <div class="stat-title">Pesanan Masuk</div>
                    <div class="stat-trend text-muted-trend">
                        <span style="color:var(--color-yellow);">● <?= $pesanan_pending; ?> pending</span> &nbsp; <span style="color:var(--color-blue);">● <?= $pesanan_dibayar; ?> dibayar</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card border-yellow">
                    <div class="stat-icon bg-yellow-light"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="stat-value"><?= $stok_menipis; ?></div>
                    <div class="stat-title">Stok Menipis</div>
                    <div class="stat-trend text-muted-trend">Stok ≤ 10 buah</div>
                </div>
            </div>
            <div class="col-6 col-xl-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card border-green">
                    <div class="stat-icon bg-green-light"><i class="fa-solid fa-arrow-trend-up"></i></div>
                    <div class="stat-value">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></div>
                    <div class="stat-title">Total Pendapatan</div>
                    <div class="stat-trend text-green">Pesanan Selesai</div>
                </div>
            </div>
        </div>

        <div class="action-btn-row" data-aos="fade-up">
            <a href="tambah_produk.php" class="btn-action btn-action-primary text-decoration-none"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
            <a href="kelola_pesanan.php" class="btn-action btn-action-outline-blue text-decoration-none"><i class="fa-regular fa-clipboard"></i> Lihat Pesanan</a>
            <a href="kelola_kategori.php" class="btn-action btn-action-outline-dark text-decoration-none"><i class="fa-solid fa-tags"></i> Tambah Kategori</a>
            <button class="btn-action btn-action-outline-gray"><i class="fa-solid fa-chart-simple"></i> Export Laporan</button>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                
                <div class="dash-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="dash-card-header">
                        <h3 class="dash-card-title">Pesanan Terbaru</h3>
                        <a href="kelola_pesanan.php" class="link-view-all">Lihat Semua <i class="fa-solid fa-chevron-right ms-1"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-pesanan align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th class="d-none d-md-table-cell">Status</th>
                                    <th class="d-none d-md-table-cell">Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($q_pesanan_terbaru) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($q_pesanan_terbaru)): ?>
                                        <tr>
                                            <td class="fw-bold" style="color: var(--primary-color);">#<?= str_pad($row['id_pesanan'], 3, '0', STR_PAD_LEFT); ?></td>
                                            <td>
                                                <div class="customer-info">
                                                    <div class="avatar-sm" style="background-color: #E67E22;"><?= strtoupper(substr($row['nama_lengkap'], 0, 2)); ?></div>
                                                    <?= htmlspecialchars($row['nama_lengkap']); ?>
                                                </div>
                                            </td>
                                            <td class="fw-bold">Rp <?= number_format($row['total_pembayaran'], 0, ',', '.'); ?></td>
                                            <td class="d-none d-md-table-cell">
                                                <?php if($row['status'] == 'pending'): ?>
                                                    <span class="badge-status" style="background:#FEF9E7; color:#F1C40F;">Pending</span>
                                                <?php elseif($row['status'] == 'dibayar'): ?>
                                                    <span class="badge-status" style="background:#EBF5FB; color:#3498DB;">Dibayar</span>
                                                <?php elseif($row['status'] == 'selesai'): ?>
                                                    <span class="badge-status bg-success-subtle">Selesai</span>
                                                <?php else: ?>
                                                    <span class="badge-status bg-danger-subtle text-danger">Batal</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="d-none d-md-table-cell text-muted"><?= date('d M Y', strtotime($row['tanggal_pesanan'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="kelola_pesanan.php" class="btn-action-sm text-decoration-none d-flex align-items-center justify-content-center"><i class="fa-regular fa-eye text-primary"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Belum ada pesanan masuk.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="dash-card d-none d-lg-block" data-aos="fade-up" data-aos-delay="200">
                    <div class="dash-card-header">
                        <h3 class="dash-card-title">Aktivitas Terbaru</h3>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <?php if(!empty($activities)): ?>
                            <?php foreach($activities as $act): ?>
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="avatar-sm <?= $act['class']; ?>"><i class="<?= $act['icon']; ?>"></i></div>
                                    <div>
                                        <p class="m-0 font-weight-500"><?= $act['desc']; ?></p>
                                        <small class="text-muted"><?= $act['time']; ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">Belum ada aktivitas terbaru.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="dash-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="dash-card-header">
                        <h3 class="dash-card-title text-warning"><i class="fa-solid fa-triangle-exclamation me-2"></i> Stok Perlu Diisi</h3>
                    </div>
                    
                    <?php if (mysqli_num_rows($q_low_stock) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($q_low_stock)): 
                            $pct = min(100, max(5, intval(($row['stok'] / 10) * 100)));
                            $bg_class = ($row['stok'] == 0) ? 'bg-danger' : 'bg-warning';
                        ?>
                            <div class="stock-item">
                                <div class="stock-info">
                                    <span><?= htmlspecialchars($row['nama_produk']); ?></span>
                                    <span><?= $row['stok']; ?> buah</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar <?= $bg_class; ?>" style="width: <?= $pct; ?>%"></div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted text-center py-3">Semua stok produk aman.</p>
                    <?php endif; ?>
                    
                    <a href="kelola_produk.php" class="link-view-all d-block mt-3 text-center">Lihat Semua Produk <i class="fa-solid fa-chevron-right ms-1"></i></a>
                </div>

                <div class="dash-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="dash-card-header mb-0">
                        <h3 class="dash-card-title">Ringkasan Pesanan</h3>
                    </div>
                    <div class="ringkasan-wrapper d-flex align-items-center mt-3">
                        <div class="chart-container" style="position: relative; width: 140px; height: 140px;">
                            <canvas id="orderChart" 
                                    data-selesai="<?= $pesanan_selesai; ?>" 
                                    data-dibayar="<?= $pesanan_dibayar; ?>" 
                                    data-pending="<?= $pesanan_pending; ?>" 
                                    data-batal="<?= $pesanan_batal; ?>"></canvas>
                            <div class="chart-center-text">
                                <h3><?= $pesanan_total; ?></h3>
                                <p>pesanan</p>
                            </div>
                        </div>
                        <div class="chart-legends">
                            <div class="legend-item"><div class="dot bg-success"></div> Selesai (<?= $pesanan_selesai; ?>)</div>
                            <div class="legend-item"><div class="dot" style="background:#3498DB;"></div> Dibayar (<?= $pesanan_dibayar; ?>)</div>
                            <div class="legend-item"><div class="dot" style="background:#F1C40F;"></div> Pending (<?= $pesanan_pending; ?>)</div>
                            <div class="legend-item"><div class="dot bg-danger"></div> Batal (<?= $pesanan_batal; ?>)</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../assets/js/admin_index.js"></script>
</body>
</html>