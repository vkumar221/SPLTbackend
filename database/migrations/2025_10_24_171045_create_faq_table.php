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
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('faq_id');
            $table->string('faq_question');
            $table->text('faq_answer');
            $table->integer('faq_status')->default(1);
            $table->timestamp('faq_added_on')->useCurrent();
            $table->integer('faq_added_by')->default(1);
            $table->timestamp('faq_updated_on')->useCurrent();
            $table->integer('faq_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
