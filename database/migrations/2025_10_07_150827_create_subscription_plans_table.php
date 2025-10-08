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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->bigIncrements('subscription_plan_id');
            $table->string('subscription_plan_title');
            $table->string('subscription_plan_price')->nullable();
            $table->string('subscription_plan_discount')->nullable();
            $table->string('subscription_plan_image')->nullable();
            $table->text('subscription_plan_description')->nullable();
            $table->string('subscription_plan_popular')->nullable();
            $table->integer('subscription_plan_status')->default(1);
            $table->integer('subscription_plan_featured')->default(1);
            $table->integer('subscription_plan_trash')->default(0);
            $table->integer('subscription_plan_role')->default(1);
            $table->timestamp('subscription_plan_added_on')->useCurrent();
            $table->integer('subscription_plan_added_by')->default(1);
            $table->timestamp('subscription_plan_updated_on')->useCurrent();
            $table->integer('subscription_plan_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
