<?php namespace DanPowell\Shop\Models;

class CategoryPublic extends Category {
    

    public function products()
    {
        return $this->belongsToMany(\DanPowell\Shop\Models\ProductPublic::class, 'product_categories', 'category_id', 'product_id')->where('published', '!=', '0');
    }
    

}
