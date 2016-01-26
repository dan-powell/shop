<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartProductConfig extends Model {

    protected $fillable = [
		'options',
		'personalisations',
		'sub_total'
    ];

    public function rules()
	{
	    return [

	    ];
	}

    protected $casts = [
        'id' => 'integer',
        'sub_total' => 'decimal'
    ];

    public $timestamps = false;


    // Relationships


    // Inverse Relationships

	public function cartProduct()
	{
		return $this->belongsTo('DanPowell\Shop\Models\CartProduct');
	}

}
