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
        Schema::create('order_requests', function (Blueprint $table) {
            $table->bigIncrements('order_request_id');
            $table->integer('order_request_order')->default(1);
            $table->integer('order_request_item')->default(1);
            $table->text('order_request_comment')->nullable();
            $table->text('order_request_reply')->nullable();
            $table->integer('order_request_status')->default(1);
            $table->timestamp('order_request_added_on')->useCurrent();
            $table->integer('order_request_added_by')->default(1);
            $table->timestamp('order_request_updated_on')->useCurrent();
            $table->integer('order_request_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_requests');
    }
};
