<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roti Tawar Susu Premium - Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="assets/css/style_detail_produk.css" rel="stylesheet">
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
                    <li class="nav-item"><a class="nav-link" href="index.html">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="katalog.html">Katalog</a></li>
                </ul>
                <a href="login.html" class="btn btn-outline-primary-custom d-none d-lg-block">Masuk</a>
            </div>
        </div>
    </nav>

    <div class="container mt-2">
        
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                <li class="breadcrumb-item"><a href="katalog.html">Katalog</a></li>
                <li class="breadcrumb-item active" aria-current="page">Roti Tawar Susu Premium</li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5">
            
            <div class="col-lg-6" data-aos="fade-right">
                <div class="main-image-wrapper">
                    <span class="badge-kategori-img">Roti Tawar</span>
                    <span class="badge-status-img"><i class="fa-solid fa-check"></i> Tersedia</span>
                    <img id="mainImage" src="https://images.unsplash.com/photo-1598373182133-52452f7691ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Roti Tawar Susu Premium">
                </div>
                <div class="thumbnail-container">
                    <img src="https://images.unsplash.com/photo-1598373182133-52452f7691ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" class="thumbnail active" onclick="changeImage(this)" alt="Thumb 1">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" class="thumbnail" onclick="changeImage(this)" alt="Thumb 2">
                    <img src="https://images.unsplash.com/photo-1614088463870-7634f19b6d85?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" class="thumbnail" onclick="changeImage(this)" alt="Thumb 3">
                    <img src="https://images.unsplash.com/photo-1549931319-a545dcf3bc73?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" class="thumbnail" onclick="changeImage(this)" alt="Thumb 4">
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                
                <span class="product-badge-text">Roti Tawar</span>
                <h1 class="product-title">Roti Tawar Susu Premium</h1>
                
                <div class="rating-box">
                    <div class="stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span class="rating-text">4.8</span>
                    <span class="review-count">(24 ulasan)</span>
                </div>

                <div class="product-price">
                    Rp 28.000 <span class="price-unit">/ buah</span>
                </div>
                
                <div class="stock-status">
                    <i class="fa-solid fa-box-open"></i> Stok tersedia: 45 buah
                </div>

                <div class="product-desc-short">
                    <strong>Deskripsi Produk</strong><br>
                    Tekstur lembut dengan aroma susu segar yang menggugah selera, cocok untuk sarapan keluarga. Setiap produk Roti Nusantara dibuat dengan standar kualitas tinggi menggunakan bahan-bahan pilihan yang segar dan alami. Dipanggang setiap hari... <a href="#details" class="link-more">Selengkapnya ></a>
                </div>

                <div class="action-box">
                    <label class="qty-label">Jumlah</label>
                    <div class="qty-selector">
                        <button class="btn-qty" onclick="updateQty(-1)">-</button>
                        <input type="text" class="input-qty" id="qtyInput" value="1" readonly>
                        <button class="btn-qty" onclick="updateQty(1)">+</button>
                    </div>

                    <div class="total-box">
                        <span class="total-label">Total Pembayaran</span>
                        <span class="total-price" id="totalPrice">Rp 28.000</span>
                    </div>

                    <button class="btn-pesan"><i class="fa-solid fa-cart-shopping"></i> Pesan Sekarang</button>
                    <button class="btn-wa"><i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp</button>
                </div>

                <div class="share-actions">
                    Bagikan: 
                    <button class="btn-share"><i class="fa-regular fa-copy"></i> Salin Link</button>
                    <button class="btn-share"><i class="fa-solid fa-share-nodes"></i> Bagikan</button>
                </div>

            </div>
        </div>

        <div class="details-section" id="details" data-aos="fade-up">
            
            <div class="nav-tabs-custom">
                <div class="nav-item-custom active">Deskripsi</div>
                <div class="nav-item-custom">Informasi</div>
                <div class="nav-item-custom">Ulasan (24)</div>
            </div>

            <div class="tab-content-area">
                <p class="tab-content-text">
                    Produk unggulan Roti Nusantara yang dibuat dengan cinta menggunakan bahan-bahan berkualitas tinggi. Setiap tahap produksi kami jaga dengan ketat untuk memastikan rasa dan tekstur yang konsisten sempurna setiap harinya. Roti tawar ini sangat cocok disajikan dengan selai favorit Anda atau dipanggang untuk sarapan yang hangat.
                </p>

                <h6 class="fw-bold mb-3">Bahan-bahan:</h6>
                <ul class="ingredients-list">
                    <li>Tepung terigu premium</li>
                    <li>Susu segar full cream</li>
                    <li>Ragi alami</li>
                    <li>Gula tebu</li>
                    <li>Mentega tawar</li>
                    <li>Garam laut</li>
                    <li>Telur ayam kampung</li>
                </ul>

                <h6 class="fw-bold mb-3 mt-4">Informasi Nutrisi (per sajian):</h6>
                <div class="nutrition-grid">
                    <div class="nutrition-card">
                        <div class="nutrition-icon icon-fire"><i class="fa-solid fa-fire"></i></div>
                        <p class="nutrition-val">180 kkal</p>
                        <p class="nutrition-label">Kalori</p>
                    </div>
                    <div class="nutrition-card">
                        <div class="nutrition-icon icon-muscle"><i class="fa-solid fa-dumbbell"></i></div>
                        <p class="nutrition-val">6 g</p>
                        <p class="nutrition-label">Protein</p>
                    </div>
                    <div class="nutrition-card">
                        <div class="nutrition-icon icon-wheat"><i class="fa-solid fa-wheat-awn"></i></div>
                        <p class="nutrition-val">32 g</p>
                        <p class="nutrition-label">Karbohidrat</p>
                    </div>
                    <div class="nutrition-card">
                        <div class="nutrition-icon icon-drop"><i class="fa-solid fa-droplet"></i></div>
                        <p class="nutrition-val">4 g</p>
                        <p class="nutrition-label">Lemak</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="related-products mb-5" data-aos="fade-up">
            <div class="section-title-box">
                <h3 class="section-title">Produk Lainnya dari Kategori Ini</h3>
                <div class="slider-nav">
                    <button class="btn-slider"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="btn-slider"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" class="card product-card">
                        <div class="product-img-wrapper">
                            <span class="badge-status">Tersedia</span>
                            <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Roti Gandum">
                        </div>
                        <div class="product-body">
                            <h5 class="product-title-card">Roti Gandum Whole Wheat</h5>
                            <p class="product-price-card">Rp 35.000</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="#" class="card product-card">
                        <div class="product-img-wrapper">
                            <span class="badge-status">Tersedia</span>
                            <img src="https://images.unsplash.com/photo-1614088463870-7634f19b6d85?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Roti Pandan">
                        </div>
                        <div class="product-body">
                            <h5 class="product-title-card">Roti Tawar Pandan</h5>
                            <p class="product-price-card">Rp 30.000</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 d-none d-md-block">
                    <a href="#" class="card product-card">
                        <div class="product-img-wrapper">
                            <span class="badge-status">Tersedia</span>
                            <img src="https://images.unsplash.com/photo-1549931319-a545dcf3bc73?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Roti Sisir">
                        </div>
                        <div class="product-body">
                            <h5 class="product-title-card">Roti Sisir Mentega</h5>
                            <p class="product-price-card">Rp 25.000</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="sticky-bottom-bar">
        <div class="sticky-content container">
            <div class="sticky-prod-info">
                <img src="https://images.unsplash.com/photo-1598373182133-52452f7691ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="sticky-img" alt="Thumb">
                <div class="sticky-text">
                    <h6>Roti Tawar Susu Premium</h6>
                    <p id="stickyPriceText">Rp 28.000</p>
                </div>
            </div>
            
            <div class="sticky-actions">
                <div class="sticky-qty-selector">
                    <button class="sticky-btn-qty" onclick="updateQty(-1)">-</button>
                    <input type="text" class="sticky-input-qty" id="stickyQtyInput" value="1" readonly>
                    <button class="sticky-btn-qty" onclick="updateQty(1)">+</button>
                </div>
                <button class="btn btn-pesan m-0" style="padding: 10px 20px;">Pesan</button>
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
                        <li><a href="index.html">Beranda</a></li>
                        <li><a href="katalog.html">Katalog</a></li>
                        <li><a href="login.html">Masuk</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                Dibuat dengan <i class="fa-solid fa-heart" style="color: #e74c3c;"></i> sebagai proyek bakery lokal Indonesia
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Init AOS
        AOS.init({ once: true, offset: 30 });

        // Logic Ganti Gambar Utama dari Thumbnail
        function changeImage(element) {
            // Hapus class active dari semua thumbnail
            document.querySelectorAll('.thumbnail').forEach(img => img.classList.remove('active'));
            // Tambah active ke thumbnail yang di-klik
            element.classList.add('active');
            // Ganti src gambar utama
            document.getElementById('mainImage').src = element.src;
        }

        // Logic Kuantitas & Harga
        const basePrice = 28000;
        let currentQty = 1;

        function updateQty(change) {
            let newQty = currentQty + change;
            if(newQty >= 1 && newQty <= 45) { // Maksimal stok
                currentQty = newQty;
                
                // Update input desktop & mobile
                document.getElementById('qtyInput').value = currentQty;
                document.getElementById('stickyQtyInput').value = currentQty;
                
                // Hitung dan update total harga
                let totalPrice = basePrice * currentQty;
                let formattedPrice = 'Rp ' + totalPrice.toLocaleString('id-ID');
                
                document.getElementById('totalPrice').innerText = formattedPrice;
                document.getElementById('stickyPriceText').innerText = formattedPrice;
            }
        }
    </script>
</body>
</html>