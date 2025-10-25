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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('page_id');
            $table->string('page_title');
            $table->text('page_content');
            $table->integer('page_status')->default(1);
            $table->timestamp('page_added_on')->useCurrent();
            $table->integer('page_added_by')->default(1);
            $table->timestamp('page_updated_on')->useCurrent();
            $table->integer('page_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
