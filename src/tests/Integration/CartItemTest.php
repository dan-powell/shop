<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartItemTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
    }



    // ADD PRODUCT TO CART
    public function testAddToCart() {
        // Setup
        $model = factory(DanPowell\Shop\Models\Product::class, 'publishedWithStock')->create();

        $this->visit(route('shop.cart.index'));

//        $cookies = $this->response->headers->getCookies();
//        foreach($cookies as $cookie){
//            //dd($cookie);
//            if($cookie->getName() == 'cart_id') {
//                dd($cookie->getValue());
//            }
//        }

        // Actions
        $this->visit(route('shop.product.show', $model->slug))
            ->press('Add to Cart');

        // Assertions
        $this->assertResponseOk();
        $this->seeCookie('cart_id');
        $this->see('Product added to cart');
        $this->seeInDatabase('cart_items', ['product_id' => $model->id]); // Make sure data has not been added

    }


    // Check all required data is present

    // if extra is selected, all options must be present

    // For each option, check that option id is part of product

    // For each option, check that request value is an available value

    // for each extra, check that extra id is part of product

    // Check that product has enough stock

    // Check that extra has enough stock




}







