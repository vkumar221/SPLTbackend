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
        Schema::create('trainer_clients', function (Blueprint $table) {
            $table->bigIncrements('trainer_client_id');
            $table->integer('trainer_client')->default(1);
            $table->integer('trainer_client_trainer')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_clients');
    }
};
