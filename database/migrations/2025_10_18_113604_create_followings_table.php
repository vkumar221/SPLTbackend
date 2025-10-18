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
        Schema::create('followings', function (Blueprint $table) {
            $table->bigIncrements('following_id');
            $table->integer('following_follower');
            $table->integer('following_status')->default(1);
            $table->integer('following_trash')->default(0);
            $table->timestamp('following_added_on')->useCurrent();
            $table->integer('following_added_by')->default(1);
            $table->timestamp('following_updated_on')->useCurrent();
            $table->integer('following_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followings');
    }
};
