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

    // Client-side Filtering for Orders
    const filterPills = document.querySelectorAll('.btn-filter');
    const tableRows = document.querySelectorAll('.table-pesanan tbody tr');
    const orderCards = document.querySelectorAll('.mobile-order-card');

    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');

            // Get first text node (e.g., "Pending", "Semua")
            const categoryText = this.childNodes[0].textContent.trim().toLowerCase(); 

            // Filter table rows
            tableRows.forEach(row => {
                const badge = row.querySelector('.status-badge');
                if (!badge) return;
                const status = badge.textContent.trim().toLowerCase();
                if (categoryText === 'semua' || status === categoryText) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Filter mobile cards
            orderCards.forEach(card => {
                const badge = card.querySelector('.status-badge');
                if (!badge) return;
                const status = badge.textContent.trim().toLowerCase();
                if (categoryText === 'semua' || status === categoryText) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
