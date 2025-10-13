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
        Schema::create('user_address', function (Blueprint $table) {
            $table->bigIncrements('user_address_id');
            $table->integer('user_address_user');
            $table->string('user_address_name');
            $table->string('user_address_line1');
            $table->string('user_address_line2')->nullable();
            $table->string('user_address_city');
            $table->string('user_address_state');
            $table->string('user_address_country');
            $table->string('user_address_zipcode');
            $table->integer('user_address_status')->default(1);
            $table->integer('user_address_trash')->default(0);
            $table->timestamp('user_address_added_on')->useCurrent();
            $table->integer('user_address_added_by')->default(1);
            $table->timestamp('user_address_updated_on')->useCurrent();
            $table->integer('user_address_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_address');
    }
};
