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
        Schema::create('video_sections', function (Blueprint $table) {
           $table->bigIncrements('video_section_id');
            $table->string('video_section_title');
            $table->string('video_section_image')->nullable();
            $table->integer('video_section_status')->default(1);
            $table->integer('video_section_trash')->default(0);
            $table->integer('video_section_role')->default(3);
            $table->timestamp('video_section_added_on')->useCurrent();
            $table->integer('video_section_added_by')->default(1);
            $table->timestamp('video_section_updated_on')->useCurrent();
            $table->integer('video_section_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_sections');
    }
};
