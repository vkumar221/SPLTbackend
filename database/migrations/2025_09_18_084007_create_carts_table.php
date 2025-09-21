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
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('cart_id');
            $table->integer('cart_product')->default(1);
            $table->string('cart_name')->nullable();
            $table->string('cart_offer_price')->nullable();
            $table->string('cart_price')->nullable();
            $table->integer('cart_quantity')->default(1);
            $table->integer('cart_variant')->default(0);
            $table->integer('cart_user')->default(0);
            $table->timestamp('cart_added_on')->useCurrent();
            $table->integer('cart_added_by')->default(1);
            $table->timestamp('cart_updated_on')->useCurrent();
            $table->integer('cart_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
