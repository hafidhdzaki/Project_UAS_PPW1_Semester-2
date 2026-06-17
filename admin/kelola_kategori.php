<?php
include_once("../config.php");
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') { header('Location: ../index.php'); exit(); }

// Logika Hapus Kategori
if (isset($_GET['delete'])) {
    $id_del = (int)$_GET['delete'];
    // Jika masih ada produk dengan kategori ini, kita tidak boleh menghapusnya untuk menjaga FK relasi!
    $cek_produk = mysqli_query($conn, "SELECT id_produk FROM produk_roti WHERE id_kategori = '$id_del'");
    if (mysqli_num_rows($cek_produk) > 0) {
        echo "<script>alert('Gagal menghapus kategori! Kategori ini masih memiliki produk aktif.'); window.location='kelola_kategori.php';</script>";
    } else {
        mysqli_query($conn, "DELETE FROM kategori_roti WHERE id_kategori = '$id_del'");
        header('Location: kelola_kategori.php');
    }
    exit();
}

// Logika Edit (Ambil Data Kategori)
$edit_mode = false;
$edit_id = 0;
$edit_name = "";
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = (int)$_GET['edit'];
    $q_edit = mysqli_query($conn, "SELECT * FROM kategori_roti WHERE id_kategori = '$edit_id'");
    if (mysqli_num_rows($q_edit) > 0) {
        $edit_data = mysqli_fetch_assoc($q_edit);
        $edit_name = $edit_data['nama_kategori'];
    }
}

// Logika Simpan (Tambah / Edit Kategori)
if(isset($_POST['simpan_kategori'])) {
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    if (isset($_POST['id_kategori_edit']) && !empty($_POST['id_kategori_edit'])) {
        $id_edit = (int)$_POST['id_kategori_edit'];
        mysqli_query($conn, "UPDATE kategori_roti SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_edit'");
    } else {
        mysqli_query($conn, "INSERT INTO kategori_roti (nama_kategori) VALUES ('$nama_kategori')");
    }
    header('Location: kelola_kategori.php');
    exit();
}

// Query Tampil Kategori beserta Jumlah Produknya
$q_kat = mysqli_query($conn, "SELECT k.*, (SELECT COUNT(id_produk) FROM produk_roti WHERE id_kategori = k.id_kategori) as jml_produk FROM kategori_roti k");
$pesanan_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM pesanan WHERE status='pending'"))['cnt'];
$kategori_count = mysqli_num_rows($q_kat);
?>
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
                <a href="index.php"><i class="fa-solid fa-border-all"></i> Dashboard</a>
            </li>
            
            <li class="has-submenu">
                <a href="#" id="toggleProduk">
                    <div class="menu-left"><i class="fa-solid fa-box"></i> Kelola Produk</div>
                    <i class="fa-solid fa-chevron-up" id="iconProduk" style="font-size: 0.7rem;"></i>
                </a>
                <ul class="submenu show" id="submenuProduk">
                    <li><a href="kelola_produk.php"><i class="fa-solid fa-list" style="font-size: 0.65rem; margin-right: 5px;"></i> Daftar Produk</a></li>
                    <li><a href="tambah_produk.php"><i class="fa-solid fa-plus" style="font-size: 0.65rem; margin-right: 5px;"></i> Tambah Produk</a></li>
                    <li><a href="kelola_kategori.php" class="active"><i class="fa-solid fa-tags" style="font-size: 0.65rem; margin-right: 5px;"></i> Kel. Kategori</a></li>
                </ul>
            </li>

            <li>
                <a href="kelola_pesanan.php"><i class="fa-solid fa-clipboard-list"></i> Kelola Pesanan <?php if($pesanan_pending > 0): ?><span class="badge-notif"><?= $pesanan_pending; ?></span><?php endif; ?></a>
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
            <a href="../logout.php" class="btn-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
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
                        <span class="badge-kategori-count"><?= $kategori_count; ?> kategori</span>
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
                                <?php $no=1; while($row = mysqli_fetch_assoc($q_kat)): ?>
                                <tr>
                                    <td class="td-no"><?= $no++; ?></td>
                                    <td class="td-name"><?= htmlspecialchars($row['nama_kategori']); ?></td>
                                    <td><span class="badge-produk"><?= $row['jml_produk']; ?> produk</span></td>
                                    <td>
                                        <a href="kelola_kategori.php?edit=<?= $row['id_kategori']; ?>" class="btn-action btn-edit text-decoration-none d-inline-flex align-items-center justify-content-center" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                        <a href="kelola_kategori.php?delete=<?= $row['id_kategori']; ?>" class="btn-action btn-hapus text-decoration-none d-inline-flex align-items-center justify-content-center" style="background:#FDEDEC;" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" title="Hapus"><i class="fa-regular fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-xl-4" data-aos="fade-up" data-aos-delay="200">
                <div class="admin-card card-form">
                    <div class="card-form-title">
                        <i class="fa-solid fa-tag"></i> <?= $edit_mode ? 'Edit Kategori' : 'Tambah Kategori Baru'; ?>
                    </div>
                    
                    <form action="" method="POST">
                        <?php if ($edit_mode): ?>
                            <input type="hidden" name="id_kategori_edit" value="<?= $edit_id; ?>">
                        <?php endif; ?>
                        
                        <div class="mb-1">
                            <label class="form-label">Nama Kategori <span class="text-asterisk">*</span></label>
                            <input type="text" class="form-control" name="nama_kategori" id="inputKategori" placeholder="Contoh: Roti Tawar" maxlength="50" value="<?= htmlspecialchars($edit_name); ?>" required>
                        </div>
                        <div class="char-counter"><span id="charCount">0</span>/50</div>

                        <div class="d-flex gap-2">
                            <button type="submit" name="simpan_kategori" class="btn-submit mt-3 flex-grow-1">
                                <i class="fa-regular fa-floppy-disk"></i> Simpan Kategori
                            </button>
                            <?php if ($edit_mode): ?>
                                <a href="kelola_kategori.php" class="btn btn-outline-secondary mt-3 d-inline-flex align-items-center justify-content-center text-decoration-none" style="border-radius: 10px; font-weight:600; padding: 0 15px;">Batal</a>
                            <?php endif; ?>
                        </div>
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
    <script src="../assets/js/admin_kelola_kategori.js"></script>
</body>
</html>