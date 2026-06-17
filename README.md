# 🍞 Roti Nusantara — Aplikasi E-Commerce & Manajemen Toko Roti

> **Proyek Ujian Akhir Semester (UAS) - Mata Kuliah Praktikum Pemrograman Web 1**  
> Dibuat oleh **Hafidh Dzaki Fardiansyah**  
> Program Studi **Teknologi Rekayasa Perangkat Lunak**
> NIM **25/568374/SV/27446**
> Kelas **PL2B2**

---

## 📝 Deskripsi Proyek

**Roti Nusantara** adalah aplikasi e-commerce berbasis web dan sistem manajemen database (CRUD) yang dirancang khusus untuk toko roti lokal. Aplikasi ini memfasilitasi pelanggan untuk menjelajahi katalog produk secara dinamis, melakukan checkout belanjaan, dan mengunggah bukti pembayaran. Di sisi lain, aplikasi ini juga menyediakan panel admin khusus (Admin Dashboard) untuk mengelola data produk (tambah, edit, status tampil, produk unggulan), melihat grafik ringkasan pesanan terbaru, dan mengelola status transaksi pelanggan secara *real-time*.

---

## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun menggunakan kombinasi teknologi modern tanpa framework eksternal berat (*Native/Vanilla*) untuk memastikan kecepatan performa dan kemudahan pemeliharaan:

*   **Sisi Server (Back-End):** PHP Native (Versi 8.0+)
*   **Database:** MySQL
*   **Desain & Layout (CSS):** Bootstrap 5 & CSS Murni (Vanilla CSS) untuk kustomisasi tema premium
*   **Interaktivitas (Front-End):** JavaScript Native (Vanilla JS)
*   **Animasi:** AOS (Animate On Scroll) & Font Awesome 6 (Ikon)

---

## ✨ Fitur Utama

Aplikasi Roti Nusantara dilengkapi dengan berbagai fitur interaktif yang memenuhi standar aplikasi web komersial:

| Kategori Fitur | Deskripsi Detail |
| :--- | :--- |
| 📱 **Responsive Design** | Tata letak adaptif yang dioptimalkan sepenuhnya untuk resolusi HP/Mobile, Tablet, dan Desktop menggunakan Bootstrap 5 grid system. |
| 🔐 **Autentikasi Pengguna** | Sistem Login dan Register dengan pengamanan *password hashing* menggunakan `password_hash()` standar industri serta manajemen sesi (*PHP Session*). |
| 🍞 **CRUD Produk & Upload** | Kelola data produk secara dinamis oleh admin. Mendukung upload foto produk dengan validasi ukuran (max 2MB) dan tipe ekstensi berkas. |
| 📊 **Dashboard Grafik Interaktif** | Ringkasan statistik status pesanan (Selesai, Dibayar, Pending, Batal) dalam bentuk Donut Chart dinamis menggunakan *Chart.js*. |
| 🔍 **Filter & Pencarian Dinamis** | Pencarian katalog produk pelanggan berbasis teks, kategori produk, harga maksimal, dan status ketersediaan stok secara interaktif. |
| ⚡ **Mikro Interaksi & Validasi JS** | *Direct feedback* berupa konfirmasi penghapusan/penyimpanan data produk (`confirm()`), validasi form tambah produk minimal 2 field, dan transisi hover yang halus. |

---

## ⚙️ Prasyarat Sistem

Sebelum menjalankan proyek ini secara lokal, pastikan perangkat Anda telah memenuhi prasyarat berikut:

1.  **Web Server & Database:** **XAMPP** (Sangat disarankan) atau stack server lokal sejenis.
2.  **Versi PHP:** PHP 8.0 ke atas.
3.  **Versi MySQL/MariaDB:** MariaDB 10.4+ atau MySQL 8.0+.
4.  **Browser:** Google Chrome, Mozilla Firefox, Microsoft Edge, atau browser modern lainnya.

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

Ikuti langkah-langkah di bawah ini untuk memasang dan menjalankan aplikasi di komputer lokal Anda:

### Langkah 1: Memindahkan Folder Proyek
1. Unduh atau salin seluruh folder proyek `Project Akhir UAS Sem 2`.
2. Pindahkan folder tersebut ke dalam direktori server lokal Anda:
   *   Untuk Windows (XAMPP): `C:\xampp\htdocs\`
   *   Untuk macOS (XAMPP): `/Applications/XAMPP/htdocs/`

### Langkah 2: Membuat dan Mengimpor Database
1. Aktifkan modul **Apache** dan **MySQL** pada XAMPP Control Panel.
2. Buka browser dan akses **phpMyAdmin** via tautan [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/).
3. Buat database baru bernama **`manajemen_roti`**.
4. Klik tab **Import**, pilih file dump database SQL proyek ini (`manajemen_roti.sql`), lalu klik **Go** / **Import**.

### Langkah 3: Konfigurasi Koneksi Database
Buka file konfigurasi koneksi database di [includes/config.php](file:///d:/XAMPP/htdocs/Project%20Akhir%20UAS%20Sem%202/includes/config.php) menggunakan text editor pilihan Anda (VS Code, Notepad++, dll.), lalu sesuaikan kredensial database lokal Anda jika berbeda:

```php
$host = "localhost";
$user = "root";       // Username default MySQL XAMPP
$pass = "";           // Password default MySQL XAMPP (kosong)
$db   = "manajemen_roti";
```

### Langkah 4: Mengakses Aplikasi di Browser
Buka browser Anda dan ketikkan alamat berikut pada address bar:
*   **Halaman Pelanggan (Beranda):**
    [http://localhost/Project Akhir UAS Sem 2/index.php](http://localhost/Project%20Akhir%20UAS%20Sem%202/index.php)
*   **Halaman Login (Akses Masuk):**
    [http://localhost/Project Akhir UAS Sem 2/pages/login.php](http://localhost/Project%20Akhir%20UAS%20Sem%202/pages/login.php)

---

## 👥 Akun Demo Uji Coba

Untuk keperluan penilaian dan demonstrasi fitur, Anda dapat masuk ke dalam sistem menggunakan akun demo berikut:

| Peran (Role) | Email Login | Password Default | Akses Utama |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `admin123` / `123456` | Mengelola produk, melihat grafik donat dashboard, konfirmasi pesanan masuk. |
| **Pelanggan (User)** | `budi.santoso@gmail.com` | `budi123` / `123456` | Melihat katalog, menambah ke keranjang belanja, checkout, unggah bukti bayar. |

---

## 📸 Dokumentasi Antarmuka (Screenshot)

*Berikut adalah visualisasi antarmuka utama dari aplikasi Roti Nusantara:*

### 1. Halaman Beranda (User Homepage)
![Halaman Beranda](/assets/img/screenshot_beranda.png)
*Tampilan utama beranda pelanggan, menyajikan menu hero yang interaktif, kategori roti, produk unggulan pilihan admin, dan badge status stok.*

### 2. Halaman Daftar Data Produk (Admin)
![Daftar Data Admin](/assets/img/screenshot_admin_daftar.png)
*Tabel manajemen data produk pada panel admin, lengkap dengan visualisasi gambar mini, paginasi dinamis per 10 produk, pencarian produk, serta tombol aksi edit dan hapus.*

### 3. Form Tambah Data Produk (Admin)
![Form Tambah Data](/assets/img/screenshot_admin_tambah.png)
*Formulir interaktif untuk menambah produk baru ke dalam database dengan fitur drag-and-drop file gambar, status unggulan, serta validasi instan via JavaScript.*

### 4. Form Edit Data Produk (Admin)
![Form Edit Data](/assets/img/screenshot_admin_edit.png)
*Halaman modifikasi detail produk yang menampilkan data saat ini, pratinjau gambar produk yang sedang aktif, tombol batal/kembali, dan konfirmasi validasi dialog simpan.*

### 5. Tampilan Responsif (Mobile View)
![Tampilan Mobile](/assets/img/screenshot_mobile.png)
*Pratinjau tampilan responsif aplikasi Roti Nusantara di resolusi mobile (HP). Menu sidebar yang dinamis dapat dibuka-tutup dengan lancar menggunakan tombol hamburger di kiri atas.*
