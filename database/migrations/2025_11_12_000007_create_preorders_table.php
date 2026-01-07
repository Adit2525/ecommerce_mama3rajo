<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('preorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->integer('qty')->default(1);
            $table->date('expected_ship_date')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('preorders');
    }
};
