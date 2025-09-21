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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->bigIncrements('inventory_log_id');
            $table->integer('inventory_log_order')->default(1);
            $table->integer('inventory_log_product')->default(0);
            $table->integer('inventory_log_variant')->default(0);
            $table->integer('inventory_log_quantity')->default(1);
            $table->integer('inventory_log_batch')->default(1);
            $table->string('inventory_log_message')->nullable();
            $table->string('inventory_log_price')->default(0);
            $table->timestamp('inventory_log_added_on')->useCurrent();
            $table->integer('inventory_log_added_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
