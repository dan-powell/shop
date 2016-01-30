<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\CartItem;
//use DanPowell\Shop\Repositories\CartRepository;

class CartItemRepository extends AbstractRepository
{

    public $cart;
    protected $model;
    protected $cartRepository;

    public function __construct(CartRepository $CartRepository)
    {
        $this->model = new CartItem();
        $this->cartRepository = $CartRepository;
        $this->cart = $this->cartRepository->getCart();
    }

    public function getRules($product)
    {
        return CartItem::rules($product);
    }

    public function incrementQuantity(array $fill, $quantity) {
        return $this->model->where($fill)->increment('quantity', $quantity);
    }

    public function create(array $fill) {

        // ...create and save a new item
        $this->model->fill($fill);
        return $this->model->save();

    }

    public function getById($id, array $with = [])
    {
        return $this->makeQuery($with, ['id' => $id])->where('cart_id', '=', $this->cart->id)->first();
    }


    public function update($id, $quantity) {

        // ...create and save a new item
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->cart->id)->update(['quantity' => $quantity]);

    }


    public function delete($id) {

        // ...create and save a new item
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->cart->id)->delete();

    }


}