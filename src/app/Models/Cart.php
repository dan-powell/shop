<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    protected $fillable = [
        'status',
		'session_id'
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

    // Relationships

	public function cartItems()
	{
		return $this->hasMany('DanPowell\Shop\Models\CartItem');
	}

}
