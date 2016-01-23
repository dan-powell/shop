<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartPersonalisations extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('cart_personalisations', function($table)
        {
            $table->increments('id');
            $table->text('value');
            $table->integer('cart_product_id')->unsigned();
            $table->foreign('cart_product_id')->references('id')->on('cart_products')->onDelete('cascade');
            $table->integer('personalisation_id')->unsigned();
            $table->foreign('personalisation_id')->references('id')->on('personalisations')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_personalisations', function($table) {
            $table->dropForeign('cart_personalisations_personalisation_id_foreign');
            $table->dropForeign('cart_personalisations_cart_product_id_foreign');
        });
        Schema::drop('cart_personalisations');
    }

}