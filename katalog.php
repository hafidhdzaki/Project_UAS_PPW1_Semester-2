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
            <a class="navbar-brand" href="index.html">
                <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Katalog</a></li>
                </ul>
                <a href="login.php" class="btn-outline-primary-custom d-none d-lg-block">Masuk</a>
            </div>
        </div>
    </nav>

    <section class="page-header">
        <div class="container" data-aos="fade-up">
            <h1>Katalog Produk</h1>
            <p>Temukan roti favoritmu di sini</p>
            <div class="breadcrumb-custom">
                <a href="index.html">Beranda</a> <span><i class="fa-solid fa-chevron-right" style="font-size:0.7rem;"></i></span> Katalog
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
                    
                    <div class="offcanvas-body flex-column p-0 p-lg-1">
                        
                        <div class="mb-4">
                            <h6 class="filter-section-title">Kategori</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat1">
                                <label class="form-check-label" for="cat1">Roti Tawar</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat2">
                                <label class="form-check-label" for="cat2">Roti Manis</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat3">
                                <label class="form-check-label" for="cat3">Roti Gurih</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat4">
                                <label class="form-check-label" for="cat4">Kue Kering</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="filter-section-title">Rentang Harga</h6>
                            <div class="range-slider-wrapper">
                                <input type="range" class="form-range" min="0" max="100000" step="5000" id="priceRange" style="accent-color: var(--primary-color);">
                                <div class="range-values">
                                    <span>Rp 0</span>
                                    <span class="fw-bold text-dark" id="priceValue">Rp 100.000</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="filter-section-title">Status Stok</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="stock1" checked>
                                <label class="form-check-label" for="stock1">Tersedia</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="stock2">
                                <label class="form-check-label" for="stock2">Hampir Habis</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="stock3">
                                <label class="form-check-label" for="stock3">Habis</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                            <button class="btn-reset"><i class="fa-solid fa-rotate-right me-1"></i> Reset Filter</button>
                            <button class="btn btn-primary" style="background-color: var(--primary-color); border:none; border-radius:8px;">Terapkan</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-9 pt-4 pt-lg-0">
                
                <div class="d-flex gap-2 mb-3">
                    <div class="search-container">
                        <input type="search" placeholder="Cari nama roti...">
                    </div>
                    <button class="btn-filter-mobile d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                        <i class="fa-solid fa-sliders"></i> Filter
                    </button>
                </div>

                <div class="category-scroll-wrapper mb-4">
                    <a href="#" class="cat-pill active">Semua</a>
                    <a href="#" class="cat-pill">Roti Tawar</a>
                    <a href="#" class="cat-pill">Roti Manis</a>
                    <a href="#" class="cat-pill">Roti Gurih</a>
                    <a href="#" class="cat-pill">Kue Kering</a>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    
                    <div class="col" data-aos="fade-up" data-aos-delay="100">
                        <div class="card product-card">
                            <div class="product-img-wrapper">
                                <span class="badge-kategori">Roti Tawar</span>
                                <span class="badge-status bg-tersedia"><i class="fa-solid fa-check"></i> Tersedia</span>
                                <span class="badge-baru">BARU</span>
                                <img src="https://images.unsplash.com/photo-1598373182133-52452f7691ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Roti Tawar Pandan">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">Roti Tawar Pandan</h3>
                                <p class="product-desc">Aroma pandan segar yang harum dengan tekstur sangat lembut, ciri khas cita rasa Nusantara.</p>
                                <div class="mt-auto">
                                    <div class="product-price">Rp 30.000</div>
                                    <button class="btn-card-action"><i class="fa-regular fa-eye me-1"></i> Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col" data-aos="fade-up" data-aos-delay="150">
                        <div class="card product-card">
                            <div class="product-img-wrapper">
                                <span class="badge-kategori">Roti Gurih</span>
                                <span class="badge-status bg-habis"><i class="fa-solid fa-xmark"></i> Habis</span>
                                <img src="https://images.unsplash.com/photo-1589367920969-ab8e050eb0e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Baguette">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">Baguette Prancis</h3>
                                <p class="product-desc">Baguette autentik gaya Prancis dengan kulit renyah dan bagian dalam yang lembut dan berongga.</p>
                                <div class="mt-auto">
                                    <div class="product-price">Rp 42.000</div>
                                    <button class="btn-card-action disabled"><i class="fa-regular fa-clock me-1"></i> Tidak Tersedia</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col" data-aos="fade-up" data-aos-delay="200">
                        <div class="card product-card">
                            <div class="product-img-wrapper">
                                <span class="badge-kategori">Kue Kering</span>
                                <span class="badge-status bg-tersedia"><i class="fa-solid fa-check"></i> Tersedia</span>
                                <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Kastengel">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">Kastengel Keju Gouda</h3>
                                <p class="product-desc">Stik keju renyah dengan keju Gouda pilihan, gurih sempurna dan lumer di dalam mulut.</p>
                                <div class="mt-auto">
                                    <div class="product-price">Rp 75.000</div>
                                    <button class="btn-card-action"><i class="fa-regular fa-eye me-1"></i> Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col" data-aos="fade-up" data-aos-delay="250">
                        <div class="card product-card">
                            <div class="product-img-wrapper">
                                <span class="badge-kategori">Roti Gurih</span>
                                <span class="badge-status bg-hampir-habis"><i class="fa-solid fa-fire"></i> Hampir Habis</span>
                                <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Roti Keju">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">Roti Keju Mozzarella</h3>
                                <p class="product-desc">Keju mozzarella segar yang meleleh di dalam roti gurih hangat, cocok untuk sarapan.</p>
                                <div class="mt-auto">
                                    <div class="product-price">Rp 24.000</div>
                                    <button class="btn-card-action"><i class="fa-regular fa-eye me-1"></i> Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col" data-aos="fade-up" data-aos-delay="300">
                        <div class="card product-card">
                            <div class="product-img-wrapper">
                                <span class="badge-kategori">Roti Manis</span>
                                <span class="badge-status bg-tersedia"><i class="fa-solid fa-check"></i> Tersedia</span>
                                <span class="badge-baru">BARU</span>
                                <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Cinnamon Roll">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">Cinnamon Roll Kayu Manis</h3>
                                <p class="product-desc">Gulungan manis dengan kayu manis Ceylon dan frosting cream cheese yang melimpah.</p>
                                <div class="mt-auto">
                                    <div class="product-price">Rp 28.000</div>
                                    <button class="btn-card-action"><i class="fa-regular fa-eye me-1"></i> Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col" data-aos="fade-up" data-aos-delay="350">
                        <div class="card product-card">
                            <div class="product-img-wrapper">
                                <span class="badge-kategori">Roti Tawar</span>
                                <span class="badge-status bg-tersedia"><i class="fa-solid fa-check"></i> Tersedia</span>
                                <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Roti Gandum">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">Roti Gandum Whole Wheat</h3>
                                <p class="product-desc">Pilihan sehat dari biji gandum utuh, kaya serat dan nutrisi alami untuk gaya hidup aktif.</p>
                                <div class="mt-auto">
                                    <div class="product-price">Rp 35.000</div>
                                    <button class="btn-card-action"><i class="fa-regular fa-eye me-1"></i> Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <a href="index.html" class="footer-brand">
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