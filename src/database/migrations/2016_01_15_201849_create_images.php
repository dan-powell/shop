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
            $table->string('filename', 255);
            $table->string('alt', 255);
        });

        Schema::create('images_attachments', function($table)
        {
            $table->integer('image_id');
            $table->integer('images_attachments_id');
            $table->string('images_attachments_type', 255);
            $table->string('image_type', 128);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
        Schema::drop('images_attachments');
    }

}