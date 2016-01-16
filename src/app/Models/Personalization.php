<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Personalization extends Model {

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
    ];

    public $timestamps = false;


    // Relationships



    // Inverse Relationships

	public function product()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Product');
	}

}
