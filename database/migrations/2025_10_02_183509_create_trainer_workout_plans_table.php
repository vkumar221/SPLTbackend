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
        Schema::create('trainer_workout_plans', function (Blueprint $table) {
            $table->bigIncrements('trainer_workout_plan_id');
            $table->integer('trainer_workout_plan')->default(1);
            $table->integer('trainer_workout_trainer')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_workout_plans');
    }
};
