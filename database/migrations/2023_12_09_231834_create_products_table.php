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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->string('description');
            $table->integer('price');
            $table->boolean('in_stock');
            $table->unsignedBigInteger('order_id');
            $table->timestamps();

            $table->index('order_id'); // Add this line

            $table->foreign('order_id')->references('order_id')->on('orders')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
