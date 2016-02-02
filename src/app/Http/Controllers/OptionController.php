<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\OrderRepository;
use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\CartItemRepository;

use DanPowell\Shop\Models\Option;

use Illuminate\Foundation\Validation\ValidatesRequests;
use DanPowell\Shop\Traits\ImageTrait;
use DanPowell\Shop\Traits\CartTrait;

class OptionController extends BaseController
{

	use ImageTrait;
	use CartTrait;
	use ValidatesRequests;

	protected $repository;
	protected $cartItemRepository;

	public function __construct(OrderRepository $OrderRepository, CartItemRepository $CartItemRepository)
	{
		$this->repository = $OrderRepository;
		$this->cartItemRepository = $CartItemRepository;
	}


	public function update()
	{

		$item = Option::with('attachment')->find(4);

		$item->config = ['test'];

		$item->save();

		return redirect()->back()->withInput(['warning' => 'Please add some items to your cart']);

	}

}
