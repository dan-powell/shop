<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategories extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function($table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('title', 255);
            $table->text('description');
            $table->string('slug', 80);
            $table->integer('rank')->default(0);
            $table->tinyInteger('published')->default(1);
            $table->string('meta_title', 255);
            $table->string('meta_description', 255);
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }

}