<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Baum\Node;

class CategoryPublished extends Category {

    public function products()
    {
        return $this->belongsToMany(\DanPowell\Shop\Models\Product::class, 'product_categories', 'category_id', 'product_id')->where('published', '!=', '0')->with(['images']);
    }

}
