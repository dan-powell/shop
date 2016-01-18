<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DanPowell\Shop\Models\Product;
use DanPowell\Shop\Models\Image;

class ProductImageSeeder extends Seeder
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
            $this->attachImages($product);
        }

    }


    private function attachImages($product)
    {

        $rand = rand(0, 3);
        $imagetypes = config('shop.image_types');

        $images = Image::orderBy(DB::raw('RAND()'))->take($rand)->get();

        foreach($images as $image) {
            $randomType = array_search($imagetypes[array_rand($imagetypes)], $imagetypes);
            $product->images()->attach($image, ['image_type' => $randomType]);
        }

    }

}