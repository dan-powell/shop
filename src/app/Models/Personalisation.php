<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Personalisation extends Model {

    protected $fillable = [
        'label',
        'type',
    ];

    public function rules()
	{
	    return [
    	    'label' => 'required',
			'type' => 'required',
	    ];
	}

    protected $casts = [
        'id' => 'integer',
        'price_modifier' => 'decimal'
    ];

    public $timestamps = false;


    // Relationships



    // Inverse Relationships

	public function product()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Product');
	}

}
