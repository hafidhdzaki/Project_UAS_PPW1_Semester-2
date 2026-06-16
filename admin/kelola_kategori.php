<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Admin Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="../assets/css/style_kelola_kategori.css" rel="stylesheet">
</head>
<body>

    <aside class="sidebar d-none d-lg-flex" id="sidebar">
        <a href="#" class="sidebar-brand">
            <div class="icon-bg"><i class="fa-solid fa-bread-slice"></i></div>
            Roti Nusantara <span class="badge-admin">ADMIN</span>
        </a>
        
        <ul class="sidebar-menu">
            <li>
                <a href="index_admin.html"><i class="fa-solid fa-border-all"></i> Dashboard</a>
            </li>
            
            <li class="has-submenu">
                <a href="#" id="toggleProduk">
                    <div class="menu-left"><i class="fa-solid fa-box"></i> Kelola Produk</div>
                    <i class="fa-solid fa-chevron-up" id="iconProduk" style="font-size: 0.7rem;"></i>
                </a>
                <ul class="submenu show" id="submenuProduk">
                    <li><a href="tambah_produk.html"><i class="fa-solid fa-plus" style="font-size: 0.65rem; margin-right: 5px;"></i> Tambah Produk</a></li>
                    <li><a href="#" class="active"><i class="fa-solid fa-tags" style="font-size: 0.65rem; margin-right: 5px;"></i> Kel. Kategori</a></li>
                </ul>
            </li>

            <li>
                <a href="kelola_pesanan.html"><i class="fa-solid fa-clipboard-list"></i> Kelola Pesanan <span class="badge-notif">5</span></a>
            </li>
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
            <button class="btn-menu-mobile d-lg-none" id="mobileMenuBtn"><i class="fa-solid fa-bars"></i></button>
            <div class="page-title">
                <h2>Kelola Kategori</h2>
                <p>Admin &rsaquo; Kelola Kategori</p>
            </div>
        </header>

        <div class="row g-4">
            
            <div class="col-lg-7 col-xl-8" data-aos="fade-up" data-aos-delay="100">
                <div class="admin-card">
                    <div class="card-header-flex">
                        <h3 class="card-title">Daftar Kategori</h3>
                        <span class="badge-kategori-count">4 kategori</span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless table-kategori mb-0">
                            <thead>
                                <tr>
                                    <th class="td-no">NO</th>
                                    <th>NAMA KATEGORI</th>
                                    <th>JUMLAH PRODUK</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="td-no">1</td>
                                    <td class="td-name">Roti Tawar</td>
                                    <td><span class="badge-produk">4 produk</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn-action btn-edit"><i class="fa-solid fa-pen"></i> Edit</button>
                                            <button class="btn-action btn-hapus"><i class="fa-regular fa-trash-can"></i> Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-no">2</td>
                                    <td class="td-name">Roti Manis</td>
                                    <td><span class="badge-produk">5 produk</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn-action btn-edit"><i class="fa-solid fa-pen"></i> Edit</button>
                                            <button class="btn-action btn-hapus"><i class="fa-regular fa-trash-can"></i> Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-no">3</td>
                                    <td class="td-name">Roti Gurih</td>
                                    <td><span class="badge-produk">3 produk</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn-action btn-edit"><i class="fa-solid fa-pen"></i> Edit</button>
                                            <button class="btn-action btn-hapus"><i class="fa-regular fa-trash-can"></i> Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-no">4</td>
                                    <td class="td-name">Kue Kering</td>
                                    <td><span class="badge-produk">2 produk</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn-action btn-edit"><i class="fa-solid fa-pen"></i> Edit</button>
                                            <button class="btn-action btn-hapus"><i class="fa-regular fa-trash-can"></i> Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-xl-4" data-aos="fade-up" data-aos-delay="200">
                <div class="admin-card card-form">
                    <div class="card-form-title">
                        <i class="fa-solid fa-tag"></i> Tambah Kategori Baru
                    </div>
                    
                    <form action="#">
                        <div class="mb-1">
                            <label class="form-label">Nama Kategori <span class="text-asterisk">*</span></label>
                            <input type="text" class="form-control" id="inputKategori" placeholder="Contoh: Roti Tawar" maxlength="50" required>
                        </div>
                        <div class="char-counter"><span id="charCount">0</span>/50</div>

                        <button type="submit" class="btn-submit mt-3">
                            <i class="fa-regular fa-floppy-disk"></i> Simpan Kategori
                        </button>
                    </form>

                    <div class="tips-box">
                        <i class="fa-regular fa-lightbulb"></i> <strong>Tips:</strong> Gunakan nama yang jelas dan singkat. Kategori digunakan untuk mengelompokkan produk di katalog.
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Inisialisasi Animasi AOS
        AOS.init({ once: true, offset: 50 });

        // Logic Perhitungan Konter Karakter Input
        const inputKategori = document.getElementById('inputKategori');
        const charCount = document.getElementById('charCount');
        inputKategori.addEventListener('input', function() {
            charCount.innerText = this.value.length;
        });

        // Logic Buka-Tutup Submenu Kelola Produk
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