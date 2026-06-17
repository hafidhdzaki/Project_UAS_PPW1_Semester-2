<?php
include_once("../../includes/config.php");
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') { header('Location: ../../index.php'); exit(); }

// Action Update Status
if (isset($_GET['action']) && $_GET['action'] == 'update_status') {
    $id_pesanan = (int)$_GET['id'];
    $status_baru = mysqli_real_escape_string($conn, $_GET['status']);
    if (in_array($status_baru, ['pending', 'dibayar', 'selesai', 'batal'])) {
        mysqli_query($conn, "UPDATE pesanan SET status = '$status_baru' WHERE id_pesanan = '$id_pesanan'");
    }
    header('Location: kelola_pesanan.php');
    exit();
}

// Query JOIN Pesanan dan User + Subquery GROUP_CONCAT untuk detail item produk
$q_pesanan = mysqli_query($conn, "
    SELECT p.*, u.nama_lengkap, u.email,
           (SELECT GROUP_CONCAT(CONCAT(pr.nama_produk, ' (', dp.jumlah_beli, ')') SEPARATOR ', ')
            FROM detail_pesanan dp
            JOIN produk_roti pr ON dp.id_produk = pr.id_produk
            WHERE dp.id_pesanan = p.id_pesanan) as daftar_produk
    FROM pesanan p
    JOIN users u ON p.id_user = u.id_user
    ORDER BY p.tanggal_pesanan DESC
");

// Hitung statistik pesanan
$stat_total = mysqli_num_rows($q_pesanan);
$stat_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status='pending'"))['total'];
$stat_dibayar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status='dibayar'"))['total'];
$stat_selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status='selesai'"))['total'];
$stat_batal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status='batal'"))['total'];
$pesanan_pending = $stat_pending;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - Admin Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="../../assets/css/style_kelola_pesanan.css" rel="stylesheet">
</head>
<body>

    <aside class="sidebar d-none d-lg-flex" id="sidebar">
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
                    <li><a href="kelola_produk.php"><i class="fa-solid fa-list" style="font-size: 0.65rem; margin-right: 5px;"></i> Daftar Produk</a></li>
                    <li><a href="tambah_produk.php"><i class="fa-solid fa-plus" style="font-size: 0.65rem; margin-right: 5px;"></i> Tambah Produk</a></li>
                    <li><a href="kelola_kategori.php"><i class="fa-solid fa-tags" style="font-size: 0.65rem; margin-right: 5px;"></i> Kel. Kategori</a></li>
                </ul>
            </li>

            <li><a href="kelola_pesanan.php" class="active"><i class="fa-solid fa-clipboard-list"></i> Kelola Pesanan <?php if($pesanan_pending > 0): ?><span class="badge-notif"><?= $pesanan_pending; ?></span><?php endif; ?></a></li>
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
                    <h2>Kelola Pesanan</h2>
                    <p>Admin &rsaquo; Kelola Pesanan</p>
                </div>
            </div>
            <div class="avatar-circle d-lg-none" style="width:35px; height:35px; font-size:0.8rem;">AD</div>
            <div class="avatar-circle d-none d-lg-flex">AD</div>
        </header>

        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card border-orange">
                    <div class="stat-icon bg-orange-light"><i class="fa-solid fa-clipboard-list"></i></div>
                    <div class="stat-value" style="color: var(--primary-color);"><?= $stat_total; ?></div>
                    <div class="stat-title">Total Pesanan</div>
                    <div class="stat-desc">Semua waktu</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card border-yellow">
                    <div class="stat-icon bg-yellow-light"><i class="fa-regular fa-clock"></i></div>
                    <div class="stat-value" style="color: var(--color-yellow);"><?= $stat_pending; ?></div>
                    <div class="stat-title">Menunggu Konfirmasi</div>
                    <div class="stat-desc text-yellow-custom">Perlu ditindaklanjuti</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card border-blue">
                    <div class="stat-icon bg-blue-light"><i class="fa-solid fa-rotate"></i></div>
                    <div class="stat-value" style="color: var(--color-blue);"><?= $stat_dibayar; ?></div>
                    <div class="stat-title">Sedang Diproses</div>
                    <div class="stat-desc">Dibayar, menunggu selesai</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card border-green">
                    <div class="stat-icon bg-green-light"><i class="fa-regular fa-circle-check"></i></div>
                    <div class="stat-value" style="color: var(--color-green);"><?= $stat_selesai; ?></div>
                    <div class="stat-title">Pesanan Selesai</div>
                    <div class="stat-desc">Sudah terkirim</div>
                </div>
            </div>
        </div>

        <div class="admin-card" data-aos="fade-up" data-aos-delay="500">
            
            <div class="filter-section">
                <div class="search-bar">
                    <input type="text" placeholder="Cari ID pesanan atau nama pelanggan...">
                </div>
                <div class="filter-pills">
                    <button class="btn-filter active">Semua <span class="badge-count"><?= $stat_total; ?></span></button>
                    <button class="btn-filter">Pending <span class="badge-count"><?= $stat_pending; ?></span></button>
                    <button class="btn-filter">Dibayar <span class="badge-count"><?= $stat_dibayar; ?></span></button>
                    <button class="btn-filter">Selesai <span class="badge-count"><?= $stat_selesai; ?></span></button>
                    <button class="btn-filter">Batal <span class="badge-count"><?= $stat_batal; ?></span></button>
                </div>
            </div>

            <div class="list-header">
                <h3 class="list-title">Daftar Pesanan <span class="list-subtitle">(<?= $stat_total; ?> pesanan)</span></h3>
                <button class="btn-export"><i class="fa-solid fa-download"></i> Export <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.7rem;"></i></button>
            </div>

            <div class="desktop-table-wrapper table-responsive">
                <table class="table table-borderless table-pesanan mb-0">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($q_pesanan)): ?>
                        <tr>
                            <td class="td-id">#<?= str_pad($row['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td>
                                <div class="customer-info">
                                    <div class="avatar-sm" style="background-color: var(--primary-color);"><?= strtoupper(substr($row['nama_lengkap'],0,2)); ?></div>
                                    <div>
                                        <div class="prod-title"><?= htmlspecialchars($row['nama_lengkap']); ?></div>
                                        <div class="prod-more"><?= htmlspecialchars($row['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="prod-title text-muted" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($row['daftar_produk']); ?>">
                                    <?= htmlspecialchars($row['daftar_produk'] ? $row['daftar_produk'] : 'Tidak ada produk'); ?>
                                </div>
                            </td>
                            <td class="fw-bold">Rp <?= number_format($row['total_pembayaran'],0,',','.'); ?></td>
                            <td>
                                <?php if($row['status'] == 'pending'): ?>
                                    <span class="status-badge status-pending">Pending</span>
                                <?php elseif($row['status'] == 'dibayar'): ?>
                                    <span class="status-badge status-dibayar">Dibayar</span>
                                <?php elseif($row['status'] == 'selesai'): ?>
                                    <span class="status-badge status-selesai">Selesai</span>
                                <?php else: ?>
                                    <span class="status-badge status-batal">Batal</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="prod-title"><?= date('d M Y', strtotime($row['tanggal_pesanan'])); ?></div>
                                <div class="prod-more"><?= date('H:i', strtotime($row['tanggal_pesanan'])); ?> WIB</div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <?php if ($row['bukti_bayar']): ?>
                                        <a href="../../<?= htmlspecialchars($row['bukti_bayar']); ?>" target="_blank" class="btn-action-sm icon-blue d-flex align-items-center justify-content-center" title="Lihat Bukti Transfer">
                                            <i class="fa-regular fa-image"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($row['status'] == 'pending'): ?>
                                        <a href="kelola_pesanan.php?action=update_status&id=<?= $row['id_pesanan']; ?>&status=dibayar" class="btn-action-sm text-success d-flex align-items-center justify-content-center" style="background:#D1FADF;" title="Tandai Dibayar"><i class="fa-solid fa-check"></i></a>
                                        <a href="kelola_pesanan.php?action=update_status&id=<?= $row['id_pesanan']; ?>&status=batal" class="btn-action-sm text-danger d-flex align-items-center justify-content-center" style="background:#FEE4E2;" onclick="return confirm('Batalkan pesanan ini?');" title="Batalkan Pesanan"><i class="fa-solid fa-xmark"></i></a>
                                    <?php elseif ($row['status'] == 'dibayar'): ?>
                                        <a href="kelola_pesanan.php?action=update_status&id=<?= $row['id_pesanan']; ?>&status=selesai" class="btn-action-sm text-primary d-flex align-items-center justify-content-center" style="background:#EBF5FB;" title="Tandai Selesai"><i class="fa-solid fa-circle-check"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="mobile-list-wrapper">
                <?php 
                mysqli_data_seek($q_pesanan, 0);
                if (mysqli_num_rows($q_pesanan) > 0):
                    while($row = mysqli_fetch_assoc($q_pesanan)):
                        $border_color = 'b-yellow';
                        if ($row['status'] == 'dibayar') $border_color = 'b-blue';
                        elseif ($row['status'] == 'selesai') $border_color = 'b-green';
                        elseif ($row['status'] == 'batal') $border_color = 'b-red';
                ?>
                    <div class="mobile-order-card <?= $border_color; ?>">
                        <div class="mob-header">
                            <span class="mob-id">#<?= str_pad($row['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></span>
                            <?php if($row['status'] == 'pending'): ?>
                                <span class="status-badge status-pending">Pending</span>
                            <?php elseif($row['status'] == 'dibayar'): ?>
                                <span class="status-badge status-dibayar">Dibayar</span>
                            <?php elseif($row['status'] == 'selesai'): ?>
                                <span class="status-badge status-selesai">Selesai</span>
                            <?php else: ?>
                                <span class="status-badge status-batal">Batal</span>
                            <?php endif; ?>
                        </div>
                        <div class="mob-customer"><?= htmlspecialchars($row['nama_lengkap']); ?></div>
                        <div class="mob-product text-truncate" title="<?= htmlspecialchars($row['daftar_produk']); ?>"><?= htmlspecialchars($row['daftar_produk'] ? $row['daftar_produk'] : 'Tidak ada produk'); ?></div>
                        <div class="mob-footer">
                            <div class="mob-price">Rp <?= number_format($row['total_pembayaran'], 0, ',', '.'); ?></div>
                            <div class="mob-date"><?= date('d M Y', strtotime($row['tanggal_pesanan'])); ?></div>
                        </div>
                        <div class="mt-2 d-flex gap-2">
                            <?php if ($row['bukti_bayar']): ?>
                                <a href="../../<?= htmlspecialchars($row['bukti_bayar']); ?>" target="_blank" class="btn btn-sm btn-outline-primary" style="font-size:0.8rem; border-radius: 6px;"><i class="fa-regular fa-image me-1"></i> Bukti</a>
                            <?php endif; ?>
                            <?php if ($row['status'] == 'pending'): ?>
                                <a href="kelola_pesanan.php?action=update_status&id=<?= $row['id_pesanan']; ?>&status=dibayar" class="btn btn-sm btn-success flex-grow-1" style="font-size:0.8rem; border-radius: 6px;"><i class="fa-solid fa-check"></i> Dibayar</a>
                                <a href="kelola_pesanan.php?action=update_status&id=<?= $row['id_pesanan']; ?>&status=batal" class="btn btn-sm btn-danger" style="font-size:0.8rem; border-radius: 6px;" onclick="return confirm('Batalkan pesanan ini?');"><i class="fa-solid fa-xmark"></i></a>
                            <?php elseif ($row['status'] == 'dibayar'): ?>
                                <a href="kelola_pesanan.php?action=update_status&id=<?= $row['id_pesanan']; ?>&status=selesai" class="btn btn-sm btn-primary flex-grow-1" style="font-size:0.8rem; border-radius: 6px;"><i class="fa-solid fa-circle-check"></i> Selesai</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else: 
                ?>
                    <p class="text-muted text-center py-3">Belum ada pesanan.</p>
                <?php endif; ?>
            </div>

            <div class="pagination-area">
                <div class="page-info">Menampilkan 1–<?= $stat_total; ?> dari <?= $stat_total; ?> pesanan</div>
                <ul class="pagination">
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                </ul>
            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../../assets/js/admin_kelola_pesanan.js"></script>
</body>
</html>