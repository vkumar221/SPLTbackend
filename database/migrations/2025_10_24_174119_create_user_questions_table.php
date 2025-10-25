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
        Schema::create('user_questions', function (Blueprint $table) {
            $table->bigIncrements('user_question_id');
            $table->string('user_question');
            $table->text('user_question_answer')->nullable();
            $table->integer('user_question_status')->default(1);
            $table->timestamp('user_question_added_on')->useCurrent();
            $table->integer('user_question_added_by')->default(1);
            $table->timestamp('user_question_updated_on')->useCurrent();
            $table->integer('user_question_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_questions');
    }
};
