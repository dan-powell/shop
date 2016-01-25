<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function($table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('session_id', 255);
            $table->text('cart');
            $table->integer('status')->default(0);
            $table->integer('total');

            $table->string('firstName', 255);
            $table->string('lastName', 255);
            $table->string('billingAddress1', 255);
            $table->string('billingAddress2', 255);
            $table->string('billingCity', 255);
            $table->string('billingPostcode', 255);
            $table->string('billingState', 255);
            $table->string('billingCountry', 255);
            $table->string('billingPhone', 255);
            $table->string('shippingAddress1', 255);
            $table->string('shippingAddress2', 255);
            $table->string('shippingCity', 255);
            $table->string('shippingPostcode', 255);
            $table->string('shippingState', 255);
            $table->string('shippingCountry', 255);
            $table->string('shippingPhone', 255);
            $table->string('email', 255);
            $table->text('notes');
            $table->text('instructions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }

}