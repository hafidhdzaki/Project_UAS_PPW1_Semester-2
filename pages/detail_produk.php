<?php
include_once("../includes/config.php");


// Ambil ID produk dari URL (misal: detail_produk.php?id=1)
$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data dari database
$query = "SELECT p.*, k.nama_kategori FROM produk_roti p JOIN kategori_roti k ON p.id_kategori = k.id_kategori WHERE p.id_produk = '$id_produk'";
$result = mysqli_query($conn, $query);

// Jika produk tidak ditemukan, kembalikan ke katalog
if(mysqli_num_rows($result) == 0) {
    header('Location: katalog.php');
    exit();
}
$data = mysqli_fetch_assoc($result);
?>
<?php
$page_title = htmlspecialchars($data['nama_produk']) . " - Roti Nusantara";
$active_page = "katalog";
$custom_css = "assets/css/style_detail_produk.css";
include_once("../includes/header.php");
?>

    <div class="container mt-2">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_PATH; ?>index.php">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_PATH; ?>pages/katalog.php">Katalog</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($data['nama_produk']); ?></li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="main-image-wrapper">
                    <span class="badge-kategori-img"><?= htmlspecialchars($data['nama_kategori']); ?></span>
                    <?php if($data['stok'] > 0): ?>
                        <span class="badge-status-img"><i class="fa-solid fa-check"></i> Tersedia</span>
                    <?php else: ?>
                        <span class="badge-status-img" style="background:#FEE4E2; color:#E74C3C;"><i class="fa-solid fa-xmark"></i> Habis</span>
                    <?php endif; ?>
                    <img id="mainImage" src="<?= htmlspecialchars($data['gambar'] ? BASE_PATH . $data['gambar'] : 'https://via.placeholder.com/800'); ?>" alt="Produk">
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <span class="product-badge-text"><?= htmlspecialchars($data['nama_kategori']); ?></span>
                <h1 class="product-title"><?= htmlspecialchars($data['nama_produk']); ?></h1>
                
                <div class="rating-box">
                    <div class="stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span class="rating-text">4.8</span>
                </div>

                <div class="product-price">
                    Rp <?= number_format($data['harga'], 0, ',', '.'); ?> <span class="price-unit">/ buah</span>
                </div>
                
                <div class="stock-status <?= $data['stok'] > 0 ? '' : 'text-danger'; ?>">
                    <i class="fa-solid fa-box-open"></i> Stok tersedia: <?= $data['stok']; ?> buah
                </div>

                <div class="product-desc-short mb-4">
                    <strong>Deskripsi Produk</strong><br>
                    <?= nl2br(htmlspecialchars($data['deskripsi'])); ?>
                </div>

                <form action="tambah_keranjang.php" method="POST" class="action-box">
                    <input type="hidden" name="id_produk" value="<?= $data['id_produk']; ?>">
                    
                    <label class="qty-label">Jumlah</label>
                    <div class="qty-selector">
                        <button type="button" class="btn-qty" onclick="updateQty(-1)">-</button>
                        <input type="text" class="input-qty" id="qtyInput" name="qty" value="1" readonly>
                        <button type="button" class="btn-qty" onclick="updateQty(1)">+</button>
                    </div>

                    <div class="total-box">
                        <span class="total-label">Total Pembayaran</span>
                        <span class="total-price" id="totalPrice">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></span>
                    </div>

                    <button type="submit" class="btn-pesan" <?= $data['stok'] == 0 ? 'disabled style="background:gray;"' : ''; ?>>
                        <i class="fa-solid fa-cart-shopping"></i> Masukkan Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const basePrice = <?= $data['harga']; ?>;
        const maxStok = <?= $data['stok']; ?>;
    </script>
<?php
$custom_js = "assets/js/detail_produk.js";
include_once("../includes/footer.php");
?>