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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->integer('payment_role');
            $table->integer('payment_user');
            $table->integer('payment_type')->comment('1 -> Orders, 2-> Plan');
            $table->integer('payment_methods')->comment('1->stripe,2->gpay,3->apple pay');
            $table->string('payment_amount');
            $table->string('payment_refid')->nullable();
            $table->timestamp('payment_added_on')->useCurrent();
            $table->integer('payment_added_by')->default(1);
            $table->timestamp('payment_updated_on')->useCurrent();
            $table->integer('payment_updated_by')->default(1);
;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
