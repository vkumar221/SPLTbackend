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
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('vendor_id');
            $table->string('vendor_name')->nullable();
            $table->string('vendor_email')->unique();
            $table->string('vendor_password')->nullable();
            $table->string('vendor_vpassword')->nullable();
            $table->string('vendor_phone')->nullable();
            $table->integer('vendor_type')->default(1);
            $table->text('vendor_image')->nullable();
            $table->integer('vendor_status')->default(1);
            $table->integer('vendor_trash')->default(0);
            $table->timestamp('vendor_added_on')->useCurrent();
            $table->integer('vendor_added_by')->default(1);
            $table->timestamp('vendor_updated_on')->useCurrent();
            $table->integer('vendor_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
