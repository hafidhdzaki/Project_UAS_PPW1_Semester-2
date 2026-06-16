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

    <link href="../assets/css/style_kelola_produk.css" rel="stylesheet">
</head>
<body>

    <aside class="sidebar d-none d-lg-flex" id="sidebar">
        <a href="#" class="sidebar-brand">
            <div class="icon-bg"><i class="fa-solid fa-bread-slice"></i></div>
            Roti Nusantara <span class="badge-admin">ADMIN</span>
        </a>
        
        <ul class="sidebar-menu">
            <li><a href="index_admin.html"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            
            <li class="has-submenu">
                <a href="#" id="toggleProduk">
                    <div class="menu-left"><i class="fa-solid fa-box"></i> Kelola Produk</div>
                    <i class="fa-solid fa-chevron-up" id="iconProduk" style="font-size: 0.7rem;"></i>
                </a>
                <ul class="submenu show" id="submenuProduk">
                    <li><a href="#" class="active"><i class="fa-solid fa-list" style="font-size: 0.65rem; margin-right: 5px;"></i> Daftar Produk</a></li>
                    <li><a href="tambah_produk.html"><i class="fa-solid fa-plus" style="font-size: 0.65rem; margin-right: 5px;"></i> Tambah Produk</a></li>
                    <li><a href="kelola_kategori.html"><i class="fa-solid fa-tags" style="font-size: 0.65rem; margin-right: 5px;"></i> Kel. Kategori</a></li>
                </ul>
            </li>

            <li><a href="kelola_pesanan.html"><i class="fa-solid fa-clipboard-list"></i> Kelola Pesanan <span class="badge-notif">5</span></a></li>
        </ul>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="avatar-circle">AD</div>
                <div class="user-details">
                    <h6>Admin Utama</h6>
                    <p>admin@rotinusantara.com</p>
                </div>
            </div>
            <a href="login.html" class="btn-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
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
                    <div class="stat-value">24</div>
                    <div class="stat-title">Total Produk</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-green">
                    <div class="stat-value">22</div>
                    <div class="stat-title">Produk Aktif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-red">
                    <div class="stat-value">2</div>
                    <div class="stat-title">Stok Habis</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-blue">
                    <div class="stat-value">5</div>
                    <div class="stat-title">Produk Unggulan</div>
                </div>
            </div>
        </div>

        <div class="admin-card" data-aos="fade-up" data-aos-delay="200">
            
            <div class="control-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari nama produk...">
                </div>
                <a href="tambah_produk.html" class="btn-add-product">
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
                        <tr>
                            <td class="text-muted">1</td>
                            <td>
                                <img src="https://images.unsplash.com/photo-1598373182133-52452f7691ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="img-thumbnail-custom" alt="Roti">
                            </td>
                            <td>
                                <p class="product-name-td">Roti Tawar Susu Premium</p>
                                <span class="product-sku-td">SKU: RT-001</span>
                            </td>
                            <td>Roti Tawar</td>
                            <td class="fw-bold">Rp 28.000</td>
                            <td>42 buah</td>
                            <td><span class="status-badge status-tersedia">Tersedia</span></td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="#" class="btn-action-sm icon-blue" title="Edit Produk"><i class="fa-solid fa-pen"></i></a>
                                    <button class="btn-action-sm icon-red" style="background:#FDEDEC;" title="Hapus Produk"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">2</td>
                            <td>
                                <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="img-thumbnail-custom" alt="Roti">
                            </td>
                            <td>
                                <p class="product-name-td">Croissant Butter Klasik</p>
                                <span class="product-sku-td">SKU: RM-002</span>
                            </td>
                            <td>Roti Manis</td>
                            <td class="fw-bold">Rp 22.000</td>
                            <td>8 buah</td>
                            <td><span class="status-badge status-menipis">Hampir Habis</span></td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="#" class="btn-action-sm icon-blue"><i class="fa-solid fa-pen"></i></a>
                                    <button class="btn-action-sm icon-red" style="background:#FDEDEC;"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">3</td>
                            <td>
                                <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="img-thumbnail-custom" alt="Roti">
                            </td>
                            <td>
                                <p class="product-name-td">Roti Pisang Coklat</p>
                                <span class="product-sku-td">SKU: RM-004</span>
                            </td>
                            <td>Roti Manis</td>
                            <td class="fw-bold">Rp 18.000</td>
                            <td>0 buah</td>
                            <td><span class="status-badge status-habis">Habis</span></td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="#" class="btn-action-sm icon-blue"><i class="fa-solid fa-pen"></i></a>
                                    <button class="btn-action-sm icon-red" style="background:#FDEDEC;"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mobile-list-wrapper">
                <div class="mobile-product-card">
                    <img src="https://images.unsplash.com/photo-1598373182133-52452f7691ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="mob-img" alt="Roti">
                    <div class="mob-details">
                        <div class="mob-title">Roti Tawar Susu Premium</div>
                        <div class="mob-meta">Stok: 42 buah • <span class="text-success fw-bold">Tersedia</span></div>
                        <div class="mob-price">Rp 28.000</div>
                    </div>
                    <div class="mob-actions">
                        <a href="#" class="btn-action-sm icon-blue"><i class="fa-solid fa-pen"></i></a>
                        <button class="btn-action-sm icon-red" style="background:#FDEDEC;"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>

                <div class="mobile-product-card">
                    <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="mob-img" alt="Roti">
                    <div class="mob-details">
                        <div class="mob-title">Croissant Butter Klasik</div>
                        <div class="mob-meta">Stok: 8 buah • <span class="text-warning fw-bold">Menipis</span></div>
                        <div class="mob-price">Rp 22.000</div>
                    </div>
                    <div class="mob-actions">
                        <a href="#" class="btn-action-sm icon-blue"><i class="fa-solid fa-pen"></i></a>
                        <button class="btn-action-sm icon-red" style="background:#FDEDEC;"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>

                <div class="mobile-product-card">
                    <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="mob-img" alt="Roti">
                    <div class="mob-details">
                        <div class="mob-title">Roti Pisang Coklat</div>
                        <div class="mob-meta">Stok: 0 buah • <span class="text-danger fw-bold">Habis</span></div>
                        <div class="mob-price">Rp 18.000</div>
                    </div>
                    <div class="mob-actions">
                        <a href="#" class="btn-action-sm icon-blue"><i class="fa-solid fa-pen"></i></a>
                        <button class="btn-action-sm icon-red" style="background:#FDEDEC;"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>
            </div>

            <div class="pagination-wrapper">
                <div class="pagination-info">Menampilkan 1-3 dari 24 produk</div>
                <ul class="pagination mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                </ul>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Init AOS Animation
        AOS.init({ once: true, offset: 50 });

        // Logic Filter Pills Active State
        const pills = document.querySelectorAll('.btn-pill');
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Buka Tutup Submenu Sidebar
        const toggleProduk = document.getElementById('toggleProduk');
        const submenuProduk = document.getElementById('submenuProduk');
        const iconProduk = document.getElementById('iconProduk');

        toggleProduk.addEventListener('click', function(e) {
            e.preventDefault();
            submenuProduk.classList.toggle('show');
            if(submenuProduk.classList.contains('show')) {
                iconProduk.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                iconProduk.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        });
    </script>
</body>
</html>