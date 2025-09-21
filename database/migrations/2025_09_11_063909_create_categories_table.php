<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('category_id');
            $table->string('category_name')->unique();
            $table->string('category_slug')->unique();
            $table->text('category_image')->nullable();
            $table->text('category_cover_image')->nullable();
            $table->text('category_feature_image')->nullable();
            $table->text('category_description')->nullable();
            $table->integer('category_status')->default(1);
            $table->integer('category_trash')->default(0);
            $table->timestamp('category_added_on')->useCurrent();
            $table->integer('category_added_by')->default(1);
            $table->timestamp('category_updated_on')->useCurrent();
            $table->integer('category_updated_by')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }

};
