<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function($table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('title', 255);
            $table->text('description');
            $table->string('slug', 80);
            $table->decimal('price', 6, 2);
            $table->decimal('price_offer', 6, 2)->nullable();
            $table->decimal('weight', 2)->nullable();
            $table->decimal('width', 2)->nullable();
            $table->decimal('height', 2)->nullable();
            $table->decimal('length', 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('published')->default(1);
            $table->string('meta_title', 255);
            $table->string('meta_description', 255);
            $table->integer('rank')->default(0);
        });


        Schema::create('product_categories', function($table)
        {
            $table->integer('product_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('product_related', function($table)
        {
            $table->integer('product_id')->unsigned();
            $table->integer('related_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('related_id')->references('id')->on('products');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function($table) {
            $table->dropForeign('product_categories_category_id_foreign');
            $table->dropForeign('product_categories_product_id_foreign');
        });

        Schema::table('product_related', function($table) {
            $table->dropForeign('product_related_related_id_foreign');
            $table->dropForeign('product_related_product_id_foreign');
        });


        Schema::drop('products');
        Schema::drop('product_categories');
        Schema::drop('product_related');
    }

}
