<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {

	protected $table = 'cart_items';

	protected $morphClass = 'DanPowell\Shop\Models\CartItem';

    protected $fillable = [
		'product_id',
		'cart_id',
		'config',
		'quantity',
    ];

    protected $casts = [
        'id' => 'integer',
        'sub_total' => 'decimal',
		'quantity' => 'integer'
    ];

	protected $appends = ['price_sub_total_string'];


	// Attributes

	/**
	 * @return number
	 */
	public function getPriceSubTotalAttribute()
	{
		$arr = [$this->product->price];

		foreach($this->extras as $extra) {
			array_push($arr, $extra->price);
		}
		return array_sum($arr) * $this->quantity;
	}

	/**
	 * @return string
	 */
	public function getPriceSubTotalStringAttribute()
	{
		return config('shop.currency.symbol') . number_format($this->price_sub_total, 2);
	}

	/**
	 * @return mixed
	 */
	public function getWeightSubTotalAttribute()
	{
		if ($this->product->weight) {
			return $this->product->weight * $this->quantity;
		} else {
			return 0;
		}
	}

	public function getConfigAttribute()
	{
		return json_decode($this->attributes['config'], true);
	}

	public function setConfigAttribute($value)
	{
		$this->attributes['config'] = json_encode($value);
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function getRelationsAttribute()
	{
		return json_decode($this->attributes['relations'], true);
	}

	/**
	 * @param $value
	 */
	public function setRelationsAttribute($value)
	{
		$this->attributes['relations'] = json_encode($value);
	}


	// Custom Methods


	public function getValidAttribute()
	{
		if ($this->status == 1){
			$bool = true;
		} else {
			$bool = false;
		}
		return $bool;
	}



	public function invalidate()
	{
		$this->status = 0;
		$this->save();
	}



	public function verifyOptions()
	{
		$bool = false;
		$this->product->options->each(function($option) use ($bool) {
			foreach($this->option as $cartOption) {
				if($cartOption['id'] == $option->id) {

					if ($option->type == 'radio' || $option->type == 'select') {

						foreach($option->type as $type) {
							//$cartOption['value'];
						}

					} else {
						$bool = true;
					}

				}
			}
		});

	}




	// Relationships

	public function extras()
	{
		return $this->belongsToMany('DanPowell\Shop\Models\Extra', 'cart_item_extras', 'cart_item_id', 'extra_id', 'extras')->withPivot('value');
	}

	public function options()
	{
		return $this->belongsToMany('DanPowell\Shop\Models\Option', 'cart_item_options', 'cart_item_id', 'option_id', 'options')->withPivot('value');
	}


    // Inverse Relationships
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function product()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Product');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function cart()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Cart');
	}



}
