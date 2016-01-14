<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DanPowell\Shop\Models\Image::class, 20)->create();
    }
}