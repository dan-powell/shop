<?php namespace DanPowell\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\ProductRepository;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartProduct;


class CartController extends Controller {


    protected $productRepository;


    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function index(Request $request)
    {

        $cart = $this->getCart($with = ['products', 'products.product']);

        $cart->groupedProducts = $cart->products->groupBy('product_id');

        //dd(\Session::getId());

        return view('shop::cart.index')->with([
            'cart' => $cart
        ]);
    }



    public function getCart($with = [])
    {
        $cart = Cart::where('session_id', '=', \Session::getId())->with($with)->first();

        // if no cart has been found, then create one
        if(!$cart) {
            $cart = $this->createCart();
        }

        return $cart;
    }


    public function createCart()
    {

        // Update the item with request data
        $cart = new Cart;

        $cart->fill([
            'session_id' => \Session::getId()
        ]);

        $cart->save();

        return $cart;

    }


    public function store(Request $request)
    {

        $cart = $this->getCart();


        $product = $this->productRepository->getById($request->get('product_id'));


        $cart_product = new CartProduct;

        $cart_product->fill([
            'product_id' => $product->id,
            'cart_id' => $cart->id
        ]);

        $cart_product->save();


        //$cart_product = $cart->products()->save($product);









        //$request->session()->put('cart_products', $cart);


        //$request->all();


        //$value = $request->session()->get('key');

        //return $this->sectionRepository->storeSection(new Page, $page_id, $request);

        $session = $request->session()->all();

        return view('shop::cart.index')->with([
            'data2' => $request->all(),
        ]);


    }

}
