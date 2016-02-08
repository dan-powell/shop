<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItems extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function($table)
        {
            $table->increments('id');
            $table->integer('cart_id')->unsigned();
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->text('relations');
            $table->timestamps();
        });


        Schema::create('cart_item_extras', function($table)
        {
            $table->integer('cart_item_id')->unsigned();
            $table->foreign('cart_item_id')->references('id')->on('cart_items')->onDelete('cascade');
            $table->integer('extra_id')->unsigned();
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
            $table->string('value', 128);
        });

        Schema::create('cart_item_options', function($table)
        {
            $table->integer('cart_item_id')->unsigned();
            $table->foreign('cart_item_id')->references('id')->on('cart_items')->onDelete('cascade');
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->string('value', 128);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_item_extras', function($table) {
            $table->dropForeign('cart_item_extras_extra_id_foreign');
            $table->dropForeign('cart_item_extras_cart_item_id_foreign');
        });
        Schema::drop('cart_item_extras');

        Schema::table('cart_item_options', function($table) {
            $table->dropForeign('cart_item_options_option_id_foreign');
            $table->dropForeign('cart_item_options_cart_item_id_foreign');
        });
        Schema::drop('cart_item_options');

        Schema::table('cart_items', function($table) {
            $table->dropForeign('cart_items_cart_id_foreign');
            $table->dropForeign('cart_items_product_id_foreign');
        });
        Schema::drop('cart_items');
    }

}