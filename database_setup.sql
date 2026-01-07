-- SQL Setup for ecommerce_3rajo
-- Based on mama_hijab.sql

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Admin Hijab Mama', 'admin@hijabmama.com', 'admin', NULL, '$2y$12$v3tZVR1HTveXVS2aipuyhuibo6yj7bnn4p0QXNt5HobtMtYPAagPW', NULL, '2025-12-31 20:50:34', '2025-12-31 20:50:34'),
(3, 'User Hijab Mama', 'user@hijabmama.com', 'customer', NULL, '$2y$12$TOdSDqkabHxpECcYg3Zy7uLO2LBKHbwB3GoECSftkiiq4wVnkT8ui', NULL, '2025-12-31 20:50:35', '2025-12-31 20:50:35'),
(4, 'sriwahyuni', 'sri@gmail.com', 'customer', NULL, '$2y$12$WRkup/cRa59Bvmo9Jub8gu7Pkpcfj3exQ6ZypPTL5gvKs8awOaUpu', NULL, '2026-01-03 05:34:10', '2026-01-03 05:34:10');

--
-- Struktur dari tabel `kategori`
--

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kategori` (`id`, `nama`, `slug`, `gambar`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'motif baru', 'motif-baru', 'kategori/pp0BdBraPiNabcYgwztxR58B3xjwNrOicIvEu3WD.jpg', 1, '2026-01-03 02:45:47', '2026-01-03 05:40:50'),
(5, 'motif payakumbuh', 'motif-payakumbuh', 'kategori/mBAjOvifvp4lti8bG7nZv0OfNfid0dCl3TbpKB1R.jpg', 1, '2026-01-06 03:15:02', '2026-01-06 03:15:02'),
(6, 'motif pesisir selatan', 'motif-pesisir-selatan', 'kategori/bpku4eDsiItu5CU0be9zB2ckTl6oXnx9IVecKJYv.jpg', 1, '2026-01-06 03:15:25', '2026-01-06 03:15:25');

--
-- Struktur dari tabel `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produk_slug_unique` (`slug`),
  KEY `produk_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `produk` (`id`, `kategori_id`, `nama`, `slug`, `deskripsi`, `harga`, `harga_coret`, `stok`, `gambar`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 4, 'hijab baru', 'hijab-baru', 'asdfghjkl', 50000, 100000, 2, 'produk/b70wDSoz8QKCB3dLJSgAKqrXncK4IesEPlWJkFyr.jpg', 1, '2026-01-03 05:32:40', '2026-01-06 03:02:58'),
(4, 4, 'sdfghjk', 'sdfghjk', 'dfghj', 45000, 8000, 3, 'produk/5rpbr7jPycatdk8mIZs5OfPCO1paVutc68dKwN4P.jpg', 1, '2026-01-06 03:13:40', '2026-01-06 03:13:40');

--
-- Struktur dari tabel `pesanan`
--

DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pesanan_kode_pesanan_unique` (`kode_pesanan`),
  KEY `pesanan_user_id_foreign` (`user_id`),
  CONSTRAINT `pesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pesanan` (`id`, `user_id`, `kode_pesanan`, `nama_penerima`, `no_telp`, `alamat`, `kota`, `kode_pos`, `jarak`, `ongkir`, `metode_pembayaran`, `bank`, `no_rekening`, `status_pembayaran`, `total_harga`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'ORD-U6VVRDQI', 'sriwahyuni', '081292389075', 'sungai talang', 'padang panjang', '555', 3.00, 15000, 'transfer', NULL, NULL, 'belum_bayar', 65000, 'diproses', '2026-01-03 05:35:43', '2026-01-03 05:39:01'),
(2, 3, 'ORD-YA8FSVSJ', 'User Hijab Mama', '081292389075', 'padang', 'Jakarta Barat', '555', 10.00, 50000, 'transfer', 'Mandiri', NULL, 'belum_bayar', 100000, 'selesai', '2026-01-06 03:02:58', '2026-01-06 03:07:35');

--
-- Struktur dari tabel `pesanan_detail`
--

DROP TABLE IF EXISTS `pesanan_detail`;
CREATE TABLE `pesanan_detail` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pesanan_detail_pesanan_id_foreign` (`pesanan_id`),
  KEY `pesanan_detail_produk_id_foreign` (`produk_id`),
  CONSTRAINT `pesanan_detail_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pesanan_detail_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pesanan_detail` (`id`, `pesanan_id`, `produk_id`, `jumlah`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 50000, 50000, '2026-01-03 05:35:43', '2026-01-03 05:35:43'),
(2, 2, 3, 1, 50000, 50000, '2026-01-06 03:02:58', '2026-01-06 03:02:58');

--
-- Struktur dari tabel `diskon`
--
DROP TABLE IF EXISTS `diskon`;
CREATE TABLE `diskon` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `tipe` enum('persen','nominal') NOT NULL,
  `nilai` int(11) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `diskon` (`id`, `nama`, `tipe`, `nilai`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'diskon ramadhan', 'persen', 30, 1, '2026-01-03 06:09:00', '2026-01-03 06:09:00');

--
-- Struktur dari tabel `produk_diskon`
--
DROP TABLE IF EXISTS `produk_diskon`;
CREATE TABLE `produk_diskon` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `diskon_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produk_diskon_produk_id_foreign` (`produk_id`),
  KEY `produk_diskon_diskon_id_foreign` (`diskon_id`),
  CONSTRAINT `produk_diskon_diskon_id_foreign` FOREIGN KEY (`diskon_id`) REFERENCES `diskon` (`id`) ON DELETE CASCADE,
  CONSTRAINT `produk_diskon_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Other standard tables (migrations, cache, jobs, etc.) omitted for brevity but recommended to keep default Laravel migrations for them.

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
