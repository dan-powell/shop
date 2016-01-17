<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DanPowell\Shop\Models\Category;
use DanPowell\Shop\Models\Image;

class CategoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = Category::all();

        foreach($categories as $category) {
            $this->attachImages($category);
        }

    }


    private function attachImages($category)
    {

        $rand = rand(0, 3);
        $imagetypes = config('shop.image_types');

        $images = Image::orderBy(DB::raw('RAND()'))->take($rand)->get();

        foreach($images as $image) {
            $randType = rand(0, count($imagetypes) -1);
            $category->images()->attach($image, ['image_type' => $imagetypes[$randType]]);
        }

    }

}