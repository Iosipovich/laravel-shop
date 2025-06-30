<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained();
        $table->json('items');
        $table->decimal('total', 8, 2);
        $table->string('status')->default('pending');
        $table->string('name');
        $table->string('email');
        $table->string('address');
        $table->timestamps();
    });
}
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};