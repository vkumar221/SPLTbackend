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
        Schema::create('trainer_certificates', function (Blueprint $table) {
            $table->bigIncrements('certificate_id');
            $table->string('certificate_title');
            $table->string('certificate_image')->nullable();
            $table->integer('certificate_status')->default(1);
            $table->integer('certificate_trash')->default(0);
            $table->timestamp('certificate_added_on')->useCurrent();
            $table->integer('certificate_added_by')->default(1);
            $table->timestamp('certificate_updated_on')->useCurrent();
            $table->integer('certificate_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_certificates');
    }
};
