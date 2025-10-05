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
        Schema::create('workout_plan_exercises', function (Blueprint $table) {
            $table->bigIncrements('workout_plan_exercise_id');
            $table->integer('workout_plan_plan')->default(1);
            $table->integer('workout_plan_exercise')->default(1);
            $table->string('workout_plan_exercise_sets')->nullable();
            $table->string('workout_plan_exercise_reps')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_plan_exercises');
    }
};
