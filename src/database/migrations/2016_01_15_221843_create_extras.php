<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtras extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extras', function($table)
        {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('title', 255);
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('stock')->nullable();
            $table->text('description');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extras', function($table) {
            $table->dropForeign('extras_product_id_foreign');
        });

        Schema::drop('extras');
    }

}