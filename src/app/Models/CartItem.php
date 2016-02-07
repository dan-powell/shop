<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {

    protected $fillable = [
		'product_id',
		'cart_id',
		'options',
		'extras',
		'quantity',
		'status'
    ];

    protected $casts = [
        'id' => 'integer',
        'sub_total' => 'decimal',
		'quantity' => 'integer'
    ];

	protected $appends = ['sub_total_string'];


	/**
	 * @return number
	 */
	public function getSubTotalAttribute()
	{
		$arr = [$this->product->price];
		foreach($this->extras as $extra) {
			array_push($arr, $extra['price']);
		}
		return array_sum($arr) * $this->quantity;
	}

	/**
	 * @return string
	 */
	public function getSubTotalStringAttribute()
	{
		return config('shop.currency.symbol') . number_format($this->sub_total, 2);
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function getOptionsAttribute()
	{
		return json_decode($this->attributes['options'], true);
	}

	/**
	 * @param $value
	 */
	public function setOptionsAttribute($value)
	{
		$this->attributes['options'] = json_encode($value);
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function getExtrasAttribute()
	{
		return json_decode($this->attributes['extras'], true);
	}

	/**
	 * @param $value
	 */
	public function setExtrasAttribute($value)
	{
		$this->attributes['extras'] = json_encode($value);
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

		//dd($bool);
	}





		// Check that item products exist

        // Check that item options exist

        // Check that item extras exist


        // Check that item product has stock


        // Check that item extras have stock





	// Relationships


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
