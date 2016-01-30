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

            // Create Options
            $rand = rand(0, 2);
            for ($i = 0; $i < $rand; $i++) {
                $product->options()->save(factory(DanPowell\Shop\Models\Option::class)->make());
            }

            // Create Extras
            $rand = rand(0, 2);
            for ($i = 0; $i < $rand; $i++) {
                $product->extras()->save(factory(DanPowell\Shop\Models\Extra::class)->make());
            }

            // For every option group, create the Options
            foreach ($product->extras as $extra) {

                $rand = rand(0, 2);
                for ($i = 0; $i < $rand; $i++) {
                    $extra->options()->save(factory(DanPowell\Shop\Models\Option::class)->make());
                }
            };

        };


    }
}