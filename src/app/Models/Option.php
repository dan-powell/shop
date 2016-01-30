<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $fillable = [
		'title',
		'type',
		'config'
    ];

    public function rules()
	{
	    return [
    	    'title' => 'required',
			'type' => 'required',
	    ];
	}

    protected $casts = [
        'id' => 'integer',
		'config' => 'array'
    ];

    public $timestamps = false;


	public function getConfigAttribute($value)
	{
		return json_decode($value, true);
	}

	public function setConfigAttribute($value)
	{
		return json_encode($value);
	}




    // Relationships



    // Inverse Relationships

	public function extra()
	{
		return $this->morphTo('DanPowell\Shop\Models\Extra', 'attachment_id', 'attachment_type');
	}

	public function product()
	{
		return $this->morphTo('DanPowell\Shop\Models\Product', 'attachment_id', 'attachment_type');
	}

}
