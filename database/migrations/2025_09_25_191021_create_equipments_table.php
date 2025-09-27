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
        Schema::create('equipments', function (Blueprint $table) {
            $table->bigIncrements('equipment_id');
            $table->string('equipment_name')->nullable();
            $table->integer('equipment_status')->default(1);
            $table->integer('equipment_trash')->default(0);
            $table->timestamp('equipment_added_on')->useCurrent();
            $table->integer('equipment_added_by')->default(1);
            $table->timestamp('equipment_updated_on')->useCurrent();
            $table->integer('equipment_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
