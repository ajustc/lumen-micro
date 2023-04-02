<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('purchase_total');
            $table->string('address');
            $table->string('status');
            $table->string('delivery_receipt')->nullable();
            $table->integer('total_weight');
            $table->string('province');
            $table->string('district');
            $table->string('type');
            $table->integer('postal_code');
            $table->string('courier');
            $table->string('package');
            $table->integer('cost');
            $table->string('estimate');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
