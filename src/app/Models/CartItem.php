<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {

    protected $fillable = [
		'product_id',
		'cart_id',
		'options',
		'personalisations',
		'sub_total',
		'quantity'
    ];

    public static function rules($product)
	{

		$arr = [];
		foreach($product->optionGroups as $optionGroup) {
			if(isset($optionGroup->options) && count($optionGroup->options)) {
				$txt = '';
				foreach($optionGroup->options as $option) {
					$txt .= $option->id . ',';
				};
				$arr['optionGroup.' . $optionGroup->id] = 'integer|required|in:' . $txt;
			}
		}

		if(isset($product->personalisations) && count($product->personalisations)) {
			foreach($product->personalisations as $personalisation) {
				$arr['personalisation.' . $personalisation->id] = 'string';
			}
		}

		$arr['quantity'] = 'required|integer|max:800';

	    return $arr;
	}

    protected $casts = [
        'id' => 'integer',
        'sub_total' => 'decimal',
		'quantity' => 'integer'
    ];

	protected $appends = ['sub_total_string'];

	public function getSubTotalStringAttribute()
	{
		return config('shop.currency.symbol') . $this->sub_total;
	}


    // Relationships


    // Inverse Relationships

	public function product()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Product');
	}

	public function cart()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Cart');
	}


}
