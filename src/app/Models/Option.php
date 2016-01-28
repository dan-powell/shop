<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $fillable = [
        'label',
        'price_modifier',
    ];

    public function rules()
	{
	    return [
    	    'label' => 'required',
			'price_modifier' => 'integer',
	    ];
	}

    protected $casts = [
        'id' => 'integer',
		'price_modifier' => 'decimal',
    ];

    public $timestamps = false;

	protected $appends = ['price_modifier_string'];

	public function getPriceModifierStringAttribute()
	{
		if ($this->price_modifier == 0 || $this->price_modifier == '') {
			return 'free';
		} elseif($this->price_modifier < 0) {
			return '-' . config('shop.currency.symbol') . str_replace('-', '', $this->price_modifier);
		} else {
			return '+' . config('shop.currency.symbol') . $this->price_modifier;
		}
	}

	public function getIsPriceModifierAttribute()
	{
		if ($this->price_modifier == 0 || $this->price_modifier == ''){
			return false;
		} else {
			return true;
		}
	}


    // Relationships



    // Inverse Relationships

	public function optionGroup()
	{
		return $this->belongsTo('DanPowell\Shop\Models\optionGroup');
	}

}
