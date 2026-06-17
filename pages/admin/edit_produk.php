<?php
include_once("../../includes/config.php");

// Proteksi Admin
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

// Ambil ID Produk dari URL
$id_produk = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Jika tombol form ditekan (Update Data)
if (isset($_POST['update_produk'])) {
    $nama        = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $harga       = mysqli_real_escape_string($conn, $_POST['harga']);
    $stok        = mysqli_real_escape_string($conn, $_POST['stok']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Konversi nilai toggle/switch ke boolean (1 atau 0)
    $is_tampil   = isset($_POST['is_tampil']) ? 1 : 0;
    $is_unggulan = isset($_POST['is_unggulan']) ? 1 : 0;

    // Cek apakah ada file gambar baru yang diunggah
    if (!empty($_FILES['gambar_produk']['name'])) {
        $gambar_nama = $_FILES['gambar_produk']['name'];
        $gambar_tmp  = $_FILES['gambar_produk']['tmp_name'];
        // Pastikan Anda sudah membuat folder 'uploads' di dalam folder project Anda
        $db_path     = "assets/img/" . time() . "_" . $gambar_nama; 
        move_uploaded_file($gambar_tmp, "../../" . $db_path);
        
        // Query update dengan gambar baru
        $query = "UPDATE produk_roti SET 
                  id_kategori='$id_kategori', nama_produk='$nama', deskripsi='$deskripsi', 
                  harga='$harga', stok='$stok', gambar='$db_path', is_tampil='$is_tampil', is_unggulan='$is_unggulan' 
                  WHERE id_produk='$id_produk'";
    } else {
        // Query update tanpa mengubah gambar lama
        $query = "UPDATE produk_roti SET 
                  id_kategori='$id_kategori', nama_produk='$nama', deskripsi='$deskripsi', 
                  harga='$harga', stok='$stok', is_tampil='$is_tampil', is_unggulan='$is_unggulan' 
                  WHERE id_produk='$id_produk'";
    }

    if (mysqli_query($conn, $query)) {
        header('Location: kelola_produk.php?pesan=edit_sukses');
        exit();
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}

// Ambil Data Produk saat ini untuk diisi ke dalam form
$produk_query = mysqli_query($conn, "SELECT * FROM produk_roti WHERE id_produk = '$id_produk'");
if(mysqli_num_rows($produk_query) == 0) {
    header('Location: kelola_produk.php'); // Kembali jika produk tidak ditemukan
    exit();
}
$data = mysqli_fetch_assoc($produk_query);

// Ambil Data Kategori untuk Dropdown
$kategori_query = mysqli_query($conn, "SELECT * FROM kategori_roti");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin Roti Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../../assets/css/style_edit_produk.css" rel="stylesheet">
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
                    <li><a href="kelola_produk.php" class="active"><i class="fa-solid fa-list" style="font-size: 0.65rem; margin-right: 5px;"></i> Daftar Produk</a></li>
                    <li><a href="tambah_produk.php"><i class="fa-solid fa-plus" style="font-size: 0.65rem; margin-right: 5px;"></i> Tambah Produk</a></li>
                    <li><a href="kelola_kategori.php"><i class="fa-solid fa-tags" style="font-size: 0.65rem; margin-right: 5px;"></i> Kel. Kategori</a></li>
                </ul>
            </li>

            <li><a href="kelola_pesanan.php"><i class="fa-solid fa-clipboard-list"></i> Kelola Pesanan <?php
                $pesanan_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM pesanan WHERE status='pending'"))['cnt'];
                if($pesanan_pending > 0): ?><span class="badge-notif"><?= $pesanan_pending; ?></span><?php endif; ?></a></li>
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
                    <h2>Edit Produk</h2>
                    <p class="d-none d-md-block">Admin &rsaquo; Kelola Produk &rsaquo; Edit Produk</p>
                </div>
            </div>
            <div class="avatar-circle d-lg-none" style="width:35px; height:35px; font-size:0.8rem;">AD</div>
        </header>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="admin-card p-4 bg-white rounded shadow-sm">
                        <h5 class="mb-4"><i class="fa-solid fa-wheat-awn text-warning"></i> Informasi Dasar Produk</h5>
                        
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?= $error; ?></div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Nama Produk *</label>
                            <input type="text" class="form-control" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Roti *</label>
                            <select class="form-select" name="id_kategori" required>
                                <?php while($kat = mysqli_fetch_assoc($kategori_query)): ?>
                                    <option value="<?= $kat['id_kategori']; ?>" <?= ($kat['id_kategori'] == $data['id_kategori']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($kat['nama_kategori']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Produk *</label>
                            <input type="number" class="form-control" name="harga" value="<?= $data['harga']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" value="<?= $data['stok']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control" name="deskripsi" rows="4"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="admin-card p-4 bg-white rounded shadow-sm mb-4">
                        <h5 class="mb-3"><i class="fa-regular fa-image"></i> Gambar Saat Ini</h5>
                        <?php if($data['gambar']): ?>
                            <img src="../../<?= $data['gambar']; ?>" alt="Preview" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        
                        <label class="form-label">Ganti Gambar (Opsional)</label>
                        <input type="file" class="form-control" name="gambar_produk" accept="image/png, image/jpeg, image/webp">
                    </div>

                    <div class="admin-card p-4 bg-white rounded shadow-sm">
                        <h5 class="mb-3"><i class="fa-solid fa-box-archive"></i> Pengaturan</h5>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_tampil" <?= ($data['is_tampil'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label">Tampilkan di Katalog</label>
                        </div>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_unggulan" <?= ($data['is_unggulan'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label">Jadikan Produk Unggulan</label>
                        </div>
                    </div>
                    
                    <button type="submit" name="update_produk" class="btn-submit-edit w-100 mt-3 text-white fw-bold py-2">
                        Simpan Perubahan
                    </button>
                    <a href="kelola_produk.php" class="btn-back text-center justify-content-center w-100 mt-2">Batal</a>
                </div>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/admin_edit_produk.js"></script>
</body>
</html>