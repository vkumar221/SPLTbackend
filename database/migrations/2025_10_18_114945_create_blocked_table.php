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
        Schema::create('blocked', function (Blueprint $table) {
            $table->bigIncrements('blocked_id');
            $table->integer('blocked_user');
            $table->integer('blocked_status')->default(1);
            $table->integer('blocked_trash')->default(0);
            $table->timestamp('blocked_added_on')->useCurrent();
            $table->integer('blocked_added_by')->default(1);
            $table->timestamp('blocked_updated_on')->useCurrent();
            $table->integer('blocked_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked');
    }
};
