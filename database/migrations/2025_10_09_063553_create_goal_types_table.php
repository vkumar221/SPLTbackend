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
        Schema::create('goal_types', function (Blueprint $table) {
            $table->bigIncrements('goal_type_id');
            $table->string('goal_type_name');
            $table->integer('goal_type_status')->default(1);
            $table->timestamp('goal_type_added_on')->useCurrent();
            $table->integer('goal_type_added_by')->default(1);
            $table->timestamp('goal_type_updated_on')->useCurrent();
            $table->integer('goal_type_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_types');
    }
};
