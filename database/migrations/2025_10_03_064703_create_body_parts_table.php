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
        Schema::create('body_parts', function (Blueprint $table) {
            $table->bigIncrements('body_part_id');
            $table->string('body_part_name');
            $table->integer('body_part_status')->default(1);
            $table->timestamp('body_part_added_on')->useCurrent();
            $table->integer('body_part_added_by')->default(1);
            $table->timestamp('body_part_updated_on')->useCurrent();
            $table->integer('body_part_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_parts');
    }
};
