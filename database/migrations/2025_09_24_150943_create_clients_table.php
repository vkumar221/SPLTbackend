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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('client_id');
            $table->string('client_name')->nullable();
            $table->string('client_email')->unique();
            $table->string('client_password')->nullable();
            $table->string('client_vpassword')->nullable();
            $table->string('client_phone')->nullable();
            $table->integer('client_program')->default(1);
            $table->integer('client_plan')->default(1);
            $table->text('client_image')->nullable();
            $table->integer('client_status')->default(1);
            $table->integer('client_trash')->default(0);
            $table->timestamp('client_added_on')->useCurrent();
            $table->integer('client_added_by')->default(1);
            $table->timestamp('client_updated_on')->useCurrent();
            $table->integer('client_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
