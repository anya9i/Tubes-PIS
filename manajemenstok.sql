-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2026 at 10:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manajemenstok`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) GENERATED ALWAYS AS (`jumlah` * `harga_satuan`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_29_122034_create_produk_table', 1),
(5, '2025_12_29_163345_create_pesanan_table', 1),
(6, '2025_12_29_163400_create_detail_pesanan_table', 1),
(7, '2025_12_29_163432_create_stok_table', 1),
(8, '2026_04_26_054216_create_pesanans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_transaksi` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pesan` date NOT NULL DEFAULT curdate(),
  `total_produk` int(11) NOT NULL,
  `total_harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `alamat_pengiriman` text DEFAULT NULL,
  `no_telepon_pengiriman` varchar(20) DEFAULT NULL,
  `status` enum('Dikemas','Dikirim','Diterima') NOT NULL DEFAULT 'Dikemas',
  `payment_url` varchar(255) DEFAULT NULL,
  `payment_status` enum('MENUNGGU','BERHASIL','GAGAL') NOT NULL DEFAULT 'MENUNGGU',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `id_transaksi`, `user_id`, `tanggal_pesan`, `total_produk`, `total_harga`, `alamat_pengiriman`, `no_telepon_pengiriman`, `status`, `payment_url`, `payment_status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'BSR-2026-001', 3, '2026-05-12', 53, 1378726.00, 'Jl. D.I. Panjaitan', '08156882036', 'Dikemas', 'https://app.sandbox.midtrans.com/snap/v2/vtweb/6a031172e65a1', 'MENUNGGU', NULL, '2026-05-12 04:39:30', '2026-05-12 04:39:30'),
(2, 'BSR-2026-002', 4, '2026-05-12', 89, 1693268.00, 'Jl. Bobosan', '082212134312', 'Dikemas', 'https://app.sandbox.midtrans.com/snap/v2/vtweb/6a031172e77c6', 'MENUNGGU', NULL, '2026-05-12 04:39:30', '2026-05-12 04:39:30'),
(3, 'BSR-2026-003', 5, '2026-05-12', 134, 1681551.00, 'Jl. Ahmad Jaelani', '082212134312', 'Dikemas', 'https://app.sandbox.midtrans.com/snap/v2/vtweb/6a031172e822d', 'MENUNGGU', NULL, '2026-05-12 04:39:30', '2026-05-12 04:39:30'),
(4, 'BSR-2026-004', 6, '2026-05-12', 79, 1715469.00, 'Jl. Pramuka', '082212134312', 'Dikemas', 'https://app.sandbox.midtrans.com/snap/v2/vtweb/6a031172e8bd5', 'MENUNGGU', NULL, '2026-05-12 04:39:30', '2026-05-12 04:39:30'),
(5, 'BSR-2026-005', 7, '2026-05-12', 186, 1960691.00, 'Jl. Ahmad Yani', '082212134312', 'Dikemas', 'https://app.sandbox.midtrans.com/snap/v2/vtweb/6a031172ea0de', 'MENUNGGU', NULL, '2026-05-12 04:39:30', '2026-05-12 04:39:30'),
(6, 'BSR-2026-006', 8, '2026-05-12', 176, 1572781.00, 'Jl. Daan Mogot', '082212134312', 'Dikemas', 'https://app.sandbox.midtrans.com/snap/v2/vtweb/6a031172eb24d', 'MENUNGGU', NULL, '2026-05-12 04:39:30', '2026-05-12 04:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `pesanans`
--

CREATE TABLE `pesanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `stok` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `sku`, `harga`, `stok`, `foto`, `deskripsi`, `created_at`) VALUES
(1, 'Es Puter Cup', '120930192391', 5000.00, 100, NULL, 'Es puter legendaris rasa kelapa muda dalam kemasan cup.', '2026-05-12 11:39:30'),
(2, 'Es Krim Cone', '120930192392', 10000.00, 125, NULL, 'Es krim lembut dengan cone renyah.', '2026-05-12 11:39:30'),
(3, 'Es Lilin', '120930192393', 15000.00, 116, NULL, 'Es lilin aneka rasa buah segar.', '2026-05-12 11:39:30'),
(4, 'Es Kotak', '120930192394', 3500.00, 119, NULL, 'Es krim bentuk kotak praktis dan ekonomis.', '2026-05-12 11:39:30'),
(5, 'Es Rujak', '120930192395', 5000.00, 116, NULL, 'Perpaduan unik rasa es krim dan bumbu rujak pedas manis.', '2026-05-12 11:39:30'),
(6, 'Es Kecil', '120930192396', 1500.00, 116, NULL, 'Es krim ukuran mini untuk camilan ringan.', '2026-05-12 11:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `jumlah_baru` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','super admin','reseller') NOT NULL DEFAULT 'reseller',
  `status` varchar(255) NOT NULL DEFAULT 'aktif',
  `jenis_toko` varchar(255) DEFAULT NULL,
  `wilayah` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `status`, `jenis_toko`, `wilayah`, `alamat`, `no_telepon`, `created_at`, `updated_at`) VALUES
(1, 'admin_brasil', '$2y$12$oITJR1igJXLv6QB9H1JUoOEzqGK/Oxm6djL6ec7Xle6kt0UQBbUe2', 'Admin Manajemen', 'admin@gmail.com', 'admin', 'aktif', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'maria_owner', '$2y$12$F61EmMOGbzDkoBK3hxZi4uQ9dEHl07H0r3VXqTObX2nHcqfVucXqK', 'Owner', 'owner@gmail.com', 'super admin', 'aktif', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'duta_agam', '$2y$12$Q0gq791v9ajOIVELUGGt3.CtuC0vsQwmwK6kbM4IUjFcirvfO6Dum', 'Duta Agam', 'dutaagam@gmail.com', 'reseller', 'NON-AKTIF', 'Agen', 'Purwokerto', 'Jl. D.I. Panjaitan', '08156882036', NULL, NULL),
(4, 'sukma_kusuma', '$2y$12$/0OtuyFA5ofjCUGGHHKZ9eM/Yl95Bh.5818HppmHpjHIy17frzAoO', 'Sukma kusuma', 'sukmakusuma@gmail.com', 'reseller', 'non-aktif', 'Reseller', 'Purwokerto', 'Jl. Bobosan', '082212134312', NULL, NULL),
(5, 'cantika_bunga', '$2y$12$oVx55aqLEdF6zW/yTvSg6eGFf7tADunhr2QG939XWtZIsceCoz2yq', 'Cantika Bunga', 'cantikabunga@gmail.com', 'reseller', 'non-aktif', 'Reseller', 'Purwokerto', 'Jl. Ahmad Jaelani', '082212134312', NULL, NULL),
(6, 'akbar_wicaksana', '$2y$12$hdb4M0Qseu8DFj8mm6k4heJCax86ZHR4IJzk/bFXTBofDq9.Q0UPW', 'Akbar Wicaksana', 'akbarwicaksana@gmail.com', 'reseller', 'NON-AKTIF', 'Reseller', 'Purwokerto', 'Jl. Pramuka', '082212134312', NULL, NULL),
(7, 'maria_siregar', '$2y$12$9WaAJrjlUaXIzWcfE4d.B.C/tuXbu5.V58Mq6wvH4Ad7hj8CBOsZm', 'Maria Siregar', 'mariasiregar@gmail.com', 'reseller', 'aktif', 'Agen', 'Purwokerto', 'Jl. Ahmad Yani', '082212134312', NULL, NULL),
(8, 'joko_prabowo', '$2y$12$tT25oKv8zwXHRzawsnskmeIBdRKqw6ArN.WekWuP3r3gy.FsxEdKq', 'Joko Prabowo', 'jokoprabowo@gmail.com', 'reseller', 'aktif', 'Agen', 'Purwokerto', 'Jl. Daan Mogot', '082212134312', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pesanan_id_pesanan_foreign` (`id_pesanan`),
  ADD KEY `detail_pesanan_id_produk_foreign` (`id_produk`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_user_id_foreign` (`user_id`);

--
-- Indexes for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produk_sku_unique` (`sku`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stok_id_produk_foreign` (`id_produk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pesanans`
--
ALTER TABLE `pesanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pesanan_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
