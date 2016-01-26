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
            $table->string('label', 255);
            $table->decimal('price_modifier', 6, 2)->default('0');
            $table->integer('option_group_id')->unsigned();
            $table->foreign('option_group_id')->references('id')->on('option_groups')->onDelete('cascade');;
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