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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->bigIncrements('newsletter_id');
            $table->string('newsletter_title');
            $table->string('newsletter_date');
            $table->string('newsletter_image');
            $table->text('newsletter_description');
            $table->integer('newsletter_category');
            $table->integer('newsletter_product');
            $table->integer('newsletter_audience');
            $table->integer('newsletter_status')->default(1);
            $table->integer('newsletter_trash')->default(0);
            $table->timestamp('newsletter_added_on')->useCurrent();
            $table->integer('newsletter_added_by')->default(1);
            $table->timestamp('newsletter_updated_on')->useCurrent();
            $table->integer('newsletter_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
