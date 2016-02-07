<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartItem;
use DanPowell\Shop\Repositories\ProductPublicRepository;
use DanPowell\Shop\Http\Requests\ProcessCartItemRequest;

use Illuminate\Session;


class CartItemRepository extends AbstractRepository
{

    protected $model;
    protected $productPublicRepository;

    public function __construct(ProductPublicRepository $ProductPublicRepository)
    {
        $this->model = new CartItem();
        $this->productPublicRepository = $ProductPublicRepository;
    }


    // Some methods to manage the cart instance

    /**
     * @return mixed
     */
    public function getCartId()
    {
        // Get the session ID from cookie
        $cart_id = request()->cookie('cart_id');

        // if no cookie has been found, then create cart
        if(!$cart_id) {

            // Save to DB
            $cart = Cart::create();

            // Set the cookie
            cookie()->queue('cart_id', $cart->id, 10080);

            // Return the ID
            $cart_id = $cart->id;

        }

        // Return the ID
        return $cart_id;
    }

    public function getVerifiedCartId()
    {
        // Get the session ID from cookie
        $cart_id = request()->cookie('cart_id');

        $cart = Cart::where('id', '=', $cart_id)->first();

        // Create the cart
        if(!$cart) {
            $cart = Cart::create();
            cookie()->queue('cart_id', $cart->id, 10080);
        }

        // Return the ID
        return $cart->id;
    }

    /**
     * @return mixed
     */
    public function getCartItems($with = [])
    {
        return $this->model->where('cart_id', '=', $this->getCartId())->with($with)->get();
    }

    /**
     * @return Cart
     */
    public function getCart($with = [])
    {
        return Cart::with($with)->find($this->getCartId());
    }

    /**
     * @return Cart
     */
    public function clearCart()
    {
        return $this->makeQuery()->where('cart_id', '=', $this->getCartId())->delete();
    }

    /**
     * @return Cart
     */
    public function clearCartProduct($id)
    {
        return $this->makeQuery()->where('cart_id', '=', $this->getCartId())->where('product_id', '=', $id)->delete();
    }


    // Abstract class overrides

    /**
     * @param $id
     * @param array $with
     * @return mixed
     */
    public function getById($id, array $with = [])
    {
        return $this->makeQuery($with, ['id' => $id])->where('cart_id', '=', $this->getCartId())->first();
    }

    /**
     * @param $id
     * @param $quantity
     * @return mixed
     */
    public function update($id, $quantity)
    {
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->getCartId())->update(['quantity' => $quantity]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->getCartId())->delete();
    }


    // Custom methods




    public function store($request)
    {

        // Find product to be added
        $product = $this->productPublicRepository->getById($request->get('product_id'), ['extras.options', 'options']);

        if(!$product) {
            return redirect()->route('shop.product.show', $product->slug);
        }


        // Set the Product option values
        $submittedOptions = $request->get('option');
        $product->options->each(function ($option) use ($submittedOptions) {
            if (isset($submittedOptions[$option->id])) {
                $option->value = $submittedOptions[$option->id];
            }
        });

        // Set the Extras (filter out extras user has not selected)
        $submittedExtras = $request->get('extra');
        $product->extras = $product->extras->filter(function ($extra) use ($submittedExtras) {
            if (isset($submittedExtras[$extra->id])) {
                return $extra;
            }
        });

        // Set the chosen Extras values
        $product->extras->each(function ($extra) use ($submittedOptions) {
            $extra->options->each(function ($option) use ($submittedOptions) {
                $option->value = $submittedOptions[$option->id];
            });
        });


        // Find all items of the same product, so we can calculate the total quantity in the cart
        $quantityToCheck = $this->getTotalProductQuantityInCart($product->id) + $request->get('quantity');


        // Check product stock
        if(!$product->checkStock($quantityToCheck)) {
            session()->flash('alert-warning', 'Not enough product stock available.');
            return redirect()->route('shop.product.show', $product->slug);
        }

        // Check product extras stock
        $product->extras->each(function ($extra) use ($quantityToCheck, $product) {
            if(!$extra->checkStock($quantityToCheck)) {
                session()->flash('alert-warning', 'Not enough stock available to add this extra.');
                return redirect()->route('shop.product.show', $product->slug);
            }
        });


        $fill = [
            'cart_id' => $this->getVerifiedCartId(),
            'product_id' => $product->id,
            'options' => $product->options,
            'extras' => $product->extras
        ];

        // Check if this item config is already saved & update quantity...
        $findItem = $this->incrementQuantity($fill, $request->get('quantity'));

        // ...otherwise, if no matching items were found...
        if(!$findItem) {
            $fill['quantity'] = $request->get('quantity');
            $this->create($fill);
        }
    }









    /**
     * @param array $fill
     * @param $quantity
     * @return mixed
     */
    public function incrementQuantity(array $fill, $quantity)
    {
        return $this->model->where($fill)->increment('quantity', $quantity);
    }



    public function getTotalProductQuantityInCart($product_id)
    {
        // Find all items of the same product, so we can calculate the total quantity in the cart
        $items = $this->getCartItems()->where(
            'product_id', $product_id
        )->all();

        // Get the total quantity of product in the cart
        if($items) {
            $quantity = 0;
            // Sum all cart items linked to product
            foreach($items as $item) {
                $quantity += $item->quantity;
            }

            return $quantity;

        } else {
            return 0;
        }
    }

}