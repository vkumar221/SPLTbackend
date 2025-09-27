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
        Schema::create('workouts', function (Blueprint $table) {
            $table->bigIncrements('workout_id');
            $table->string('workout_name')->unique();
            $table->integer('workout_type')->default(1);
            $table->integer('workout_equipment')->default(1);
            $table->integer('workout_muscle_group')->default(1);
            $table->integer('workout_other_muscle')->default(0);
            $table->integer('workout_category')->default(1);
            $table->text('workout_instruction')->nullable();
            $table->string('workout_image')->nullable();
            $table->string('workout_vimeo')->nullable();
            $table->string('workout_youtube')->nullable();
            $table->integer('workout_status')->default(1);
            $table->integer('workout_trash')->default(0);
            $table->integer('workout_added_role')->default(1);
            $table->timestamp('workout_added_on')->useCurrent();
            $table->integer('workout_added_by')->default(1);
            $table->timestamp('workout_updated_on')->useCurrent();
            $table->integer('workout_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
