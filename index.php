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
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="katalog.php">Katalog</a></li>
                </ul>
                <a href="login.php" class="btn btn-outline-primary-custom d-none d-lg-block">Masuk</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="hero-title">Roti Segar<br>Setiap Hari</h1>
                    <p class="hero-text">Pesan roti favoritmu dengan mudah. Dibuat dengan cinta, dikirim ke pintu rumahmu.</p>
                    <a href="#" class="btn btn-hero">Lihat Katalog <i class="fa-solid fa-chevron-right ms-2"></i></a>
                    
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
        
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card product-card">
                    <div class="product-img-wrapper">
                        <span class="badge-status bg-tersedia"><i class="fa-solid fa-check-circle me-1"></i> Tersedia</span>
                        <img src="https://images.unsplash.com/photo-1598373182133-52452f7691ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Roti Tawar">
                    </div>
                    <div class="product-body">
                        <p class="product-category">Roti Tawar</p>
                        <h5 class="product-title">Roti Tawar Susu Premium</h5>
                        <p class="product-desc">Tekstur lembut dengan aroma susu segar yang menggugah selera, cocok untuk sarapan keluarga.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <h4 class="product-price">Rp 28.000</h4>
                            <button class="btn btn-detail">Lihat Detail</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card product-card">
                    <div class="product-img-wrapper">
                        <span class="badge-status bg-hampir-habis"><i class="fa-solid fa-clock me-1"></i> Hampir Habis</span>
                        <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Croissant">
                    </div>
                    <div class="product-body">
                        <p class="product-category">Roti Manis</p>
                        <h5 class="product-title">Croissant Butter Klasik</h5>
                        <p class="product-desc">Berlapis-lapis dengan butter Prancis pilihan, renyah di luar lembut di dalam.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <h4 class="product-price">Rp 22.000</h4>
                            <button class="btn btn-detail">Lihat Detail</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card product-card">
                    <div class="product-img-wrapper">
                        <span class="badge-status bg-tersedia"><i class="fa-solid fa-check-circle me-1"></i> Tersedia</span>
                        <img src="https://images.unsplash.com/photo-1589367920969-ab8e050eb0e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sourdough">
                    </div>
                    <div class="product-body">
                        <p class="product-category">Roti Gurih</p>
                        <h5 class="product-title">Sourdough Artisan</h5>
                        <p class="product-desc">Fermentasi alami 24 jam, kulit renyah dengan crumb yang chewy dan sempurna.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <h4 class="product-price">Rp 45.000</h4>
                            <button class="btn btn-detail">Lihat Detail</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card product-card">
                    <div class="product-img-wrapper">
                        <span class="badge-status bg-habis"><i class="fa-solid fa-times-circle me-1"></i> Habis</span>
                        <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Donut">
                    </div>
                    <div class="product-body">
                        <p class="product-category">Roti Manis</p>
                        <h5 class="product-title">Roti Pisang Coklat</h5>
                        <p class="product-desc">Paduan pisang matang dan coklat premium, sarapan favoritmu setiap pagi.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <h4 class="product-price">Rp 18.000</h4>
                            <button class="btn btn-detail disabled">Lihat Detail</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card product-card">
                    <div class="product-img-wrapper">
                        <span class="badge-status bg-tersedia"><i class="fa-solid fa-check-circle me-1"></i> Tersedia</span>
                        <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Cookies">
                    </div>
                    <div class="product-body">
                        <p class="product-category">Kue Kering</p>
                        <h5 class="product-title">Kue Nastar Nanas</h5>
                        <p class="product-desc">Selai nanas segar dibungkus adonan renyah, tekstur sempurna di setiap gigitan.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <h4 class="product-price">Rp 85.000</h4>
                            <button class="btn btn-detail">Lihat Detail</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card product-card">
                    <div class="product-img-wrapper">
                        <span class="badge-status bg-hampir-habis"><i class="fa-solid fa-clock me-1"></i> Hampir Habis</span>
                        <img src="https://images.unsplash.com/photo-1603532648955-039310d9ed75?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Pain au Chocolat">
                    </div>
                    <div class="product-body">
                        <p class="product-category">Roti Manis</p>
                        <h5 class="product-title">Pain au Chocolat</h5>
                        <p class="product-desc">Pastry Paris yang otentik dengan coklat dark premium di setiap lapisan adonan.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <h4 class="product-price">Rp 32.000</h4>
                            <button class="btn btn-detail">Lihat Detail</button>
                        </div>
                    </div>
                </div>
            </div>

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
                        <li><a href="#">Katalog</a></li>
                        <li><a href="#">Masuk</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                Dibuat dengan <i class="fa-solid fa-heart" style="color: #e74c3c;"></i> sebagai proyek bakery lokal Indonesia
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.css"></script>
    
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