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
        Schema::create('trainer_review_likes', function (Blueprint $table) {
            $table->bigIncrements('review_like_id');
            $table->integer('review_like_review');
            $table->integer('review_like_type')->comment('1->like,2->dislike');
            $table->integer('review_like_status')->default(1);
            $table->integer('review_like_trash')->default(0);
            $table->timestamp('review_like_added_on')->useCurrent();
            $table->integer('review_like_added_by')->default(1);
            $table->timestamp('review_like_updated_on')->useCurrent();
            $table->integer('review_like_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_review_likes');
    }
};
