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
            $table->decimal('price', 2)->default('0.00');
            $table->decimal('price_offer', 2)->default('0.00');
            $table->decimal('weight', 2)->default('0.00');
            $table->decimal('width', 2)->default('0.00');
            $table->decimal('height', 2)->default('0.00');
            $table->decimal('weight', 2)->default('0.00');
            $table->integer('quantity')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('published')->default(1);
            $table->string('meta_title', 255);
            $table->string('meta_description', 255);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
