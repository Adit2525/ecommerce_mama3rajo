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
            $table->string('snap_token')->nullable()->after('catatan_pembayaran');
            $table->string('midtrans_order_id')->nullable()->after('snap_token');
            $table->string('midtrans_transaction_id')->nullable()->after('midtrans_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_order_id', 'midtrans_transaction_id']);
        });
    }
};
