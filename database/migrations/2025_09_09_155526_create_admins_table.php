<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('admin_id');
            $table->string('admin_name');
            $table->string('admin_image')->nullable(); // path or filename
            $table->string('admin_mobile', 15)->nullable();
            $table->string('admin_email')->unique();
            $table->string('admin_password');
            $table->string('admin_vpassword'); // consider removing if not needed
            $table->string('admin_role')->default(1);
            $table->text('admin_address')->nullable();
            $table->timestamp('admin_added_on')->useCurrent();
            $table->unsignedBigInteger('admin_added_by')->default(1);
            $table->timestamp('admin_updated_on')->useCurrent();
            $table->unsignedBigInteger('admin_updated_by')->default(1);
            $table->boolean('admin_status')->default(1);
        });
    }

    public function down(): void {
        Schema::dropIfExists('admins');
    }
};

