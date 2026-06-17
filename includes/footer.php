<?php
if (!defined('BASE_PATH')) {
    die('BASE_PATH not defined. Please include config.php first.');
}
?>
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 col-md-12">
                    <a href="<?= BASE_PATH; ?>index.php" class="footer-brand">
                        <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
                    </a>
                    <p class="footer-text">Roti segar berkualitas tinggi, dipanggang dengan cinta setiap hari.</p>
                    <p class="text-muted" style="font-size: 0.8rem;">&copy; 2026 Roti Nusantara. Hak cipta dilindungi.</p>
                </div>
                <div class="col-lg-2 col-md-4 offset-lg-4 footer-links">
                    <h6>Tautan</h6>
                    <ul>
                        <li><a href="<?= BASE_PATH; ?>index.php">Beranda</a></li>
                        <li><a href="<?= BASE_PATH; ?>pages/katalog.php">Katalog</a></li>
                        <li><a href="<?= BASE_PATH; ?>pages/login.php">Masuk</a></li>
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
        if (typeof AOS !== 'undefined') {
            AOS.init({
                once: true,
                offset: 50
            });
        }
    </script>
    
    <?php if (isset($custom_js)): ?>
        <script src="<?= BASE_PATH . $custom_js; ?>"></script>
    <?php endif; ?>
</body>
</html>
