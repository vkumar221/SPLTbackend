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
        Schema::create('user_goals', function (Blueprint $table) {
            $table->bigIncrements('user_goal_id');
            $table->string('user_goal_name');
            $table->integer('user_goal_user');
            $table->integer('user_goal_type');
            $table->integer('user_goal_duration');
            $table->string('user_goal_weight');
            $table->string('user_goal_weight_target')->nullable();
            $table->string('user_goal_weight_duration')->nullable();
            $table->string('user_goal_fat')->nullable();
            $table->string('user_goal_fat_target')->nullable();
            $table->string('user_goal_fat_duration')->nullable();
            $table->string('user_goal_muscle')->nullable();
            $table->string('user_goal_muscle_current')->nullable();
            $table->string('user_goal_muscle_target')->nullable();
            $table->string('user_goal_muscle_duration')->nullable();
            $table->integer('user_goal_status')->default(1);
            $table->integer('user_goal_trash')->default(0);
            $table->timestamp('user_goal_role')->useCurrent();
            $table->timestamp('user_goal_added_on')->useCurrent();
            $table->integer('user_goal_added_by')->default(1);
            $table->timestamp('user_goal_updated_on')->useCurrent();
            $table->integer('user_goal_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_goals');
    }
};
