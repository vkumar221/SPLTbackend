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
        Schema::create('attributes', function (Blueprint $table) {
            $table->bigIncrements('attribute_id');
            $table->string('attribute_name')->nullable();
            $table->string('attribute_type')->nullable();
            $table->integer('attribute_category')->default(1);
            $table->integer('attribute_status')->default(1);
            $table->integer('attribute_trash')->default(0);
            $table->timestamp('attribute_added_on')->useCurrent();
            $table->integer('attribute_added_by')->default(1);
            $table->timestamp('attribute_updated_on')->useCurrent();
            $table->integer('attribute_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
