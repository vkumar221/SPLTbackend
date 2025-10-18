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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('appointment_id');
            $table->integer('appointment_user');
            $table->string('appointment_date');
            $table->string('appointment_time')->nullable();
            $table->integer('appointment_status')->default(1);
            $table->integer('appointment_trash')->default(0);
            $table->timestamp('appointment_added_on')->useCurrent();
            $table->integer('appointment_added_by')->default(1);
            $table->timestamp('appointment_updated_on')->useCurrent();
            $table->integer('appointment_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
