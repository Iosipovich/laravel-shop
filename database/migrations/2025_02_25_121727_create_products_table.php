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
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 8, 2);
        $table->decimal('discount_price')->nullable();
        $table->string('brand');
        $table->json('specs'); // Характеристики (память, экран и т.д.)
        $table->string('image');
        $table->foreignId('category_id')->constrained();
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('products');
    }
};