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
            $table->string('uname')->nullable();
            $table->integer('type')->default(1);
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('gender')->default('male');
            $table->integer('age');
            $table->string('dob')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('bio')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->string('plan')->nullable();
            $table->string('password');
            $table->string('vpassword');
            $table->string('otp')->nullable();
            $table->integer('role')->default(1)->comment('1->user,2->trainer,3->vendor');
            $table->integer('status')->default(1);
            $table->timestamp('added_on')->useCurrent();
            $table->integer('added_by')->default(1);
            $table->timestamp('updated_on')->useCurrent();
            $table->integer('updated_by')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verify_within')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
