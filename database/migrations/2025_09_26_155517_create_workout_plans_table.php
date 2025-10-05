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
        Schema::create('workout_plans', function (Blueprint $table) {
            $table->bigIncrements('workout_plan_id');
            $table->string('workout_plan_name')->unique();
            $table->integer('workout_plan_category')->default(1);
            $table->string('workout_plan_duration')->nullable();
            $table->string('workout_plan_goal')->nullable();
            $table->string('workout_plan_days')->nullable();
            $table->text('workout_plan_note')->nullable();
            $table->integer('workout_plan_status')->default(1);
            $table->integer('workout_plan_trash')->default(0);
            $table->integer('workout_plan_added_role')->default(1);
            $table->timestamp('workout_plan_added_on')->useCurrent();
            $table->integer('workout_plan_added_by')->default(1);
            $table->timestamp('workout_plan_updated_on')->useCurrent();
            $table->integer('workout_plan_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
