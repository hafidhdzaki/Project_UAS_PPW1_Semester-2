<?php
include_once("../includes/config.php");

if (!isLoggedIn()) { header('Location: login.php'); exit(); }

$id_user = $_SESSION['user_id'];

// Ambil data keranjang untuk dihitung totalnya
$query = "SELECT k.qty, p.id_produk, p.harga FROM keranjang k JOIN produk_roti p ON k.id_produk = p.id_produk WHERE k.id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$total_pembayaran = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $total_pembayaran += ($row['harga'] * $row['qty']);
}

// Jika keranjang kosong, tidak boleh checkout
if ($total_pembayaran == 0) { header('Location: keranjang.php'); exit(); }

// JIKA FORM CHECKOUT DISUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $tanggal_pesanan = date('Y-m-d H:i:s');
    $status = 'pending';
    
    // Proses Upload Bukti Bayar
    $bukti_path = "";
    if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == 0) {
        $file_name = $_FILES['bukti_bayar']['name'];
        $file_size = $_FILES['bukti_bayar']['size'];
        $file_tmp = $_FILES['bukti_bayar']['tmp_name'];
        
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['png', 'jpg', 'jpeg'];
        
        if (!in_array($ext, $allowed_ext)) {
            echo "<script>alert('Format bukti transfer tidak valid! Hanya menerima JPG, JPEG, atau PNG.'); window.history.back();</script>";
            exit();
        }
        
        if ($file_size > 2 * 1024 * 1024) { // 2MB
            echo "<script>alert('Ukuran bukti transfer terlalu besar! Maksimal 2MB.'); window.history.back();</script>";
            exit();
        }
        
        $nama_file = time() . '_' . $file_name;
        $bukti_path = 'assets/img/bukti/' . $nama_file;
        move_uploaded_file($file_tmp, '../' . $bukti_path);
    } else {
        echo "<script>alert('Anda harus mengunggah bukti transfer!'); window.history.back();</script>";
        exit();
    }

    // 1. Insert ke tabel pesanan
    $sql_pesanan = "INSERT INTO pesanan (id_user, tanggal_pesanan, total_pembayaran, alamat_pengiriman, bukti_bayar, status) 
                    VALUES ('$id_user', '$tanggal_pesanan', '$total_pembayaran', '$alamat', '$bukti_path', '$status')";
    
    if (mysqli_query($conn, $sql_pesanan)) {
        $id_pesanan = mysqli_insert_id($conn); // Ambil ID pesanan yang baru saja terbuat

        // 2. Insert ke detail_pesanan & kurangi stok produk
        mysqli_data_seek($result, 0); // Reset pointer loop keranjang
        while ($row = mysqli_fetch_assoc($result)) {
            $id_produk = $row['id_produk'];
            $qty = $row['qty'];
            $harga = $row['harga'];
            
            mysqli_query($conn, "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah_beli, harga_satuan) VALUES ('$id_pesanan', '$id_produk', '$qty', '$harga')");
            mysqli_query($conn, "UPDATE produk_roti SET stok = stok - $qty WHERE id_produk = '$id_produk'");
        }

        // 3. Kosongkan keranjang user
        mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user'");
        
        echo "<script>alert('Pesanan berhasil dibuat! Menunggu konfirmasi admin.'); window.location='../index.php';</script>";
        exit();
    }
}
?>

<?php
$page_title = "Checkout - Roti Nusantara";
$active_page = "katalog";
$custom_css = "assets/css/style_index_user.css";
include_once("../includes/header.php");
?>

    <div class="container mt-5 mb-5" style="min-height: 60vh;">
        <h2 class="fw-bold mb-4 text-center">Pengiriman & Pembayaran</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="checkout-card">
                    
                    <div class="alert alert-info mb-4">
                        Silakan transfer sebesar <strong>Rp <?= number_format($total_pembayaran, 0, ',', '.'); ?></strong> ke rekening <strong>BCA 1234567890 a.n. Roti Nusantara</strong>
                    </div>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Pengiriman Lengkap</label>
                            <textarea class="form-control" name="alamat" rows="4" placeholder="Masukkan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan kota." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Bukti Transfer</label>
                            <input type="file" class="form-control" name="bukti_bayar" accept="image/png, image/jpeg, image/jpg" required>
                            <div class="form-text">Hanya menerima format JPG, JPEG, PNG. Maksimal 2MB.</div>
                        </div>
                        <button type="submit" name="checkout" class="btn w-100" style="background-color: #E67E22; color: white; font-weight: 600; padding: 12px; border-radius: 10px;">
                            Selesaikan Pesanan
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

<?php
include_once("../includes/footer.php");
?>