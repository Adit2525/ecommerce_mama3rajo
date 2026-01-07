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
        Schema::table('pesanan_detail', function (Blueprint $table) {
            $table->string('warna')->nullable()->after('subtotal');
            $table->string('ukuran')->nullable()->after('warna');
            $table->text('catatan_custom')->nullable()->after('ukuran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan_detail', function (Blueprint $table) {
            $table->dropColumn(['warna', 'ukuran', 'catatan_custom']);
        });
    }
};
