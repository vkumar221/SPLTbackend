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
        Schema::create('trainers', function (Blueprint $table) {
            $table->bigIncrements('trainer_id');
            $table->string('trainer_name')->nullable();
            $table->string('trainer_email')->unique();
            $table->string('trainer_password')->nullable();
            $table->string('trainer_vpassword')->nullable();
            $table->string('trainer_phone')->nullable();
            $table->integer('trainer_type')->default(1);
            $table->integer('trainer_plan')->default(1);
            $table->text('trainer_image')->nullable();
            $table->text('trainer_cover')->nullable();
            $table->string('trainer_facebook')->nullable();
            $table->string('trainer_instagram')->nullable();
            $table->string('trainer_tiktok')->nullable();
            $table->string('trainer_x')->nullable();
            $table->string('trainer_youtube')->nullable();
            $table->integer('trainer_status')->default(1);
            $table->integer('trainer_trash')->default(0);
            $table->timestamp('trainer_added_on')->useCurrent();
            $table->integer('trainer_added_by')->default(1);
            $table->timestamp('trainer_updated_on')->useCurrent();
            $table->integer('trainer_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
