<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kategori Table
        if (!Schema::hasTable('kategori')) {
            Schema::create('kategori', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('slug')->unique();
                $table->string('gambar')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Produk Table
        if (!Schema::hasTable('produk')) {
            Schema::create('produk', function (Blueprint $table) {
                $table->id();
                $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
                $table->string('nama');
                $table->string('slug')->unique();
                $table->text('deskripsi');
                $table->integer('harga');
                $table->integer('harga_coret')->nullable();
                $table->integer('stok')->default(0);
                $table->string('gambar')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Diskon Table
        if (!Schema::hasTable('diskon')) {
            Schema::create('diskon', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->enum('tipe', ['persen', 'nominal']);
                $table->integer('nilai');
                $table->boolean('aktif')->default(true);
                $table->timestamps();
            });
        }

        // Produk Diskon Table
        if (!Schema::hasTable('produk_diskon')) {
            Schema::create('produk_diskon', function (Blueprint $table) {
                $table->id();
                $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
                $table->foreignId('diskon_id')->constrained('diskon')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Pesanan Table
        if (!Schema::hasTable('pesanan')) {
            Schema::create('pesanan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('kode_pesanan')->unique();
                $table->string('nama_penerima')->nullable();
                $table->string('no_telp')->nullable();
                $table->text('alamat')->nullable();
                $table->string('kota')->nullable();
                $table->string('kode_pos')->nullable();
                $table->decimal('jarak', 8, 2)->nullable();
                $table->integer('ongkir')->default(0);
                $table->string('metode_pembayaran')->default('transfer');
                $table->string('bank')->nullable();
                $table->string('no_rekening')->nullable();
                $table->enum('status_pembayaran', ['belum_bayar', 'sudah_bayar', 'verifikasi'])->default('belum_bayar');
                $table->integer('total_harga');
                $table->enum('status', ['pending', 'diproses', 'dikirim', 'selesai', 'batal'])->default('pending');
                $table->timestamps();
            });
        }

        // Pesanan Detail Table
        if (!Schema::hasTable('pesanan_detail')) {
            Schema::create('pesanan_detail', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
                $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
                $table->integer('jumlah');
                $table->integer('harga_satuan');
                $table->integer('subtotal');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_detail');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('produk_diskon');
        Schema::dropIfExists('diskon');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('kategori');
    }
};
