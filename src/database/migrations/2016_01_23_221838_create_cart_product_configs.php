<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartProductConfigs extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product_configs', function($table)
        {
            $table->increments('id');
            $table->integer('cart_product_id')->unsigned();
            $table->foreign('cart_product_id')->references('id')->on('cart_products')->onDelete('cascade');
            $table->text('options');
            $table->text('personalisations');
            $table->integer('sub_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_product_configs', function($table) {
            $table->dropForeign('cart_product_configs_cart_product_id_foreign');
        });

        Schema::drop('cart_product_configs');
    }

}