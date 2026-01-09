-- ========================================
-- MAMA3RAJO E-COMMERCE DATABASE
-- SQL Import untuk Hosting
-- Generated: 9 Januari 2026
-- ========================================
-- CATATAN: Jalankan SQL ini di phpMyAdmin hosting
-- Pastikan sudah memilih database yang benar (atug7379_ecommerce_3rajo)
-- ========================================

SET FOREIGN_KEY_CHECKS = 0;

-- ========================================
-- 1. TABEL USERS (Laravel Default)
-- ========================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `role` VARCHAR(255) DEFAULT 'customer',
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 2. TABEL PASSWORD RESET TOKENS
-- ========================================
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 3. TABEL SESSIONS
-- ========================================
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
    `id` VARCHAR(255) PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 4. TABEL CACHE (Laravel)
-- ========================================
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
    `key` VARCHAR(255) PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 5. TABEL JOBS (Laravel Queue)
-- ========================================
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
    `id` VARCHAR(255) PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 6. TABEL KATEGORI
-- ========================================
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `gambar` VARCHAR(255) NULL,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 7. TABEL PRODUK
-- ========================================
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `kategori_id` BIGINT UNSIGNED NOT NULL,
    `nama` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `deskripsi` TEXT NOT NULL,
    `harga` INT NOT NULL,
    `harga_coret` INT NULL,
    `stok` INT DEFAULT 0,
    `gambar` VARCHAR(255) NULL,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 8. TABEL DISKON
-- ========================================
DROP TABLE IF EXISTS `diskon`;
CREATE TABLE `diskon` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(255) NOT NULL,
    `tipe` ENUM('persen', 'nominal') NOT NULL,
    `nilai` INT NOT NULL,
    `aktif` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 9. TABEL PRODUK_DISKON (Pivot)
-- ========================================
DROP TABLE IF EXISTS `produk_diskon`;
CREATE TABLE `produk_diskon` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `produk_id` BIGINT UNSIGNED NOT NULL,
    `diskon_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    CONSTRAINT `produk_diskon_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk`(`id`) ON DELETE CASCADE,
    CONSTRAINT `produk_diskon_diskon_id_foreign` FOREIGN KEY (`diskon_id`) REFERENCES `diskon`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 10. TABEL PESANAN
-- ========================================
DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `kode_pesanan` VARCHAR(255) NOT NULL UNIQUE,
    `nama_penerima` VARCHAR(255) NULL,
    `no_telp` VARCHAR(255) NULL,
    `alamat` TEXT NULL,
    `kota` VARCHAR(255) NULL,
    `kode_pos` VARCHAR(255) NULL,
    `jarak` DECIMAL(8,2) NULL,
    `ongkir` INT DEFAULT 0,
    `metode_pembayaran` VARCHAR(255) DEFAULT 'transfer',
    `bank` VARCHAR(255) NULL,
    `no_rekening` VARCHAR(255) NULL,
    `status_pembayaran` ENUM('belum_bayar', 'sudah_bayar', 'verifikasi', 'lunas', 'menunggu_pembayaran') DEFAULT 'belum_bayar',
    `total_harga` INT NOT NULL,
    `status` VARCHAR(50) DEFAULT 'pending',
    `bukti_pembayaran` VARCHAR(255) NULL,
    `tanggal_pembayaran` TIMESTAMP NULL,
    `bank_tujuan` VARCHAR(255) NULL,
    `catatan_pembayaran` TEXT NULL,
    `catatan` TEXT NULL,
    `snap_token` VARCHAR(255) NULL,
    `midtrans_order_id` VARCHAR(255) NULL,
    `midtrans_transaction_id` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    CONSTRAINT `pesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 11. TABEL PESANAN_DETAIL
-- ========================================
DROP TABLE IF EXISTS `pesanan_detail`;
CREATE TABLE `pesanan_detail` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `pesanan_id` BIGINT UNSIGNED NOT NULL,
    `produk_id` BIGINT UNSIGNED NOT NULL,
    `jumlah` INT NOT NULL,
    `harga_satuan` INT NOT NULL,
    `subtotal` INT NOT NULL,
    `warna` VARCHAR(255) NULL,
    `ukuran` VARCHAR(255) NULL,
    `catatan_custom` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    CONSTRAINT `pesanan_detail_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan`(`id`) ON DELETE CASCADE,
    CONSTRAINT `pesanan_detail_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 12. TABEL PROMOSI
-- ========================================
DROP TABLE IF EXISTS `promosi`;
CREATE TABLE `promosi` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `judul` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT NULL,
    `gambar` VARCHAR(255) NULL,
    `tanggal_mulai` DATE NULL,
    `tanggal_berakhir` DATE NULL,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 13. TABEL MIGRATIONS (Laravel Internal)
-- ========================================
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert migration records
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2025_11_12_000001_add_role_to_users', 1),
('2026_01_06_124047_create_ecommerce_3rajo_tables', 1),
('2026_01_06_185539_add_warna_ukuran_to_pesanan_detail_table', 1),
('2026_01_06_194805_add_payment_fields_to_pesanan_table', 1),
('2026_01_06_200039_add_catatan_to_pesanan_table', 1),
('2026_01_06_201114_modify_status_column_in_pesanan_table', 1),
('2026_01_06_212545_create_promotions_table', 1),
('2026_01_08_133417_add_midtrans_fields_to_pesanan_table', 1),
('2026_01_09_044900_modify_status_pembayaran_column_in_pesanan_table', 1);

-- ========================================
-- 14. INSERT ADMIN USER (Password: admin123)
-- ========================================
INSERT INTO `users` (`name`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
('Admin', 'admin@mama3rajo.com', 'admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;

-- ========================================
-- IMPORT SELESAI!
-- ========================================
-- User Admin:
-- Email: admin@mama3rajo.com
-- Password: password (default Laravel hash)
-- ========================================
