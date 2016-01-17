<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = factory(DanPowell\Shop\Models\Product::class, 50)->create();

        foreach($products as $product) {

            // Create Option Groups
            $rand = rand(0, 4);
            for ($i = 0; $i < $rand; $i++) {
                $product->optionGroups()->save(factory(DanPowell\Shop\Models\OptionGroup::class)->make());
            }

            // For every optiuon group, create the Options
            foreach ($product->optionGroups as $optionGroup) {

                $rand = rand(0, 4);
                for ($i = 0; $i < $rand; $i++) {
                    $optionGroup->options()->save(factory(DanPowell\Shop\Models\Option::class)->make());
                }
            };

            // Create Personalizations
            $rand = rand(0, 2);
            for ($i = 0; $i < $rand; $i++) {
                $product->personalizations()->save(factory(DanPowell\Shop\Models\Personalization::class)->make());
            }

            // Create Categories
            $rand = rand(0, 2);
            for ($i = 0; $i < $rand; $i++) {
                $product->categories()->save(factory(DanPowell\Shop\Models\Category::class)->make());
            }

            // Create Images
            $rand = rand(0, 2);
            $imagetypes = config('shop.image_types');
            for ($i = 0; $i < $rand; $i++) {
                $image = factory(DanPowell\Shop\Models\Image::class)->create();
                $imagetypesnum = count(config('shop.image_types')) - 1;
                $randType = rand(0, $imagetypesnum);
                $product->images()->attach($image, ['image_type' => $imagetypes[$randType]]);
            }


        };


    }
}