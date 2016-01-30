<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {

    protected $fillable = [
		'product_id',
		'cart_id',
		'options',
		'extras',
		'quantity'
    ];

    public static function rules($product)
	{

		$arr = [];

		// Validate the product options (Make sure they're legit values)
		foreach($product->options as $option) {
			// This should only apply to radios and selects where values are pre-defined
			if($option->type == 'radio' || $option->type == 'select') {
				$txt = '';
				foreach ($option->config as $value) {
					$txt .= $value . ',';
				}
				$arr['option.' . $option->id] = 'string|required|in:' . $txt;
			}
		};

		// Validate the Extra options (Make sure they're legit values)
		foreach($product->extras as $extra) {
			foreach($extra->options as $option) {
				// This should only apply to radios and selects where values are pre-defined
				if ($option->type == 'radio' || $option->type == 'select') {
					$txt = '';
					foreach ($option->config as $value) {
						$txt .= $value . ',';
					}
					$arr['option.' . $option->id] = 'string|in:' . $txt;
				}
			}
		};

		$arr['quantity'] = 'required|integer|max:800';

	    return $arr;
	}

    protected $casts = [
        'id' => 'integer',
        'sub_total' => 'decimal',
		'quantity' => 'integer'
    ];

	protected $appends = ['sub_total_string'];



	public function getSubTotalAttribute()
	{

//		$arr = [$this->product->price];
//		foreach($this->options as $option) {
//			array_push($arr, $option['option']['price_modifier']);
//		}

		return '';

		return array_sum($arr) * $this->quantity;


	}

	public function getSubTotalStringAttribute()
	{
		return config('shop.currency.symbol') . $this->sub_total;
	}

	public function getOptionsAttribute($value)
	{
		return json_decode($value, true);
	}

	public function setOptionsAttribute($value)
	{
		$this->attributes['options'] = json_encode($value);
	}

	public function getExtrasAttribute($value)
	{
		return json_decode($value, true);
	}

	public function setExtrasAttribute($value)
	{
		$this->attributes['extras'] = json_encode($value);
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
