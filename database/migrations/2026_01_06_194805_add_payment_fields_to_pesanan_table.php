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
            if (!Schema::hasColumn('pesanan', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->after('status');
            }
            if (!Schema::hasColumn('pesanan', 'tanggal_pembayaran')) {
                $table->timestamp('tanggal_pembayaran')->nullable()->after('metode_pembayaran');
            }
            if (!Schema::hasColumn('pesanan', 'bank_tujuan')) {
                $table->string('bank_tujuan')->nullable()->after('tanggal_pembayaran');
            }
            if (!Schema::hasColumn('pesanan', 'catatan_pembayaran')) {
                $table->text('catatan_pembayaran')->nullable()->after('bank_tujuan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $columns = ['bukti_pembayaran', 'tanggal_pembayaran', 'bank_tujuan', 'catatan_pembayaran'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('pesanan', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
