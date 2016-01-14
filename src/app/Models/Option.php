<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $fillable = [
        'title',
        'type',
        'description',
        'config'
    ];

    public function rules()
	{
	    return [
    	    'markup' => 'required',
	        'rank' => 'integer'
	    ];
	}

    protected $casts = [
        'id' => 'integer'
    ];

	public $timestamps = false;

/*
	public function attachment()
    {
        return $this->morphTo();
    }

    protected $touches = ['attachment'];
*/

}
