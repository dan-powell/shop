<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('images', function($table)
		{
    		$table->increments('id');
    		$table->timestamps();
            $table->string('title', 255);
            $table->string('path', 255);
            $table->string('filename', 255);
            $table->string('alt', 255);
		});

/*
        Schema::create('categories_attachments', function($table)
		{
    		$table->integer('category_id');
            $table->integer('taggable_id');
            $table->string('taggable_type', 255);
		});
*/

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images');
	}

}