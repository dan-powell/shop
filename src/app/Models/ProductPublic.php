<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPublic extends Product {

	// Inverse Relationships

	public function categories()
	{
		return $this->belongsToMany('DanPowell\Shop\Models\CategoryPublic', 'product_categories', 'product_id', 'category_id')->published();
	}

	public function related()
	{
		return $this->belongsToMany('DanPowell\Shop\Models\Product', 'product_related', 'product_id', 'related_id')->published();
	}

}
