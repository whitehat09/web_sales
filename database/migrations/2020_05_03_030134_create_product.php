<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->Increments('product_id');
            $table->string('product_name');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->text('product_desc'); 
            $table->text('product_content'); 
            $table->string('product_price'); // giá
            $table->string('product_image'); 
            $table->integer('product_status');// tình trạng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
