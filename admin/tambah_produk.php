<?php
include_once("../config.php");
// Proteksi Admin
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

$q_kategori = mysqli_query($conn, "SELECT * FROM kategori_roti");
$pesanan_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM pesanan WHERE status='pending'"))['cnt'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru - Admin Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="../assets/css/style_tambah_produk.css" rel="stylesheet">
</head>
<body>

    <aside class="sidebar d-none d-lg-flex" id="sidebar">
        <a href="../index.php" class="sidebar-brand">
            <div class="icon-bg"><i class="fa-solid fa-bread-slice"></i></div>
            Roti Nusantara <span class="badge-admin">ADMIN</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            
            <li class="has-submenu">
                <a href="kelola_produk.php" id="toggleProduk">
                    <div class="menu-left"><i class="fa-solid fa-box"></i> Kelola Produk</div>
                    <i class="fa-solid fa-chevron-up" id="iconProduk" style="font-size: 0.7rem;"></i>
                </a>
                <ul class="submenu show" id="submenuProduk">
                    <li><a href="kelola_produk.php"><i class="fa-solid fa-list" style="font-size: 0.65rem; margin-right: 5px;"></i> Daftar Produk</a></li>
                    <li><a href="tambah_produk.php" class="active"><i class="fa-solid fa-plus" style="font-size: 0.65rem; margin-right: 5px;"></i> Tambah Produk</a></li>
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
        
        <header class="top-header">
            <div class="header-left">
                <button class="btn-menu-mobile d-lg-none" id="mobileMenuBtn"><i class="fa-solid fa-bars"></i></button>
                <a href="kelola_produk.php" class="btn-back d-none d-md-flex"><i class="fa-solid fa-arrow-left"></i> Kelola Produk</a>
                <div class="page-title">
                    <h2>Tambah Produk Baru</h2>
                    <p class="d-none d-md-block">Admin &rsaquo; Kelola Produk &rsaquo; Tambah Produk</p>
                </div>
            </div>
            <div class="avatar-circle d-lg-none" style="width:35px; height:35px; font-size:0.8rem;">AD</div>
        </header>

        <form id="productForm" action="proses_tambah_produk.php" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            
            <div class="col-lg-7 col-xl-8">
                
                <div class="admin-card" data-aos="fade-up">
                    <div class="card-header-title">
                        <i class="fa-solid fa-wheat-awn"></i> Informasi Dasar Produk
                    </div>
                        <div class="mb-4">
                            <label class="form-label">Nama Produk <span class="text-asterisk">*</span></label>
                            <input type="text" class="form-control" name="nama_produk" id="inputNama" placeholder="Contoh: Roti Cokelat Premium" maxlength="100">
                            <div class="char-counter"><span id="countNama">0</span>/100</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Kategori Roti <span class="text-asterisk">*</span></label>
                            <select class="form-select" name="id_kategori" id="inputKategori" required>
                                <option value="" selected disabled>Pilih kategori...</option>
                                <?php while($kat = mysqli_fetch_assoc($q_kategori)): ?>
                                    <option value="<?= $kat['id_kategori']; ?>"><?= htmlspecialchars($kat['nama_kategori']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Harga Produk <span class="text-asterisk">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">Rp</span>
                                <input type="number" class="form-control border-start-0 ps-0" name="harga" id="inputHarga" placeholder="0" min="0">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Stok Awal <span class="text-asterisk">*</span></label>
                            <div class="input-stok-group">
                                <button type="button" class="btn-stok" onclick="updateStok(-1)"><i class="fa-solid fa-minus"></i></button>
                                <input type="number" class="input-stok" name="stok" id="inputStok" value="0" min="0">
                                <button type="button" class="btn-stok" onclick="updateStok(1)"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <div class="stok-warning" id="stokWarning">
                                <i class="fa-solid fa-triangle-exclamation"></i> Produk tidak akan tampil di katalog
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control" name="deskripsi" id="inputDeskripsi" rows="4" placeholder="Tuliskan deskripsi produk secara detail..." maxlength="500"></textarea>
                            <div class="char-counter text-end"><span id="countDeskripsi">0</span>/500</div>
                        </div>
                </div>

                <div class="admin-card d-lg-none" data-aos="fade-up">
                    <div class="card-header-title card-header-blue">
                        <i class="fa-solid fa-circle-info"></i> Preview Informasi
                    </div>
                    <ul class="preview-list">
                        <li><span class="preview-label">Nama</span> <span class="preview-value" id="prevNama">—</span></li>
                        <li><span class="preview-label">Kategori</span> <span class="preview-value" id="prevKategori">—</span></li>
                        <li><span class="preview-label">Harga</span> <span class="preview-value" id="prevHarga">Rp 0</span></li>
                        <li><span class="preview-label">Stok</span> <span class="preview-value"><span id="prevStok">0</span> buah</span></li>
                        <li><span class="preview-label">Status</span> <span class="badge-status-preview" id="prevStatus" style="background:#FEE4E2; color:#E74C3C;"><i class="fa-solid fa-xmark"></i> Habis</span></li>
                    </ul>
                </div>

            </div>

            <div class="col-lg-5 col-xl-4">
                
                <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header-title">
                        <i class="fa-regular fa-image"></i> Gambar Produk
                    </div>
                    
                    <div class="drag-drop-area" id="dropZone">
                        <div class="drag-drop-icon"><i class="fa-regular fa-image"></i></div>
                        <p>Drag & drop gambar di sini</p>
                        <p class="text-muted" style="font-size: 0.8rem; margin-bottom: 15px;">atau</p>
                        <button type="button" class="btn-pilih-file" onclick="document.getElementById('fileInput').click()">Pilih File</button>
                        <input type="file" id="fileInput" name="gambar_produk" hidden accept="image/png, image/jpeg, image/webp">
                    </div>
                    <div class="file-format-text">Format: JPG, PNG, WEBP • Maks. 2MB</div>
                </div>

                <div class="admin-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header-title">
                        <i class="fa-solid fa-box-archive"></i> Pengaturan Produk
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-text">
                            <h6>Tampilkan di Katalog</h6>
                            <p>Produk akan muncul di halaman katalog</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleKatalog" name="is_tampil" value="1" checked>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-text">
                            <h6>Tandai sebagai Unggulan</h6>
                            <p>Produk tampil di beranda utama</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleUnggulan" name="is_unggulan" value="1">
                        </div>
                    </div>

                    <div class="setting-item">
                        <div class="setting-text">
                            <h6 class="d-flex align-items-center gap-2"><i class="fa-regular fa-calendar"></i> Tanggal Ditambahkan</h6>
                        </div>
                        <div class="setting-text text-end">
                            <p id="currentDate">16 Jun 2026</p> </div>
                    </div>
                </div>

                <div class="admin-card p-3 d-flex justify-content-between align-items-center" style="cursor: pointer;" data-aos="fade-up" data-aos-delay="300">
                    <div class="d-flex align-items-center gap-2" style="color: var(--primary-color); font-weight: 500;">
                        <i class="fa-regular fa-lightbulb"></i> Tips Pengisian Produk
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: var(--primary-color); font-size: 0.8rem;"></i>
                </div>

            </div>
        </div>
        </form>

    </main>

    <div class="bottom-action-bar">
        <div class="wajib-text"><span>*</span> Wajib diisi</div>
        <div class="action-buttons">
            <a href="kelola_produk.php" class="btn-action btn-batal text-decoration-none d-inline-flex align-items-center justify-content-center">Batal</a>
            <button type="button" class="btn-action btn-draft">Simpan Draft</button>
            <button type="submit" form="productForm" class="btn-action btn-publish">Simpan & Publikasikan</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../assets/js/admin_tambah_produk.js"></script>
</body>
</html>