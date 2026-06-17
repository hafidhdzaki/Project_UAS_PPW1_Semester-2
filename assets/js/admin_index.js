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

    // Chart.js Configuration
    const chartEl = document.getElementById('orderChart');
    if (chartEl && typeof Chart !== 'undefined') {
        const ctx = chartEl.getContext('2d');
        const selesai = parseInt(chartEl.getAttribute('data-selesai')) || 0;
        const dibayar = parseInt(chartEl.getAttribute('data-dibayar')) || 0;
        const pending = parseInt(chartEl.getAttribute('data-pending')) || 0;
        const batal = parseInt(chartEl.getAttribute('data-batal')) || 0;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Dibayar', 'Pending', 'Batal'],
                datasets: [{
                    data: [selesai, dibayar, pending, batal],
                    backgroundColor: [
                        '#2ECC71', // Green
                        '#3498DB', // Blue
                        '#F1C40F', // Yellow
                        '#E74C3C'  // Red
                    ],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + ' pesanan';
                            }
                        }
                    }
                }
            }
        });
    }
});
