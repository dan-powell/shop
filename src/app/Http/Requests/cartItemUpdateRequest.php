<?php namespace DanPowell\Shop\Http\Requests;

use App\Http\Requests\Request;

class CartItemUpdateRequest extends Request
{

    public function __construct()
    {

    }

    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
        ];
    }


}