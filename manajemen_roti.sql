-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2026 pada 15.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manajemen_roti`
--

DELIMITER $$
--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `cek_status_stok` (`jml_stok` INT) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    IF jml_stok > 5 THEN 
        RETURN 'Aman';
    ELSEIF jml_stok > 0 THEN 
        RETURN 'Menipis';
    ELSE 
        RETURN 'Habis';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_belanja_pelanggan` (`p_id_user` INT) RETURNS DECIMAL(10,2)  BEGIN
    DECLARE total DECIMAL(10,2);
    SELECT SUM(total_pembayaran) INTO total FROM pesanan WHERE id_user = p_id_user AND status = 'selesai';
    RETURN IFNULL(total, 0);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah_beli`, `harga_satuan`) VALUES
(1, 1, 1, 1, 25000.00),
(2, 1, 5, 3, 8000.00),
(3, 2, 6, 3, 9000.00),
(4, 3, 4, 3, 11000.00),
(5, 4, 7, 2, 28000.00),
(6, 5, 10, 1, 18000.00),
(7, 6, 2, 1, 20000.00),
(8, 6, 6, 2, 9000.00),
(9, 7, 13, 1, 12000.00),
(10, 8, 1, 2, 30000.00),
(11, 8, 11, 1, 13000.00),
(12, 9, 2, 2, 20000.00),
(13, 9, 11, 1, 13000.00),
(14, 10, 2, 2, 20000.00),
(15, 10, 13, 1, 12000.00),
(16, 11, 2, 2, 20000.00),
(17, 11, 11, 1, 13000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_roti`
--

CREATE TABLE `kategori_roti` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_roti`
--

INSERT INTO `kategori_roti` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Roti Tawar'),
(2, 'Roti Manis'),
(3, 'Donat'),
(4, 'Roti Sobek'),
(5, 'Pastry');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_user`, `id_produk`, `qty`) VALUES
(1, 3, 9, 2),
(2, 4, 11, 1),
(3, 7, 3, 3),
(4, 6, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_harga`
--

CREATE TABLE `log_harga` (
  `id_log` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `harga_lama` decimal(10,2) DEFAULT NULL,
  `harga_baru` decimal(10,2) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `log_harga`
--

INSERT INTO `log_harga` (`id_log`, `id_produk`, `harga_lama`, `harga_baru`, `waktu`) VALUES
(1, 1, 25000.00, 30000.00, '2026-06-16 21:50:42'),
(2, 14, 4998.00, 10000.00, '2026-06-17 19:15:31'),
(3, 16, 5999.00, 6000.00, '2026-06-17 19:48:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal_pesanan` datetime NOT NULL,
  `alamat_pengiriman` text NOT NULL,
  `total_pembayaran` decimal(10,2) NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status` enum('pending','dibayar','selesai','batal') NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `tanggal_pesanan`, `alamat_pengiriman`, `total_pembayaran`, `bukti_bayar`, `status`, `updated_at`) VALUES
(1, 2, '2026-06-01 09:15:00', 'Jl. Merdeka No. 10, Yogyakarta', 49000.00, 'bukti1.jpg', 'batal', '2026-06-16 14:52:26'),
(2, 3, '2026-06-03 14:20:00', 'Jl. Malioboro No. 5, Yogyakarta', 27000.00, 'bukti2.jpg', 'dibayar', '2026-06-16 13:40:33'),
(3, 4, '2026-06-05 10:00:00', 'Jl. Kaliurang No. 22, Sleman', 33000.00, NULL, 'pending', '2026-06-16 13:40:33'),
(4, 5, '2026-06-07 16:45:00', 'Jl. Solo No. 8, Bantul', 56000.00, 'bukti4.jpg', 'selesai', '2026-06-16 13:40:33'),
(5, 6, '2026-06-10 11:30:00', 'Jl. Magelang No. 15, Yogyakarta', 18000.00, NULL, 'batal', '2026-06-16 13:40:33'),
(6, 2, '2026-06-14 08:00:00', 'Jl. Merdeka No. 10, Yogyakarta', 38000.00, 'bukti6.jpg', 'dibayar', '2026-06-16 13:40:33'),
(7, 8, '2026-06-17 17:34:51', 'godean', 12000.00, 'assets/img/bukti/1781692491_sc interpolation 2.png', 'batal', '2026-06-17 10:41:06'),
(8, 9, '2026-06-17 18:14:06', 'Sleman', 73000.00, 'assets/img/bukti/1781694846_hero section_portofolio.png', 'pending', '2026-06-17 11:14:06'),
(9, 10, '2026-06-17 19:02:49', 'sleman', 53000.00, 'assets/img/bukti/1781697769_sc interpolation 2.png', 'pending', '2026-06-17 12:02:49'),
(10, 10, '2026-06-17 19:12:44', 'sleman', 52000.00, 'assets/img/bukti/1781698364_sc interpolation.png', 'pending', '2026-06-17 12:12:44'),
(11, 10, '2026-06-17 19:45:57', 'sleman', 53000.00, 'assets/img/bukti/1781700357_Image (Cinnamon roll).png', 'pending', '2026-06-17 12:45:57');

--
-- Trigger `pesanan`
--
DELIMITER $$
CREATE TRIGGER `trg_kembalikan_stok` AFTER UPDATE ON `pesanan` FOR EACH ROW BEGIN
    IF NEW.status = 'batal' AND OLD.status != 'batal' THEN
        UPDATE produk_roti pr
        JOIN detail_pesanan dp ON pr.id_produk = dp.id_produk
        SET pr.stok = pr.stok + dp.jumlah_beli
        WHERE dp.id_pesanan = NEW.id_pesanan;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_roti`
--

CREATE TABLE `produk_roti` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_tampil` tinyint(1) NOT NULL DEFAULT 1,
  `is_unggulan` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk_roti`
--

INSERT INTO `produk_roti` (`id_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`, `is_tampil`, `is_unggulan`, `updated_at`) VALUES
(1, 1, 'Roti Tawar Gandum', 'Roti tawar dari gandum utuh, lembut dan sehat', 30000.00, 49, 'assets/img/1781682954_putih.png', 1, 1, '2026-06-17 11:14:06'),
(2, 1, 'Roti Tawar Putih', 'Roti tawar putih klasik untuk sarapan', 20000.00, 54, 'assets/img/1781682933_tawar.png', 1, 0, '2026-06-17 12:45:57'),
(3, 2, 'Roti Coklat Keju', 'Roti manis dengan isian coklat dan keju', 12000.00, 40, 'assets/img/1781681438_Image (Pineapple nastar cookies).png', 1, 1, '2026-06-17 09:45:29'),
(4, 2, 'Roti Pisang Coklat', 'Roti manis dengan isian pisang dan coklat', 11000.00, 35, 'assets/img/1781681425_Image (Kastengel cheese cookies).png', 1, 0, '2026-06-17 09:45:29'),
(5, 3, 'Donat Gula', 'Donat klasik dengan taburan gula halus', 8000.00, 73, 'assets/img/1781681413_Image (thumb-1).png', 1, 0, '2026-06-17 09:45:29'),
(6, 3, 'Donat Coklat', 'Donat dengan topping coklat lumer', 9000.00, 65, 'assets/img/1781681398_Image (Chocolate banana bread).png', 1, 1, '2026-06-17 09:45:29'),
(7, 4, 'Roti Sobek Keju', 'Roti sobek lembut dengan taburan keju', 28000.00, 30, 'assets/img/1781681386_Image (Pain au chocolat pastry).png', 1, 1, '2026-06-17 09:45:29'),
(8, 4, 'Roti Sobek Coklat', 'Roti sobek dengan isian coklat', 27000.00, 28, 'assets/img/1781681372_Image (Cinnamon roll).png', 1, 0, '2026-06-17 09:45:29'),
(9, 5, 'Croissant Original', 'Pastry berlapis dengan tekstur renyah', 15000.00, 25, 'assets/img/1781681344_Image (Premium milk toast bread).png', 1, 1, '2026-06-17 09:45:29'),
(10, 5, 'Croissant Almond', 'Croissant dengan taburan almond', 18000.00, 20, 'assets/img/1781681320_Image (Classic butter croissant).png', 1, 0, '2026-06-17 09:45:29'),
(11, 2, 'Roti Sosis', 'Roti manis dengan isian sosis dan mayones', 13000.00, 42, 'assets/img/1781681295_Image (Mozzarella cheese bread).png', 1, 0, '2026-06-17 12:45:57'),
(12, 1, 'Roti Tawar Gandum Mini', 'Roti tawar gandum ukuran mini, stok kosong', 15000.00, 0, 'assets/img/1781681283_Image (thumb-2).png', 0, 0, '2026-06-17 09:45:29'),
(13, 2, 'Roti Mas Amba', 'Nikmati rasa pandannya', 12000.00, 0, 'assets/img/1781685347_roti.png', 1, 0, '2026-06-17 12:12:44'),
(14, 1, 'roti gabus', 'sangat lezat', 10000.00, 2, 'assets/img/1781698531_Signature Sourdough Loaf.png', 0, 0, '2026-06-17 12:15:40'),
(15, 1, 'roti gabus', 'manisss', 5000.00, 2, 'assets/img/1781699258_Image (Cinnamon roll).png', 0, 0, '2026-06-17 12:27:43'),
(16, 2, 'roti gabus', 'manis', 6000.00, 2, 'assets/img/1781700506_Image (Pain au chocolat pastry).png', 0, 0, '2026-06-17 12:48:45');

--
-- Trigger `produk_roti`
--
DELIMITER $$
CREATE TRIGGER `trg_log_harga` AFTER UPDATE ON `produk_roti` FOR EACH ROW BEGIN
    IF OLD.harga != NEW.harga THEN
        INSERT INTO log_harga (id_produk, harga_lama, harga_baru, waktu)
        VALUES (OLD.id_produk, OLD.harga, NEW.harga, NOW());
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Hafidh', 'admin@gmail.com', '$2y$10$HNWdeCSnsJOgDc9.wtWjcOfy03RZCSOXmTEJFvhbDgX5ciK8kYfVW', 'admin', '2026-06-16 11:07:23'),
(2, 'Budi Santoso', 'budi.santoso@gmail.com', '$2y$10$HNWdeCSnsJOgDc9.wtWjcOfy03RZCSOXmTEJFvhbDgX5ciK8kYfVW', 'pelanggan', '2026-05-20 08:12:00'),
(3, 'Siti Aminah', 'siti.aminah@gmail.com', '$2y$10$HNWdeCSnsJOgDc9.wtWjcOfy03RZCSOXmTEJFvhbDgX5ciK8kYfVW', 'pelanggan', '2026-05-22 10:45:00'),
(4, 'Andi Wijaya', 'andi.wijaya@gmail.com', '$2y$10$HNWdeCSnsJOgDc9.wtWjcOfy03RZCSOXmTEJFvhbDgX5ciK8kYfVW', 'pelanggan', '2026-05-25 13:30:00'),
(5, 'Dewi Lestari', 'dewi.lestari@gmail.com', '$2y$10$HNWdeCSnsJOgDc9.wtWjcOfy03RZCSOXmTEJFvhbDgX5ciK8kYfVW', 'pelanggan', '2026-05-28 09:05:00'),
(6, 'Rudi Hartono', 'rudi.hartono@gmail.com', '$2y$10$HNWdeCSnsJOgDc9.wtWjcOfy03RZCSOXmTEJFvhbDgX5ciK8kYfVW', 'pelanggan', '2026-06-01 16:20:00'),
(7, 'Maya Putri', 'maya.putri@gmail.com', '$2y$10$HNWdeCSnsJOgDc9.wtWjcOfy03RZCSOXmTEJFvhbDgX5ciK8kYfVW', 'pelanggan', '2026-06-05 11:50:00'),
(8, 'Atiq', 'atiqgodean@gmail.com', '$2y$10$8vEN0BJa4MpLLYLbZiG6HuBCdM.NHLJm/VkhEStdJ4zinGizJ0pPK', 'pelanggan', '2026-06-17 05:04:59'),
(9, 'Dzaki', 'dzaki123@gmail.com', '$2y$10$GaxdY1xuvwflmqoIVUoSZuyROJK1.4AlmpzN.n9ZlnFYRW5jg6UEO', 'pelanggan', '2026-06-17 11:12:45'),
(10, 'ucup', 'ucup@gmail.com', '$2y$10$K9lgk3K8QvQibb3JDoalvOJ0XUj9YFA94VfGSGhYiyH7ID8zJDzAq', 'pelanggan', '2026-06-17 12:00:57');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_katalog_aktif`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_katalog_aktif` (
`id_produk` int(11)
,`nama_produk` varchar(100)
,`nama_kategori` varchar(50)
,`harga` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_ringkasan_pesanan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_ringkasan_pesanan` (
`id_pesanan` int(11)
,`nama_lengkap` varchar(100)
,`tanggal_pesanan` datetime
,`total_pembayaran` decimal(10,2)
,`status` enum('pending','dibayar','selesai','batal')
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_katalog_aktif`
--
DROP TABLE IF EXISTS `v_katalog_aktif`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_katalog_aktif`  AS SELECT `p`.`id_produk` AS `id_produk`, `p`.`nama_produk` AS `nama_produk`, `k`.`nama_kategori` AS `nama_kategori`, `p`.`harga` AS `harga` FROM (`produk_roti` `p` join `kategori_roti` `k` on(`p`.`id_kategori` = `k`.`id_kategori`)) WHERE `p`.`is_tampil` = 1 AND `p`.`stok` > 0 ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_ringkasan_pesanan`
--
DROP TABLE IF EXISTS `v_ringkasan_pesanan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ringkasan_pesanan`  AS SELECT `ps`.`id_pesanan` AS `id_pesanan`, `u`.`nama_lengkap` AS `nama_lengkap`, `ps`.`tanggal_pesanan` AS `tanggal_pesanan`, `ps`.`total_pembayaran` AS `total_pembayaran`, `ps`.`status` AS `status` FROM (`pesanan` `ps` join `users` `u` on(`ps`.`id_user` = `u`.`id_user`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_pesanan` (`id_pesanan`),
  ADD KEY `fk_produk` (`id_produk`);

--
-- Indeks untuk tabel `kategori_roti`
--
ALTER TABLE `kategori_roti`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `log_harga`
--
ALTER TABLE `log_harga`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `fk_user` (`id_user`);

--
-- Indeks untuk tabel `produk_roti`
--
ALTER TABLE `produk_roti`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `fk_kategori_roti` (`id_kategori`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `kategori_roti`
--
ALTER TABLE `kategori_roti`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `log_harga`
--
ALTER TABLE `log_harga`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `produk_roti`
--
ALTER TABLE `produk_roti`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `fk_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk_roti` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk_roti` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `produk_roti`
--
ALTER TABLE `produk_roti`
  ADD CONSTRAINT `fk_kategori_roti` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_roti` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
