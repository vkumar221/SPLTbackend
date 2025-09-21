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
        Schema::create('attribute_variations', function (Blueprint $table) {
            $table->bigIncrements('attribute_variation_id');
            $table->string('attribute_variation_name')->nullable();
            $table->integer('attribute_variation_attribute')->default(0);
            $table->string('attribute_variation_value')->nullable();
            $table->integer('attribute_variation_status')->default(1);
            $table->integer('attribute_variation_trash')->default(0);
            $table->timestamp('attribute_variation_added_on')->useCurrent();
            $table->integer('attribute_variation_added_by')->default(1);
            $table->timestamp('attribute_variation_updated_on')->useCurrent();
            $table->integer('attribute_variation_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_variations');
    }
};
