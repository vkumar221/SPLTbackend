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
        Schema::create('user_cards', function (Blueprint $table) {
            $table->bigIncrements('user_card_id');
            $table->integer('user_card_user');
            $table->string('user_card_name');
            $table->string('user_card_number');
            $table->string('user_card_expiry');
            $table->string('user_card_cvc');
            $table->integer('user_card_status')->default(1);
            $table->integer('user_card_trash')->default(0);
            $table->timestamp('user_card_added_on')->useCurrent();
            $table->integer('user_card_added_by')->default(1);
            $table->timestamp('user_card_updated_on')->useCurrent();
            $table->integer('user_card_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_cards');
    }
};
