<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    protected $fillable = [
        'session_id',
        'status',
    ];

    public function rules()
	{
	    return [
    	    'session_id' => 'required',
			'status' => 'required',
	    ];
	}

    protected $casts = [
        'id' => 'integer'
    ];

    // Relationships

	public function products()
	{
		return $this->hasMany('DanPowell\Shop\Models\CartProduct')->with(['product']);
	}


}
