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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('uname');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('password');
            $table->string('otp')->nullable();
            $table->integer('role')->default(1);
            $table->integer('status')->default(1);
            $table->integer('trash')->default(0);
            $table->timestamp('added_on')->useCurrent();
            $table->integer('added_by')->default(1);
            $table->timestamp('updated_on')->useCurrent();
            $table->integer('updated_by')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('verify_within')->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
