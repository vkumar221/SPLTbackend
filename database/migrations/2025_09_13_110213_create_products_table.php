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
            $table->bigIncrements('product_id');
            $table->string('product_name',255);
            $table->string('product_slug',255);
            $table->integer('product_brand')->default(1);
            $table->integer('product_category')->default(1);
            $table->integer('product_vendor')->default(1);
            $table->integer('product_country')->default(1);
            $table->string('product_tags',255)->nullable();
            $table->string('product_sku',255);
            $table->string('product_image',255)->nullable();
            $table->string('product_warranty',255)->nullable();
            $table->integer('product_stock')->default(0);
            $table->string('product_price')->default(0);
            $table->string('product_offer_price')->default(0);
            $table->text('product_description')->nullable();
            $table->integer('product_status')->default(1);
            $table->integer('product_trash')->default(0);
            $table->timestamp('product_added_on')->useCurrent();
            $table->integer('product_added_by')->default(1);
            $table->timestamp('product_updated_on')->useCurrent();
            $table->integer('product_updated_by')->default(1);
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
