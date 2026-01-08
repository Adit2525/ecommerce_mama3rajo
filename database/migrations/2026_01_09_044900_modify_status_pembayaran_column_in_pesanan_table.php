<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change status_pembayaran from ENUM to string to allow more flexibility
        // or add 'lunas' and 'menunggu_pembayaran' to the ENUM
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status_pembayaran ENUM('belum_bayar', 'sudah_bayar', 'verifikasi', 'lunas', 'menunggu_pembayaran') DEFAULT 'belum_bayar'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status_pembayaran ENUM('belum_bayar', 'sudah_bayar', 'verifikasi') DEFAULT 'belum_bayar'");
    }
};
