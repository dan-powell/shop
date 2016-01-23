<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartPersonalisation extends Model {

    protected $fillable = [
		'personalisation_id',
		'value'
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

	public function personalisation()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Personalisation', 'personalisation_id');
	}

	public function cart()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Cart');
	}

}
