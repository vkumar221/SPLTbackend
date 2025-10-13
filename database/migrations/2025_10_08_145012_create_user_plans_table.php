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
        Schema::create('user_plans', function (Blueprint $table) {
            $table->bigIncrements('user_plan_id');
            $table->integer('user_plan');
            $table->integer('user_plan_type')->default(1);
            $table->string('user_plan_price')->default(0);
            $table->integer('user_plan_payment')->default(1);
            $table->integer('user_plan_user');
            $table->string('user_plan_expiry')->nullable();
            $table->integer('user_plan_status')->default(1);
            $table->timestamp('user_plan_added_on')->useCurrent();
            $table->integer('user_plan_added_by')->default(1);
            $table->timestamp('user_plan_updated_on')->useCurrent();
            $table->integer('user_plan_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plans');
    }
};
