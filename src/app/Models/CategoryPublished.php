<?php namespace DanPowell\Shop\Models;

use DanPowell\Shop\Models\Category;

class CategoryPublished extends Category {
    

    public function products()
    {
        return $this->belongsToMany(\DanPowell\Shop\Models\Product::class, 'product_categories', 'category_id', 'product_id')->where('published', '!=', '0')->with(['images']);
    }
    

}
