<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\CartItem;

class CartItemRepository extends AbstractRepository
{

    protected $model;
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->model = new CartItem();
        $this->cartRepository = $cartRepository;
    }


    // Abstract class overrides

    /**
     * Get specific item by ID
     * @param $id
     * @param array $with
     * @return mixed
     */
    public function getById($id, array $with = [])
    {
        return $this->makeQuery($with, ['id' => $id])->where('cart_id', '=', $this->cartRepository->getCartIdInsecure())->first();
    }

    /**
     * Update a specific item
     * @param $id
     * @param array $fill
     * @return mixed
     */
    public function update($id, array $fill = [])
    {
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->cartRepository->getCartId())->update($fill);
    }

    /**
     * Delete a specific item
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->cartRepository->getCartId())->delete();
    }

    // Custom methods

    /**
     * Delete all items for a specific cart instance
     * @return mixed
     */
    public function clear()
    {
        return $this->makeQuery()->where('cart_id', '=', $this->cartRepository->getCartId())->delete();
    }

    /**
     * Delete all items that reference a particular product
     * @param $id - Product ID
     * @return mixed
     */
    public function clearProduct($id)
    {
        return $this->makeQuery()->where('cart_id', '=', $this->cartRepository->getCartId())->where('product_id', '=', $id)->delete();
    }

    /**
     * @param array $fill
     * @param $quantity
     * @return mixed
     */
    public function incrementQuantity(array $fill, $quantity)
    {
        return $this->makeQuery()->where($fill)->increment('quantity', $quantity);
    }


}