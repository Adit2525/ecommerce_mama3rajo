<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('reference_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->unsignedBigInteger('recorded_by')->nullable()->index();
            $table->text('note')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemasukan');
    }
};
