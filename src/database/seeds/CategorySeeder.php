<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = factory(DanPowell\Shop\Models\Category::class, 5)->create();

        foreach($categories as $key => $category) {
            // Create Images
            $rand = rand(0, 2);
            $imagetypes = config('shop.image_types');
            for ($i = 0; $i < $rand; $i++) {
                $image = factory(DanPowell\Shop\Models\Image::class)->create();
                $imagetypesnum = count(config('shop.image_types')) - 1;
                $randType = rand(0, $imagetypesnum);
                $category->images()->attach($image, ['image_type' => $imagetypes[$randType]]);
            }
        }
    }
}