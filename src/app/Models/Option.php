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
		'price_modifier' => 'integer',
    ];

    public $timestamps = false;


    // Relationships



    // Inverse Relationships

	public function optionGroup()
	{
		return $this->belongsTo('DanPowell\Shop\Models\optionGroup');
	}

}
