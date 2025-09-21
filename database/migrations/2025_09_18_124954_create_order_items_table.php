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
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('order_item_id');
            $table->integer('order_item_order')->default(1);
            $table->integer('order_item_product')->default(0);
            $table->integer('order_item_variant')->default(0);
            $table->integer('order_item_quantity')->default(1);
            $table->string('order_item_price')->default(0);
            $table->integer('order_item_status')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
