<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('options', function($table)
		{
    		$table->increments('id');
    		$table->string('title', 255);
    		$table->tinyInteger('type')->default(0);
    		$table->text('description');
    		$table->text('config');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('options');
	}

}