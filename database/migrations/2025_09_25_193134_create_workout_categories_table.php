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
        Schema::create('workout_categories', function (Blueprint $table) {
            $table->bigIncrements('workout_category_id');
            $table->string('workout_category_name')->unique();
            $table->string('workout_category_slug')->unique();
            $table->text('workout_category_image')->nullable();
            $table->text('workout_category_cover_image')->nullable();
            $table->text('workout_category_feature_image')->nullable();
            $table->text('workout_category_description')->nullable();
            $table->integer('workout_category_status')->default(1);
            $table->integer('workout_category_trash')->default(0);
            $table->timestamp('workout_category_added_on')->useCurrent();
            $table->integer('workout_category_added_by')->default(1);
            $table->timestamp('workout_category_updated_on')->useCurrent();
            $table->integer('workout_category_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_categories');
    }
};
