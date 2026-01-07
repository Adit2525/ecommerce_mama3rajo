-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jan 2026 pada 13.25
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mama_hijab`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `diskon`
--

CREATE TABLE `diskon` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tipe` enum('persen','nominal') NOT NULL,
  `nilai` int(11) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `diskon`
--

INSERT INTO `diskon` (`id`, `nama`, `tipe`, `nilai`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'diskon ramadhan', 'persen', 30, 1, '2026-01-03 06:09:00', '2026-01-03 06:09:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `slug`, `gambar`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'motif baru', 'motif-baru', 'kategori/pp0BdBraPiNabcYgwztxR58B3xjwNrOicIvEu3WD.jpg', 1, '2026-01-03 02:45:47', '2026-01-03 05:40:50'),
(5, 'motif payakumbuh', 'motif-payakumbuh', 'kategori/mBAjOvifvp4lti8bG7nZv0OfNfid0dCl3TbpKB1R.jpg', 1, '2026-01-06 03:15:02', '2026-01-06 03:15:02'),
(6, 'motif pesisir selatan', 'motif-pesisir-selatan', 'kategori/bpku4eDsiItu5CU0be9zB2ckTl6oXnx9IVecKJYv.jpg', 1, '2026-01-06 03:15:25', '2026-01-06 03:15:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_22_073747_create_kategori_table', 1),
(5, '2025_12_22_073748_create_diskon_table', 1),
(6, '2025_12_22_073748_create_produk_table', 1),
(7, '2025_12_22_073749_create_produk_diskon_table', 1),
(8, '2025_12_22_073750_create_pesanan_table', 1),
(9, '2025_12_22_073751_add_role_to_users_table', 1),
(10, '2025_12_22_073751_create_pesanan_detail_table', 1),
(11, '2026_01_03_082021_add_gambar_to_kategori_table', 2),
(12, '2026_01_04_000001_add_shipping_fields_to_pesanan_table', 3),
(13, '2026_01_04_000002_add_payment_to_pesanan_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kode_pesanan` varchar(255) NOT NULL,
  `nama_penerima` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(255) DEFAULT NULL,
  `jarak` decimal(8,2) DEFAULT NULL,
  `ongkir` int(11) NOT NULL DEFAULT 0,
  `metode_pembayaran` varchar(255) NOT NULL DEFAULT 'transfer',
  `bank` varchar(255) DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `status_pembayaran` enum('belum_bayar','sudah_bayar','verifikasi') NOT NULL DEFAULT 'belum_bayar',
  `total_harga` int(11) NOT NULL,
  `status` enum('pending','diproses','dikirim','selesai') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `kode_pesanan`, `nama_penerima`, `no_telp`, `alamat`, `kota`, `kode_pos`, `jarak`, `ongkir`, `metode_pembayaran`, `bank`, `no_rekening`, `status_pembayaran`, `total_harga`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'ORD-U6VVRDQI', 'sriwahyuni', '081292389075', 'sungai talang', 'padang panjang', '555', 3.00, 15000, 'transfer', NULL, NULL, 'belum_bayar', 65000, 'diproses', '2026-01-03 05:35:43', '2026-01-03 05:39:01'),
(2, 3, 'ORD-YA8FSVSJ', 'User Hijab Mama', '081292389075', 'padang', 'Jakarta Barat', '555', 10.00, 50000, 'transfer', 'Mandiri', NULL, 'belum_bayar', 100000, 'selesai', '2026-01-06 03:02:58', '2026-01-06 03:07:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pesanan_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id`, `pesanan_id`, `produk_id`, `jumlah`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 50000, 50000, '2026-01-03 05:35:43', '2026-01-03 05:35:43'),
(2, 2, 3, 1, 50000, 50000, '2026-01-06 03:02:58', '2026-01-06 03:02:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `harga_coret` int(11) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `kategori_id`, `nama`, `slug`, `deskripsi`, `harga`, `harga_coret`, `stok`, `gambar`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 4, 'hijab baru', 'hijab-baru', 'asdfghjkl', 50000, 100000, 2, 'produk/b70wDSoz8QKCB3dLJSgAKqrXncK4IesEPlWJkFyr.jpg', 1, '2026-01-03 05:32:40', '2026-01-06 03:02:58'),
(4, 4, 'sdfghjk', 'sdfghjk', 'dfghj', 45000, 8000, 3, 'produk/5rpbr7jPycatdk8mIZs5OfPCO1paVutc68dKwN4P.jpg', 1, '2026-01-06 03:13:40', '2026-01-06 03:13:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_diskon`
--

CREATE TABLE `produk_diskon` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `diskon_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3D0welBDYDqdNN39OTPBORXlHE94VAcYRECvwnBP', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRkdXbk0zVFkxQ2o3NFd5YXJzRHFWd2huZ2YydE5NTjIyT1NnQzFtUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWsva2F0ZWdvcmkvbW90aWYtcGF5YWt1bWJ1aCI7czo1OiJyb3V0ZSI7czoxNToicHJvZHVrLmthdGVnb3JpIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1767694812),
('Lcjy5qDcTYq1yOAJXNop9BYzDDI2mlqjTmrlx7m2', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmJCOXd6Y1BjQ2ZndmFHYlNjNkhDZW5uZ0h1eEczdnVBTm5sZ2VUSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1767454043),
('LE9Ewx0Ka5YweSGO3EL1RVZrI5dnQG9oKRM6Fx3M', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiekZwMHdpTlN2UlI5VkVPb21sbDR1VHdodEpIN3NEdEp5Ukp5ZHJSMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767443605),
('PlbVnw2ma05topWH5iKqMPOeqxqtpwm1wKQgM0N7', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQzhOQWtZdVpqdFcyMDZlUGZOZ29OUnFDYkxoZThYWHBrUTJqT0JXNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czoxNDoiY2hlY2tvdXQuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O3M6OToia2VyYW5qYW5nIjthOjE6e2k6MzthOjY6e3M6OToicHJvZHVrX2lkIjtpOjM7czo0OiJuYW1hIjtzOjEwOiJoaWphYiBiYXJ1IjtzOjU6ImhhcmdhIjtpOjUwMDAwO3M6NjoianVtbGFoIjtpOjE7czo4OiJzdWJ0b3RhbCI7aTo1MDAwMDtzOjY6ImdhbWJhciI7czo1MToicHJvZHVrL2I3MHdEU296OFFLQ0IzZExKU2dBS3FyWG5jSzRJZXNFUGxXSmtGeXIuanBnIjt9fX0=', 1767456208);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Admin Hijab Mama', 'admin@hijabmama.com', 'admin', NULL, '$2y$12$v3tZVR1HTveXVS2aipuyhuibo6yj7bnn4p0QXNt5HobtMtYPAagPW', NULL, '2025-12-31 20:50:34', '2025-12-31 20:50:34'),
(3, 'User Hijab Mama', 'user@hijabmama.com', 'customer', NULL, '$2y$12$TOdSDqkabHxpECcYg3Zy7uLO2LBKHbwB3GoECSftkiiq4wVnkT8ui', NULL, '2025-12-31 20:50:35', '2025-12-31 20:50:35'),
(4, 'sriwahyuni', 'sri@gmail.com', 'customer', NULL, '$2y$12$WRkup/cRa59Bvmo9Jub8gu7Pkpcfj3exQ6ZypPTL5gvKs8awOaUpu', NULL, '2026-01-03 05:34:10', '2026-01-03 05:34:10');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `diskon`
--
ALTER TABLE `diskon`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_slug_unique` (`slug`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pesanan_kode_pesanan_unique` (`kode_pesanan`),
  ADD KEY `pesanan_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_detail_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `pesanan_detail_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produk_slug_unique` (`slug`),
  ADD KEY `produk_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `produk_diskon`
--
ALTER TABLE `produk_diskon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_diskon_produk_id_foreign` (`produk_id`),
  ADD KEY `produk_diskon_diskon_id_foreign` (`diskon_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `diskon`
--
ALTER TABLE `diskon`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `produk_diskon`
--
ALTER TABLE `produk_diskon`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_detail_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk_diskon`
--
ALTER TABLE `produk_diskon`
  ADD CONSTRAINT `produk_diskon_diskon_id_foreign` FOREIGN KEY (`diskon_id`) REFERENCES `diskon` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_diskon_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
