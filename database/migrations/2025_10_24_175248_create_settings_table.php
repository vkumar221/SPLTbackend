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
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('setting_id');
            $table->string('setting_name');
            $table->string('setting_email')->nullable();
            $table->string('setting_phone')->nullable();
            $table->text('setting_address')->nullable();
            $table->string('setting_logo')->nullable();
            $table->string('setting_logo_light')->nullable();
            $table->string('setting_favicon')->nullable();
            $table->string('setting_facebook')->nullable();
            $table->string('setting_twitter')->nullable();
            $table->string('setting_linkedin')->nullable();
            $table->string('setting_instagram')->nullable();
            $table->string('setting_youtube')->nullable();
            $table->timestamp('setting_updated_on')->useCurrent();
            $table->integer('setting_updated_by')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
