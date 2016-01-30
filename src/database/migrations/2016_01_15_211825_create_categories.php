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
            $table->string('title', 255);
            $table->text('description');
            $table->string('slug', 80);
            $table->integer('rank')->default(0);
            $table->tinyInteger('published')->default(1);
            $table->string('meta_title', 255);
            $table->string('meta_description', 255);

            // BAUM nested set fields
            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();

            $table->timestamps();
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
