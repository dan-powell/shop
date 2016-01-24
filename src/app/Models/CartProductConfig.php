<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartProductConfig extends Model {

    protected $fillable = [
		'options',
		'personalisations'
    ];

    public function rules()
	{
	    return [

	    ];
	}

    protected $casts = [
        'id' => 'integer',
    ];

    public $timestamps = false;


    // Relationships


    // Inverse Relationships

	public function cartProduct()
	{
		return $this->belongsTo('DanPowell\Shop\Models\CartProduct');
	}

}
