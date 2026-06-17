document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Animasi AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({ once: true, offset: 50 });
    }

    // Toggle Mobile Sidebar
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');

    if (mobileMenuBtn && sidebar) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && e.target !== mobileMenuBtn) {
                sidebar.classList.remove('active');
            }
        });
    }

    // Logic Perhitungan Konter Karakter Input
    const inputKategori = document.getElementById('inputKategori');
    const charCount = document.getElementById('charCount');
    
    if (inputKategori && charCount) {
        // Set initial count in case of edit
        charCount.innerText = inputKategori.value.length;
        
        inputKategori.addEventListener('input', function() {
            charCount.innerText = this.value.length;
        });
    }

    // Logic Buka-Tutup Submenu Kelola Produk
    const toggleProduk = document.getElementById('toggleProduk');
    const submenuProduk = document.getElementById('submenuProduk');
    const iconProduk = document.getElementById('iconProduk');

    if (toggleProduk && submenuProduk) {
        toggleProduk.addEventListener('click', function(e) {
            e.preventDefault();
            submenuProduk.classList.toggle('show');
            if(submenuProduk.classList.contains('show')) {
                if (iconProduk) iconProduk.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                if (iconProduk) iconProduk.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        });
    }
});
