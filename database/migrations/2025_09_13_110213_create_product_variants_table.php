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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('product_variant_id');
            $table->integer('product_variant_product')->default(1);
            $table->integer('product_variant_attribute')->default(1);
            $table->string('product_variant_name',255);
            $table->integer('product_variant_stock')->default(0);
            $table->integer('product_variant_sale')->default(0);
            $table->string('product_variant_image',255)->nullable();
            $table->string('product_variant_price')->default(0);
            $table->string('product_variant_offer_price')->default(0);
            $table->integer('product_variant_status')->default(1);
            $table->integer('product_variant_trash')->default(0);
            $table->timestamp('product_variant_added_on')->useCurrent();
            $table->integer('product_variant_added_by')->default(1);
            $table->timestamp('product_variant_updated_on')->useCurrent();
            $table->integer('product_variant_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
