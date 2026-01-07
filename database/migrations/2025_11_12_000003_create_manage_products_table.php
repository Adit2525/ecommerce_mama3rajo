<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('manage_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('action');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('manage_products');
    }
};
