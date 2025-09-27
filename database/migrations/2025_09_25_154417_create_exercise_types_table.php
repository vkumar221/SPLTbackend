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
        Schema::create('exercise_types', function (Blueprint $table) {
            $table->bigIncrements('exercise_type_id');
            $table->string('exercise_type_name')->nullable();
            $table->integer('exercise_type_status')->default(1);
            $table->integer('exercise_type_trash')->default(0);
            $table->timestamp('exercise_type_added_on')->useCurrent();
            $table->integer('exercise_type_added_by')->default(1);
            $table->timestamp('exercise_type_updated_on')->useCurrent();
            $table->integer('exercise_type_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_tyepes');
    }
};
