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
        Schema::create('subscription_plan_items', function (Blueprint $table) {
            $table->bigIncrements('subscription_plan_item_id');
            $table->integer('subscription_plan_item_plan');
            $table->integer('subscription_plan_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plan_items');
    }
};
