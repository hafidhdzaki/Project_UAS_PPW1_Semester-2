<?php
if (!defined('BASE_PATH')) {
    die('BASE_PATH not defined. Please include config.php first.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Roti Nusantara'; ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <?php if (isset($custom_css)): ?>
        <link href="<?= BASE_PATH . $custom_css; ?>" rel="stylesheet">
    <?php endif; ?>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_PATH; ?>index.php">
                <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link <?= (isset($active_page) && $active_page === 'beranda') ? 'active' : ''; ?>" href="<?= BASE_PATH; ?>index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link <?= (isset($active_page) && $active_page === 'katalog') ? 'active' : ''; ?>" href="<?= BASE_PATH; ?>pages/katalog.php">Katalog</a></li>
                    <?php if(isLoggedIn()): ?>
                        <?php if($_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item d-lg-none"><a class="nav-link text-warning fw-bold" href="<?= BASE_PATH; ?>pages/admin/index.php"><i class="fa-solid fa-gauge me-2"></i>Panel Admin</a></li>
                        <?php else: ?>
                            <li class="nav-item d-lg-none"><a class="nav-link <?= (isset($active_page) && $active_page === 'keranjang') ? 'active' : ''; ?>" href="<?= BASE_PATH; ?>pages/keranjang.php"><i class="fa-solid fa-cart-shopping me-2"></i>Keranjang</a></li>
                        <?php endif; ?>
                        <li class="nav-item d-lg-none"><a class="nav-link text-danger" href="<?= BASE_PATH; ?>pages/logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Keluar (<?= htmlspecialchars($_SESSION['full_name']); ?>)</a></li>
                    <?php else: ?>
                        <li class="nav-item d-lg-none"><a class="nav-link <?= (isset($active_page) && $active_page === 'login') ? 'active' : ''; ?>" href="<?= BASE_PATH; ?>pages/login.php"><i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Masuk</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <?php if(isLoggedIn()): ?>
                        <?php if($_SESSION['role'] === 'admin'): ?>
                            <a href="<?= BASE_PATH; ?>pages/admin/index.php" class="btn btn-warning text-white" style="border-radius: 25px; padding: 6px 20px; font-weight:600;">Panel Admin</a>
                        <?php else: ?>
                            <a href="<?= BASE_PATH; ?>pages/keranjang.php" class="nav-link position-relative me-3 text-dark <?= (isset($active_page) && $active_page === 'keranjang') ? 'active' : ''; ?>" title="Keranjang Belanja">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                    <?php 
                                    $id_user_cart = $_SESSION['user_id'];
                                    $q_cart_count = mysqli_query($conn, "SELECT SUM(qty) as total FROM keranjang WHERE id_user='$id_user_cart'");
                                    $r_cart_count = mysqli_fetch_assoc($q_cart_count);
                                    echo $r_cart_count['total'] ? $r_cart_count['total'] : '0';
                                    ?>
                                </span>
                            </a>
                        <?php endif; ?>
                        <span class="fw-medium text-dark">Halo, <?= htmlspecialchars($_SESSION['full_name']); ?>!</span>
                        <a href="<?= BASE_PATH; ?>pages/logout.php" class="btn btn-outline-danger" style="border-radius: 25px; padding: 6px 20px; font-weight:600;">Keluar</a>
                    <?php else: ?>
                        <a href="<?= BASE_PATH; ?>pages/login.php" class="btn-outline-primary-custom">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
