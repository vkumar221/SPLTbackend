<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->bigIncrements('promo_code_id');
            $table->string('promo_code_name', 100);
            $table->integer('promo_code_type')->default(1);
            $table->string('promo_code_value')->default(0);
            $table->string('promo_code_max_order_value')->default(0);
            $table->string('promo_code_min_order_value')->default(0);
            $table->string('promo_code_from')->nullable();
            $table->string('promo_code_to')->nullable();
            $table->integer('promo_code_usage')->default(1);
            $table->integer('promo_code_max_users')->default(1);
            $table->string('promo_code_image')->nullable();
            $table->integer('promo_code_status')->default(1);
            $table->integer('promo_code_added_by')->default(1);
            $table->timestamp('promo_code_added_on')->nullable();
            $table->integer('promo_code_updated_by')->default(1);
            $table->timestamp('promo_code_updated_on')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promo_codes');
    }
}

