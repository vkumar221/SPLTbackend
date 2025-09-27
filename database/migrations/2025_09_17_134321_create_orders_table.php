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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->string('order_refid')->nullable();
            $table->string('order_name')->nullable();
            $table->string('order_company')->nullable();
            $table->string('order_email');
            $table->string('order_price')->nullable();
            $table->string('order_phone')->nullable();
            $table->string('order_address')->nullable();
            $table->string('order_address2')->nullable();
            $table->integer('order_country')->default(1);
            $table->string('order_city')->nullable();
            $table->string('order_state',255)->nullable();
            $table->integer('order_zip')->default(0);
            $table->string('order_image',255)->nullable();
            $table->string('order_ip')->nullable();
            $table->integer('order_payment')->default(1);
            $table->string('order_total')->default(0);
            $table->string('order_paid')->nullable();
            $table->string('order_discount')->default(0);
            $table->string('order_discount_per')->default(0);
            $table->string('order_coupon')->nullable();
            $table->string('order_coupon_code')->nullable();
            $table->integer('order_cod')->default(0);
            $table->string('order_track_link')->nullable();
            $table->text('order_notes')->nullable();
            $table->integer('order_pay_status')->default(1);
            $table->integer('order_status')->default(1);
            $table->integer('order_trash')->default(0);
            $table->integer('order_added_by')->default(1);
            $table->timestamp('order_added_on')->useCurrent();
            $table->integer('order_updated_by')->default(1);
            $table->timestamp('order_updated_on')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
