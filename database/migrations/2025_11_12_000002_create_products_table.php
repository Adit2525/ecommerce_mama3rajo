<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable()->unique();
            $table->string('name');
            $table->string('slug')->nullable()->index();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('cost_price', 12, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('weight', 8, 2)->nullable();
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->string('status')->default('active')->index();
            $table->json('images')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
