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

	/**
	 * @param $product Eloquent Collection (\Models\Product)
	 * @return array
	 */
    public static function rules($product)
	{
		$rules = [];
		$messages = [];

		// Add rules for the Product options
		foreach($product->options as $option) {
			// Start creating rules string
			$rule = 'string';
			// Make sure the radio & selects exist and have legit values
			if($option->type == 'radio' || $option->type == 'select') {
				$rule .= '|required|in:';
				foreach ($option->config as $value) {
					$rule .= $value . ',';
				}
			}
			// Add rule to array
			$rules['option.' . $option->id] = $rule;
			$messages['option.' . $option->id . '.in'] = 'The ' . $option->title . ' option is invalid.';
			$messages['option.' . $option->id . '.required'] = 'The ' . $option->title . ' option is required.';
			$messages['option.' . $option->id . '.string'] = 'The ' . $option->title . ' option must be text.';
		};

		// Validate the Extra options
		foreach($product->extras as $extra) {
			foreach($extra->options as $option) {
				// Start creating rules string
				$rule = 'string|required_with:extra.' . $extra->id;

				// This should only apply to radios and selects where values are pre-defined
				if ($option->type == 'radio' || $option->type == 'select') {
					$rule .= '|in:';
					foreach ($option->config as $value) {
						$rule .= $value . ',';
					}
				}
				// Add rule to array
				$rules['option.' . $option->id] = $rule;
				$messages['option.' . $option->id . '.in'] = 'The ' . $option->title . 'option is invalid';
				$messages['option.' . $option->id . '.required_with'] = 'The ' . $option->title . ' option is required with this extra.';
				$messages['option.' . $option->id . '.string'] = 'The ' . $option->title . ' option must be text.';
			}
		};

		// Validate the quantities
		$rules['quantity'] = 'required|integer|min:1|max:99';

	    return [
			'rules' => $rules,
			'messages' => $messages
		];
	}

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
	public function getOptionsAttribute($value)
	{
		return json_decode($value, true);
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
	public function getExtrasAttribute($value)
	{
		return json_decode($value, true);
	}

	/**
	 * @param $value
	 */
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
