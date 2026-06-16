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

    <link href="../assets/css/style_kelola_pesanan.css" rel="stylesheet">
</head>
<body>

    <aside class="sidebar d-none d-lg-flex">
        <a href="#" class="sidebar-brand">
            <div class="icon-bg"><i class="fa-solid fa-bread-slice"></i></div>
            Roti Nusantara <span class="badge-admin">ADMIN</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="index_admin.html"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            <li><a href="tambah_produk.html"><i class="fa-solid fa-box"></i> Kelola Produk</a></li>
            <li><a href="#" class="active"><i class="fa-solid fa-clipboard-list"></i> Kelola Pesanan <span class="badge-notif">5</span></a></li>
        </ul>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="avatar-circle">AD</div>
                <div class="user-details">
                    <h6>Admin</h6><p>admin@rotinusantara.com</p>
                </div>
            </div>
            <a href="login.html" class="btn-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
        </div>
    </aside>

    <main class="main-content">
        
        <header class="top-header" data-aos="fade-down">
            <div class="header-left">
                <button class="btn-menu-mobile d-lg-none"><i class="fa-solid fa-bars"></i></button>
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
                    <div class="stat-value" style="color: var(--primary-color);">47</div>
                    <div class="stat-title">Total Pesanan</div>
                    <div class="stat-desc">Bulan ini</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card border-yellow">
                    <div class="stat-icon bg-yellow-light"><i class="fa-regular fa-clock"></i></div>
                    <div class="stat-value" style="color: var(--color-yellow);">5</div>
                    <div class="stat-title">Menunggu Konfirmasi</div>
                    <div class="stat-desc text-yellow-custom">Perlu ditindaklanjuti</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card border-blue">
                    <div class="stat-icon bg-blue-light"><i class="fa-solid fa-rotate"></i></div>
                    <div class="stat-value" style="color: var(--color-blue);">8</div>
                    <div class="stat-title">Sedang Diproses</div>
                    <div class="stat-desc">Dibayar, menunggu selesai</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card border-green">
                    <div class="stat-icon bg-green-light"><i class="fa-regular fa-circle-check"></i></div>
                    <div class="stat-value" style="color: var(--color-green);">31</div>
                    <div class="stat-title">Pesanan Selesai</div>
                    <div class="stat-desc">Bulan ini</div>
                </div>
            </div>
        </div>

        <div class="admin-card" data-aos="fade-up" data-aos-delay="500">
            
            <div class="filter-section">
                <div class="search-bar">
                    <input type="text" placeholder="Cari ID pesanan atau nama pelanggan...">
                </div>
                <div class="filter-pills">
                    <button class="btn-filter active">Semua <span class="badge-count">47</span></button>
                    <button class="btn-filter">Pending <span class="badge-count">5</span></button>
                    <button class="btn-filter">Dibayar <span class="badge-count">8</span></button>
                    <button class="btn-filter">Selesai <span class="badge-count">31</span></button>
                    <button class="btn-filter">Batal <span class="badge-count">3</span></button>
                </div>
            </div>

            <div class="list-header">
                <h3 class="list-title">Daftar Pesanan <span class="list-subtitle">(8 pesanan)</span></h3>
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
                        <tr>
                            <td class="td-id">#018</td>
                            <td>
                                <div class="customer-info">
                                    <div class="avatar-sm" style="background-color: #E67E22;">AR</div>
                                    <div><div class="prod-title">Anisa Rahma</div><div class="prod-more">anisa@email.com</div></div>
                                </div>
                            </td>
                            <td>
                                <div class="prod-title">Sourdough Artisan</div>
                                <div class="prod-more">+1 lainnya</div>
                            </td>
                            <td class="fw-bold">Rp 130.000</td>
                            <td><span class="status-badge status-dibayar"><i class="fa-solid fa-circle" style="font-size:0.4rem;"></i> Dibayar <i class="fa-solid fa-chevron-down ms-1"></i></span></td>
                            <td>
                                <div class="prod-title">15 Jun 2026</div>
                                <div class="prod-more">14:22 WIB</div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn-action-sm icon-blue"><i class="fa-regular fa-eye"></i></button>
                                    <button class="btn-action-sm icon-orange"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn-action-sm icon-red" style="background:#FDEDEC;"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-id">#017</td>
                            <td>
                                <div class="customer-info">
                                    <div class="avatar-sm" style="background-color: #F39C12;">BS</div>
                                    <div><div class="prod-title">Budi Santoso</div><div class="prod-more">budi@email.com</div></div>
                                </div>
                            </td>
                            <td>
                                <div class="prod-title">Roti Tawar Susu Pre...</div>
                            </td>
                            <td class="fw-bold">Rp 56.000</td>
                            <td><span class="status-badge status-selesai">Selesai</span></td>
                            <td>
                                <div class="prod-title">15 Jun 2026</div>
                                <div class="prod-more">09:10 WIB</div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn-action-sm icon-blue"><i class="fa-regular fa-eye"></i></button>
                                    <button class="btn-action-sm icon-orange"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn-action-sm icon-red" style="background:#FDEDEC;"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-id">#016</td>
                            <td>
                                <div class="customer-info">
                                    <div class="avatar-sm" style="background-color: #9B59B6;">CD</div>
                                    <div><div class="prod-title">Citra Dewi</div><div class="prod-more">citra@email.com</div></div>
                                </div>
                            </td>
                            <td>
                                <div class="prod-title">Croissant Butter...</div>
                                <div class="prod-more">+2 lainnya</div>
                            </td>
                            <td class="fw-bold">Rp 84.000</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>
                                <div class="prod-title">14 Jun 2026</div>
                                <div class="prod-more">18:45 WIB</div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn-action-sm icon-blue"><i class="fa-regular fa-eye"></i></button>
                                    <button class="btn-action-sm icon-orange"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn-action-sm icon-red" style="background:#FDEDEC;"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mobile-list-wrapper">
                
                <div class="mobile-order-card b-blue">
                    <div class="mob-header">
                        <span class="mob-id">#018</span>
                        <span class="status-badge status-dibayar">Dibayar</span>
                    </div>
                    <div class="mob-customer">Anisa Rahma</div>
                    <div class="mob-product">Sourdough Artisan +1 lainnya</div>
                    <div class="mob-footer">
                        <div class="mob-price">Rp 130.000</div>
                        <div class="mob-date">15 Jun 2026</div>
                    </div>
                </div>

                <div class="mobile-order-card b-green">
                    <div class="mob-header">
                        <span class="mob-id">#017</span>
                        <span class="status-badge status-selesai">Selesai</span>
                    </div>
                    <div class="mob-customer">Budi Santoso</div>
                    <div class="mob-product">Roti Tawar Susu Premium</div>
                    <div class="mob-footer">
                        <div class="mob-price">Rp 56.000</div>
                        <div class="mob-date">15 Jun 2026</div>
                    </div>
                </div>

                <div class="mobile-order-card b-yellow">
                    <div class="mob-header">
                        <span class="mob-id">#016</span>
                        <span class="status-badge status-pending">Pending</span>
                    </div>
                    <div class="mob-customer">Citra Dewi</div>
                    <div class="mob-product">Croissant Butter Klasik +2 lainnya</div>
                    <div class="mob-footer">
                        <div class="mob-price">Rp 84.000</div>
                        <div class="mob-date">14 Jun 2026</div>
                    </div>
                </div>

                <div class="mobile-order-card b-red">
                    <div class="mob-header">
                        <span class="mob-id">#015</span>
                        <span class="status-badge status-batal">Batal</span>
                    </div>
                    <div class="mob-customer">Dian Purnama</div>
                    <div class="mob-product">Kue Nastar Nanas</div>
                    <div class="mob-footer">
                        <div class="mob-price">Rp 85.000</div>
                        <div class="mob-date">14 Jun 2026</div>
                    </div>
                </div>

                <div class="mobile-order-card b-green">
                    <div class="mob-header">
                        <span class="mob-id">#014</span>
                        <span class="status-badge status-selesai">Selesai</span>
                    </div>
                    <div class="mob-customer">Eko Prasetyo</div>
                    <div class="mob-product">Pain au Chocolat +1 lainnya</div>
                    <div class="mob-footer">
                        <div class="mob-price">Rp 64.000</div>
                        <div class="mob-date">13 Jun 2026</div>
                    </div>
                </div>
                
                <div class="mobile-order-card b-yellow">
                    <div class="mob-header">
                        <span class="mob-id">#013</span>
                        <span class="status-badge status-pending">Pending</span>
                    </div>
                    <div class="mob-customer">Fitri Handayani</div>
                    <div class="mob-product">Roti Gandum Whole Wheat</div>
                    <div class="mob-footer">
                        <div class="mob-price">Rp 35.000</div>
                        <div class="mob-date">13 Jun 2026</div>
                    </div>
                </div>

                <div class="mobile-order-card b-blue">
                    <div class="mob-header">
                        <span class="mob-id">#012</span>
                        <span class="status-badge status-dibayar">Dibayar</span>
                    </div>
                    <div class="mob-customer">Gilang Ramadhan</div>
                    <div class="mob-product">Cinnamon Roll Kayu Manis</div>
                    <div class="mob-footer">
                        <div class="mob-price">Rp 56.000</div>
                        <div class="mob-date">12 Jun 2026</div>
                    </div>
                </div>

                <div class="mobile-order-card b-green">
                    <div class="mob-header">
                        <span class="mob-id">#011</span>
                        <span class="status-badge status-selesai">Selesai</span>
                    </div>
                    <div class="mob-customer">Hana Pertiwi</div>
                    <div class="mob-product">Roti Keju Mozzarella +1 lainnya</div>
                    <div class="mob-footer">
                        <div class="mob-price">Rp 72.000</div>
                        <div class="mob-date">11 Jun 2026</div>
                    </div>
                </div>

            </div>

            <div class="pagination-area">
                <div class="page-info">Menampilkan 1–8 dari 8 pesanan</div>
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
    
    <script>
        AOS.init({ once: true, offset: 50 });

        // Simple script to toggle active state on filter pills
        const filterPills = document.querySelectorAll('.btn-filter');
        filterPills.forEach(pill => {
            pill.addEventListener('click', function() {
                filterPills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>