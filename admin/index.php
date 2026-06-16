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

    <link href="../assets/css/style_index_admin.css" rel="stylesheet">
</head>
<body>

    <aside class="sidebar d-none d-lg-flex">
        <a href="#" class="sidebar-brand">
            <div class="icon-bg"><i class="fa-solid fa-bread-slice"></i></div>
            Roti Nusantara
            <span class="badge-admin">ADMIN</span>
        </a>
        
        <ul class="sidebar-menu">
            <li><a href="#" class="active"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa-solid fa-box-open"></i> Kelola Produk</a></li>
            <li><a href="#"><i class="fa-solid fa-tags"></i> Kategori Produk</a></li>
            <li><a href="#"><i class="fa-solid fa-clipboard-list"></i> Kelola Pesanan <span class="badge-notif">5</span></a></li>
            <li><a href="#"><i class="fa-solid fa-users"></i> Pelanggan</a></li>
            <li><a href="#"><i class="fa-solid fa-chart-line"></i> Laporan</a></li>
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
            <div class="d-flex align-items-center gap-3">
                <button class="btn-icon d-lg-none border-0 shadow-sm"><i class="fa-solid fa-bars"></i></button>
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
                    <div class="stat-value">24</div>
                    <div class="stat-title">Total Produk</div>
                    <div class="stat-trend text-green"><i class="fa-solid fa-arrow-trend-up"></i> +2 produk baru bulan ini</div>
                </div>
            </div>
            <div class="col-6 col-xl-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card border-blue">
                    <div class="stat-icon bg-blue-light"><i class="fa-solid fa-clipboard-list"></i></div>
                    <div class="stat-value">18</div>
                    <div class="stat-title">Pesanan Masuk</div>
                    <div class="stat-trend text-muted-trend">
                        <span style="color:var(--color-yellow);">● 5 pending</span> &nbsp; <span style="color:var(--color-blue);">● 8 dibayar</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card border-yellow">
                    <div class="stat-icon bg-yellow-light"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="stat-value">6</div>
                    <div class="stat-title">Stok Menipis</div>
                    <div class="stat-trend text-muted-trend">Stok ≤ 10 buah</div>
                </div>
            </div>
            <div class="col-6 col-xl-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card border-green">
                    <div class="stat-icon bg-green-light"><i class="fa-solid fa-arrow-trend-up"></i></div>
                    <div class="stat-value">Rp 2,45 jt</div>
                    <div class="stat-title">Pendapatan Bulan Ini</div>
                    <div class="stat-trend text-green"><i class="fa-solid fa-arrow-trend-up"></i> +12% dari bulan lalu</div>
                </div>
            </div>
        </div>

        <div class="action-btn-row" data-aos="fade-up">
            <button class="btn-action btn-action-primary"><i class="fa-solid fa-plus"></i> Tambah Produk</button>
            <button class="btn-action btn-action-outline-blue"><i class="fa-regular fa-clipboard"></i> Lihat Pesanan</button>
            <button class="btn-action btn-action-outline-dark"><i class="fa-solid fa-tags"></i> Tambah Kategori</button>
            <button class="btn-action btn-action-outline-gray"><i class="fa-solid fa-chart-simple"></i> Export Laporan</button>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                
                <div class="dash-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="dash-card-header">
                        <h3 class="dash-card-title">Pesanan Terbaru</h3>
                        <a href="#" class="link-view-all">Lihat Semua <i class="fa-solid fa-chevron-right ms-1"></i></a>
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
                                <tr>
                                    <td class="fw-bold" style="color: var(--primary-color);">#018</td>
                                    <td>
                                        <div class="customer-info">
                                            <div class="avatar-sm" style="background-color: #E67E22;">AR</div>
                                            Anisa Rahma
                                        </div>
                                    </td>
                                    <td class="fw-bold">Rp 84.000</td>
                                    <td class="d-none d-md-table-cell"><span class="badge-status bg-success-subtle">Selesai</span></td>
                                    <td class="d-none d-md-table-cell text-muted">15 Jun 2026</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn-action-sm"><i class="fa-regular fa-eye text-primary"></i></button>
                                            <button class="btn-action-sm"><i class="fa-solid fa-pen text-warning"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: var(--primary-color);">#017</td>
                                    <td>
                                        <div class="customer-info">
                                            <div class="avatar-sm" style="background-color: #F39C12;">BS</div>
                                            Budi Santoso
                                        </div>
                                    </td>
                                    <td class="fw-bold">Rp 46.000</td>
                                    <td class="d-none d-md-table-cell"><span class="badge-status" style="background:#FEF9E7; color:#F1C40F;">Pending</span></td>
                                    <td class="d-none d-md-table-cell text-muted">15 Jun 2026</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn-action-sm"><i class="fa-regular fa-eye text-primary"></i></button>
                                            <button class="btn-action-sm"><i class="fa-solid fa-pen text-warning"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: var(--primary-color);">#016</td>
                                    <td>
                                        <div class="customer-info">
                                            <div class="avatar-sm" style="background-color: #9B59B6;">CD</div>
                                            Citra Dewi
                                        </div>
                                    </td>
                                    <td class="fw-bold">Rp 130.000</td>
                                    <td class="d-none d-md-table-cell"><span class="badge-status" style="background:#EBF5FB; color:#3498DB;">Dibayar</span></td>
                                    <td class="d-none d-md-table-cell text-muted">14 Jun 2026</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn-action-sm"><i class="fa-regular fa-eye text-primary"></i></button>
                                            <button class="btn-action-sm"><i class="fa-solid fa-pen text-warning"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="dash-card d-none d-lg-block" data-aos="fade-up" data-aos-delay="200">
                    <div class="dash-card-header">
                        <h3 class="dash-card-title">Aktivitas Terbaru</h3>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="avatar-sm bg-orange-light"><i class="fa-solid fa-box"></i></div>
                            <div>
                                <p class="m-0 font-weight-500">Produk 'Roti Cokelat Premium' berhasil ditambahkan.</p>
                                <small class="text-muted">2 menit lalu</small>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <div class="avatar-sm bg-success-subtle"><i class="fa-solid fa-check"></i></div>
                            <div>
                                <p class="m-0 font-weight-500">Pesanan #018 status diubah ke Selesai.</p>
                                <small class="text-muted">15 menit lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="dash-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="dash-card-header">
                        <h3 class="dash-card-title text-warning"><i class="fa-solid fa-triangle-exclamation me-2"></i> Stok Perlu Diisi</h3>
                    </div>
                    
                    <div class="stock-item">
                        <div class="stock-info">
                            <span>Croissant Butter</span>
                            <span>8 buah</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 20%"></div>
                        </div>
                    </div>
                    
                    <div class="stock-item">
                        <div class="stock-info">
                            <span>Pain au Chocolat</span>
                            <span>6 buah</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 15%"></div>
                        </div>
                    </div>

                    <div class="stock-item">
                        <div class="stock-info">
                            <span>Roti Keju Mozzarella</span>
                            <span>9 buah</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 25%"></div>
                        </div>
                    </div>
                    
                    <a href="#" class="link-view-all d-block mt-3 text-center">Lihat Semua Produk <i class="fa-solid fa-chevron-right ms-1"></i></a>
                </div>

                <div class="dash-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="dash-card-header mb-0">
                        <h3 class="dash-card-title">Ringkasan Pesanan</h3>
                    </div>
                    <div class="ringkasan-wrapper d-flex align-items-center mt-3">
                        <div class="chart-container" style="width: 140px; height: 140px;">
                            <canvas id="orderChart"></canvas>
                            <div class="chart-center-text">
                                <h3>18</h3>
                                <p>pesanan</p>
                            </div>
                        </div>
                        <div class="chart-legends">
                            <div class="legend-item"><div class="dot bg-success"></div> Selesai (5)</div>
                            <div class="legend-item"><div class="dot" style="background:#3498DB;"></div> Dibayar (8)</div>
                            <div class="legend-item"><div class="dot" style="background:#F1C40F;"></div> Pending (5)</div>
                            <div class="legend-item"><div class="dot bg-danger"></div> Batal (0)</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <nav class="bottom-nav">
        <a href="#" class="bottom-nav-item active">
            <i class="fa-solid fa-border-all"></i>
            <span>Dashboard</span>
        </a>
        <a href="#" class="bottom-nav-item">
            <i class="fa-solid fa-box"></i>
            <span>Produk</span>
        </a>
        <a href="#" class="bottom-nav-item">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Pesanan</span>
        </a>
        <a href="#" class="bottom-nav-item">
            <i class="fa-solid fa-tags"></i>
            <span>Kategori</span>
        </a>
        <a href="#" class="bottom-nav-item">
            <i class="fa-regular fa-user"></i>
            <span>Menu</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Init Animate On Scroll
        AOS.init({ once: true, offset: 50 });

        // Chart.js Configuration
        const ctx = document.getElementById('orderChart').getContext('2d');
        const orderChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Dibayar', 'Pending', 'Batal'],
                datasets: [{
                    data: [5, 8, 5, 0],
                    backgroundColor: [
                        '#2ECC71', // Green
                        '#3498DB', // Blue
                        '#F1C40F', // Yellow
                        '#E74C3C'  // Red
                    ],
                    borderWidth: 0,
                    cutout: '75%' // Membuat lubang donat lebih besar untuk teks di tengah
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legend bawaan, pakai custom HTML legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + ' pesanan';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>