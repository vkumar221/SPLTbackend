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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->bigIncrements('product_review_id');
            $table->integer('product_review_order')->default(1);
            $table->integer('product_review_item')->default(1);
            $table->integer('product_review_rating')->default(0);
            $table->text('product_review_comment')->nullable();
            $table->integer('product_review_status')->default(1);
            $table->timestamp('product_review_added_on')->useCurrent();
            $table->integer('product_review_added_by')->default(1);
            $table->timestamp('product_review_updated_on')->useCurrent();
            $table->integer('product_review_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
