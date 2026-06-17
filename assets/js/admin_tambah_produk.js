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

    // Set Current Date
    const currentDateEl = document.getElementById('currentDate');
    if (currentDateEl) {
        const dateOptions = { day: 'numeric', month: 'short', year: 'numeric' };
        currentDateEl.innerText = new Date().toLocaleDateString('id-ID', dateOptions);
    }

    // Character Counters & Preview Update
    const inputNama = document.getElementById('inputNama');
    const countNama = document.getElementById('countNama');
    const prevNama = document.getElementById('prevNama');
    
    if (inputNama) {
        inputNama.addEventListener('input', function() {
            if (countNama) countNama.innerText = this.value.length;
            if (prevNama) prevNama.innerText = this.value || '—';
        });
    }

    const inputDeskripsi = document.getElementById('inputDeskripsi');
    const countDeskripsi = document.getElementById('countDeskripsi');
    if (inputDeskripsi) {
        inputDeskripsi.addEventListener('input', function() {
            if (countDeskripsi) countDeskripsi.innerText = this.value.length;
        });
    }

    // Kategori Preview
    const inputKategori = document.getElementById('inputKategori');
    const prevKategori = document.getElementById('prevKategori');
    if (inputKategori && prevKategori) {
        inputKategori.addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            prevKategori.innerText = this.value ? selectedText : '—';
        });
    }

    // Harga Preview
    const inputHarga = document.getElementById('inputHarga');
    const prevHarga = document.getElementById('prevHarga');
    if (inputHarga && prevHarga) {
        inputHarga.addEventListener('input', function() {
            let val = parseInt(this.value);
            prevHarga.innerText = isNaN(val) ? 'Rp 0' : 'Rp ' + val.toLocaleString('id-ID');
        });
    }

    // Stok Logic
    const inputStok = document.getElementById('inputStok');
    const stokWarning = document.getElementById('stokWarning');
    const prevStok = document.getElementById('prevStok');
    const prevStatus = document.getElementById('prevStatus');

    function checkStokWarning(val) {
        if (stokWarning && prevStatus) {
            if (val === 0) {
                stokWarning.style.display = 'flex';
                prevStatus.innerHTML = '<i class="fa-solid fa-xmark"></i> Habis';
                prevStatus.style.background = '#FEE4E2'; prevStatus.style.color = '#E74C3C';
            } else {
                stokWarning.style.display = 'none';
                prevStatus.innerHTML = '<i class="fa-solid fa-check"></i> Tersedia';
                prevStatus.style.background = '#D1FADF'; prevStatus.style.color = '#039855';
            }
        }
        if (prevStok) prevStok.innerText = val;
    }

    // Expose globally for inline onclick
    window.updateStok = function(change) {
        if (inputStok) {
            let currentVal = parseInt(inputStok.value) || 0;
            let newVal = currentVal + change;
            if (newVal >= 0) {
                inputStok.value = newVal;
                checkStokWarning(newVal);
            }
        }
    };

    if (inputStok) {
        inputStok.addEventListener('input', function() {
            let val = parseInt(this.value) || 0;
            if(val < 0) { this.value = 0; val = 0; }
            checkStokWarning(val);
        });
    }

    // Drag and Drop Logic
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');

    if (dropZone && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });

        dropZone.addEventListener('drop', function(e) {
            let dt = e.dataTransfer;
            let files = dt.files;
            handleFiles(files);
        });

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                let fileName = files[0].name;
                dropZone.innerHTML = `<div class="drag-drop-icon" style="color:var(--primary-color);"><i class="fa-solid fa-image"></i></div>
                                      <p style="color:var(--primary-color); font-weight:600;">${fileName}</p>
                                      <button type="button" class="btn-pilih-file mt-2" onclick="document.getElementById('fileInput').click()">Ganti File</button>`;
            }
        }
    }

    // Validasi Form Tambah Produk (Minimal 2 Field)
    const productForm = document.getElementById('productForm');
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            const namaVal = inputNama ? inputNama.value.trim() : '';
            const hargaVal = inputHarga ? parseInt(inputHarga.value) : 0;
            
            let isValid = true;
            let errors = [];

            // 1. Validasi Nama Produk (minimal 3 karakter)
            if (namaVal.length < 3) {
                isValid = false;
                errors.push('Nama Produk minimal harus terdiri dari 3 karakter.');
                if (inputNama) {
                    inputNama.classList.add('is-invalid');
                }
            } else {
                if (inputNama) {
                    inputNama.classList.remove('is-invalid');
                    inputNama.classList.add('is-valid');
                }
            }

            // 2. Validasi Harga Produk (minimal Rp 100)
            if (isNaN(hargaVal) || hargaVal < 100) {
                isValid = false;
                errors.push('Harga Produk harus berupa angka dan minimal Rp 100.');
                if (inputHarga) {
                    inputHarga.classList.add('is-invalid');
                }
            } else {
                if (inputHarga) {
                    inputHarga.classList.remove('is-invalid');
                    inputHarga.classList.add('is-valid');
                }
            }

            if (!isValid) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    }
});
