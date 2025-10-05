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
        Schema::create('client_measurements', function (Blueprint $table) {
            $table->bigIncrements('client_measurement_id');
            $table->integer('client_measurement_client');
            $table->integer('client_measurement_part');
            $table->string('client_measurement');
            $table->string('client_measurement_date');
            $table->integer('client_measurement_status')->default(1);
            $table->timestamp('client_measurement_added_on')->useCurrent();
            $table->integer('client_measurement_added_by')->default(1);
            $table->timestamp('client_measurement_updated_on')->useCurrent();
            $table->integer('client_measurement_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_measurements');
    }
};
