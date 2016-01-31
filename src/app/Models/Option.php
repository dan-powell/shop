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


	public function getConfigAttribute()
	{
		return json_decode($this->attributes['config'], true);
	}

	public function setConfigAttribute($value)
	{
		$this->attributes['config'] = json_encode($value);
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
