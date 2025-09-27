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
        Schema::create('muscle_groups', function (Blueprint $table) {
            $table->bigIncrements('muscle_group_id');
            $table->string('muscle_group_name')->nullable();
            $table->integer('muscle_group_status')->default(1);
            $table->integer('muscle_group_trash')->default(0);
            $table->timestamp('muscle_group_added_on')->useCurrent();
            $table->integer('muscle_group_added_by')->default(1);
            $table->timestamp('muscle_group_updated_on')->useCurrent();
            $table->integer('muscle_group_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muscle_groups');
    }
};
