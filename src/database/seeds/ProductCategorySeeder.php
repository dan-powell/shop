<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DanPowell\Shop\Models\Category;
use DanPowell\Shop\Models\Product;

class ProductCategorySeeder extends Seeder
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
            $this->attachCategories($product);
        }

    }


    private function attachCategories($product)
    {

        $rand = rand(0, 3);

        $categories = Category::orderBy(DB::raw('RAND()'))->take($rand)->get();

        foreach($categories as $category) {
            $product->categories()->attach($category);
        }

    }

}