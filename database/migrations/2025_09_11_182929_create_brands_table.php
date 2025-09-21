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
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('brand_id');
            $table->string('brand_name')->unique();
            $table->string('brand_slug')->unique();
            $table->text('brand_image')->nullable();
            $table->integer('brand_category')->default(1);
            $table->text('brand_cover_image')->nullable();
            $table->text('brand_description')->nullable();
            $table->integer('brand_status')->default(1);
            $table->integer('brand_trash')->default(0);
            $table->timestamp('brand_added_on')->useCurrent();
            $table->integer('brand_added_by')->default(1);
            $table->timestamp('brand_updated_on')->useCurrent();
            $table->integer('brand_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
