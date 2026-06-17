<?php
include_once("../includes/config.php");

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['user_id'];

// Hapus item dari keranjang jika ada request
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang='$id_hapus' AND id_user='$id_user'");
    header('Location: keranjang.php');
    exit();
}

// Ambil data keranjang beserta detail produknya
$query = "SELECT k.id_keranjang, k.qty, p.id_produk, p.nama_produk, p.harga, p.gambar 
          FROM keranjang k 
          JOIN produk_roti p ON k.id_produk = p.id_produk 
          WHERE k.id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$total_belanja = 0;
?>

<?php
$page_title = "Keranjang Belanja - Roti Nusantara";
$active_page = "keranjang";
$custom_css = "assets/css/style_index_user.css";
include_once("../includes/header.php");
?>

    <div class="container mt-5 mb-5" style="min-height: 60vh;">
        <h2 class="fw-bold mb-4">Keranjang Belanja</h2>
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-card">
                    <?php 
                    mysqli_data_seek($result, 0);
                    if (mysqli_num_rows($result) > 0): 
                    ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): 
                                        $subtotal = $row['harga'] * $row['qty'];
                                        $total_belanja += $subtotal;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="<?= htmlspecialchars($row['gambar'] ? BASE_PATH . $row['gambar'] : 'https://via.placeholder.com/100'); ?>" class="cart-img" alt="Produk">
                                                <span class="fw-semibold"><?= htmlspecialchars($row['nama_produk']); ?></span>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                        <td><?= $row['qty']; ?></td>
                                        <td class="fw-bold" style="color: #E67E22;">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                                        <td>
                                            <a href="keranjang.php?hapus=<?= $row['id_keranjang']; ?>" class="text-danger" onclick="return confirm('Hapus produk ini?');"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <h5 class="text-muted">Keranjang Anda masih kosong.</h5>
                            <a href="katalog.php" class="btn btn-outline-primary mt-3" style="border-color: #E67E22; color: #E67E22;">Belanja Sekarang</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-card">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Harga</span>
                        <span class="fw-bold fs-5" style="color: #E67E22;">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></span>
                    </div>
                    <?php if ($total_belanja > 0): ?>
                        <a href="checkout.php" class="btn btn-checkout w-100 d-block text-center text-decoration-none">Lanjut ke Checkout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php
include_once("../includes/footer.php");
?>