<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    protected $fillable = [
        'status',
    ];

    public function rules()
	{
	    return [
			'status' => 'required',
	    ];
	}

    protected $casts = [
        'id' => 'integer'
    ];


	// Attributes


	/**
	 * Return the total weight of the cart
	 * @return mixed
	 */
	public function getWeightTotalAttribute() {
		$arr = [];
		foreach($this->cartItems as $item) {
			array_push($arr, $item->weight_sub_total);
		};
		return array_sum($arr);
	}


	/**
	 * Return the total price value of the cart
	 * @return mixed
	 */
	public function getPriceTotalAttribute() {
		$arr = [];
		foreach($this->cartItems as $item) {
			array_push($arr, $item->price_sub_total);
		};
		return array_sum($arr);
	}

	/**
	 * Return the total value of the cart as a formatted string
	 * @return string
	 */
	public function getPriceTotalStringAttribute()
	{
		return config('shop.currency.symbol') . number_format($this->price_total, 2);
	}
	

	// Functions


	public function getCartItemsCount($id) {

		$items = $this->cartItems;

		$int = 0;
		foreach($items as $item) {
			$int += $item->quantity;
		}

		return $int;
	}



	/**
	 * Return a collection of CartItems matching given product ID
	 * @param $id
	 * @return mixed
	 */
	public function getCartItemsByProductId($id) {
		return $this->cartItems->where('product_id', $id);
	}


	/**
	 * Return the total number of items
	 * @param $id
	 * @return mixed
	 */
	public function getCartItemsByProductIdCount($id) {

		$items = $this->cartItems->where('product_id', $id);

		$int = 0;
		foreach($items as $item) {
			$int += $item->quantity;
		}

		return $int;
	}

    // Relationships

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function cartItems()
	{
		return $this->hasMany('DanPowell\Shop\Models\CartItem');
	}

}
