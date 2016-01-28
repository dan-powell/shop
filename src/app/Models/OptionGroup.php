<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model {

    protected $fillable = [
        'title',
        'type',
        'description'
    ];

    public function rules()
	{
	    return [
    	    'title' => 'required',
			'type' => 'integer',
	    ];
	}

    protected $casts = [
        'id' => 'integer'
    ];

	public $timestamps = false;


	public function getHasStockAttribute()
	{
		$bool = false;
		foreach($this->options as $option) {
			if($option->stock){
				$bool = true;
			}
		}

		return $bool;
	}


    // Relationships

    public function options()
    {
        return $this->hasMany('DanPowell\Shop\Models\Option');
    }

    // Inverse Relationships

	public function product()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Product');
	}

}
