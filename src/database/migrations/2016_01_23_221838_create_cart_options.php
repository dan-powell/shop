<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartOptions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('cart_options', function($table)
        {
            $table->increments('id');
            $table->integer('cart_product_id')->unsigned();
            $table->foreign('cart_product_id')->references('id')->on('cart_products')->onDelete('cascade');
//            $table->integer('option_group_id')->unsigned();
//            $table->foreign('option_group_id')->references('id')->on('option_groups')->onDelete('cascade');
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_options', function($table) {
            $table->dropForeign('cart_options_cart_product_id_foreign');
            //$table->dropForeign('cart_options_option_group_id_foreign');
            $table->dropForeign('cart_options_option_id_foreign');
        });
        Schema::drop('cart_options');
    }

}