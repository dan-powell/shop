<?php namespace DanPowell\Shop\Repositories;

/*
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
*/

//use Illuminate\Database\Eloquent\Model;

use DanPowell\Shop\Models\Product;



class ProductRepository
{

    public function getAll($limit = null)
    {

        $products = Product::where('published', '!=', '0')
            ->with(['images', 'categories'])
            ->limit($limit)
            ->get();

        $products->each( function($m) {
            $m->image_types = $this->organiseImages($m);
        });

        return $products;

    }


    public function getBySlug($slug)
    {
        $query = Product::with(['images', 'related', 'optionGroups', 'personalizations'])->where('slug', '=', $slug);
        $item = $query->first();

        // Check if a project was found
        if ($item != null) {

            $item->image_types = $this->organiseImages($item);

            return $item;
        } else {
            // No project found, throw a 404.
            abort('404', 'Invalid slug');
        }

    }


    public function getFeatured($limit = null)
    {

        $products = Product::where('featured', '=', '1')
            ->where('published', '!=', '0')
            ->with(['images'])
            ->limit($limit)
            ->get();

        $products->each( function($m) {
            $m->image_types = $this->organiseImages($m);
        });

        return $products;

    }



    private function organiseImages($product)
    {
        return $product->images->groupBy('pivot.image_type');
    }



}