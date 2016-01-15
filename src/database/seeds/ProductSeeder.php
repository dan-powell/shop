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

            $rand = rand(0, 4);
            for ($i = 0; $i < $rand; $i++) {

                $product->optionGroups()->save(factory(DanPowell\Shop\Models\OptionGroup::class)->make());

            }

            foreach ($product->optionGroups as $optionGroup) {

                $rand = rand(0, 4);
                for ($i = 0; $i < $rand; $i++) {
                    $optionGroup->options()->save(factory(DanPowell\Shop\Models\Option::class)->make());
                }
            };


        };


    }
}