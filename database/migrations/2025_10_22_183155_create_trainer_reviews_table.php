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
        Schema::create('trainer_reviews', function (Blueprint $table) {
            $table->bigIncrements('review_id');
            $table->integer('review_user');
            $table->string('review_rating');
            $table->string('review_comment')->nullable();
            $table->integer('review_status')->default(1);
            $table->integer('review_trash')->default(0);
            $table->timestamp('review_added_on')->useCurrent();
            $table->integer('review_added_by')->default(1);
            $table->timestamp('review_updated_on')->useCurrent();
            $table->integer('review_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_reviews');
    }
};
