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

        $products = factory(DanPowell\Shop\Models\Product::class, 20)->create();

        foreach($products as $product) {

            // Create Option Groups
            $rand = rand(0, 4);
            for ($i = 0; $i < $rand; $i++) {
                $product->optionGroups()->save(factory(DanPowell\Shop\Models\OptionGroup::class)->make());
            }

            // For every option group, create the Options
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

        };


    }
}