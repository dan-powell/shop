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

	protected $appends = ['nice_price'];

	public function getNicePriceAttribute()
	{
		return number_format($this->price_modifier / 100, 2) . ' GBP';
	}


    // Relationships



    // Inverse Relationships

	public function optionGroup()
	{
		return $this->belongsTo('DanPowell\Shop\Models\optionGroup');
	}

}
