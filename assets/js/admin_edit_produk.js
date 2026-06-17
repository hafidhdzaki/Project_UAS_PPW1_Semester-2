document.addEventListener('DOMContentLoaded', function() {
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

    // Buka Tutup Submenu Sidebar
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
