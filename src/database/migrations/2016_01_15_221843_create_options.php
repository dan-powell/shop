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
            $table->integer('stock')->nullable();
            $table->text('type', 128);
            $table->text('config');
            $table->text('description');

            $table->integer('attachment_id');
            $table->string('attachment_type', 255);
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