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
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('video_id');
            $table->string('video_section')->nullable();
            $table->string('video_title');
            $table->string('video_image')->nullable();
            $table->text('video_description')->nullable();
            $table->string('video_date')->nullable();
            $table->string('video_time')->nullable();
            $table->string('video_vimeo')->nullable();
            $table->string('video_youtube')->nullable();
            $table->string('video_file')->nullable();
            $table->integer('video_status')->default(1);
            $table->integer('video_featured')->default(1);
            $table->integer('video_trash')->default(0);
            $table->integer('video_role')->default(3);
            $table->timestamp('video_added_on')->useCurrent();
            $table->integer('video_added_by')->default(1);
            $table->timestamp('video_updated_on')->useCurrent();
            $table->integer('video_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
