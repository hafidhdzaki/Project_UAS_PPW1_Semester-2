document.addEventListener('DOMContentLoaded', function() {
    // Init Animate On Scroll
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

    // Logic Filter Pills Active State & Client-side Filtering
    const pills = document.querySelectorAll('.btn-pill');
    const rows = document.querySelectorAll('.table-produk tbody tr');
    const cards = document.querySelectorAll('.mobile-product-card');

    pills.forEach(pill => {
        pill.addEventListener('click', function() {
            pills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.textContent.trim();
            
            // Filter rows
            rows.forEach(row => {
                const rowCat = row.getAttribute('data-category');
                if (category === 'Semua' || rowCat === category) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Filter cards
            cards.forEach(card => {
                const cardCat = card.getAttribute('data-category');
                if (category === 'Semua' || cardCat === category) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
