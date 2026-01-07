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
        Schema::table('pesanan', function (Blueprint $table) {
            // Modify status column to be string(50) to accommodate longer status strings like 'menunggu_verifikasi'
            $table->string('status', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Revert back to string(20) or whatever it was (assuming standard short string)
            // If it was enum, we might need raw SQL, but usually string change is safe for down if data fits
            $table->string('status', 20)->change(); 
        });
    }
};
