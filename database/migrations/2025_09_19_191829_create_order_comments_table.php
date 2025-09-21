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
        Schema::create('order_comments', function (Blueprint $table) {
            $table->bigIncrements('order_comment_id');
            $table->integer('order_comment_order')->default(1);
            $table->integer('order_comment_item')->default(1);
            $table->integer('order_comment_order_status')->default(1);
            $table->integer('order_comment_pay_status')->default(1);
            $table->integer('order_comment_nofity')->default(1);
            $table->integer('order_comment_append')->default(1);
            $table->text('order_comment_text')->nullable();
            $table->integer('order_comment_status')->default(1);
            $table->timestamp('order_comment_added_on')->useCurrent();
            $table->integer('order_comment_added_by')->default(1);
            $table->timestamp('order_comment_updated_on')->useCurrent();
            $table->integer('order_comment_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_comments');
    }
};
