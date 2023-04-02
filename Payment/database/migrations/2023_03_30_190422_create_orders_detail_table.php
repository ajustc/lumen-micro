<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('product_id');
            $table->string('name');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('weight');
            $table->integer('sub_weight');
            $table->integer('sub_price');
            $table->timestamps();
        });

        Schema::table('orders_detail', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_detail');
    }
}
