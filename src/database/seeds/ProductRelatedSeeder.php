<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DanPowell\Shop\Models\Product;

class ProductRelatedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = Product::all();

        foreach($products as $product) {
            $this->attachRelated($product);
        }

    }


    private function attachRelated($product)
    {

        $rand = rand(0, 3);
        $related = Product::orderBy(DB::raw('RAND()'))->take($rand)->get();

        foreach($related as $item) {
            $product->related()->attach($item);
        }

    }

}