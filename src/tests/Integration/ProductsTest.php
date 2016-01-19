<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class ProductsTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
    }


    // Test that Index route returns valid response and data is present
    public function testResponseIndex()
    {
        // Setup

        // Actions
        $this->visit(route('shop.product.index'));

        // Assertions
        $this->assertResponseOk();
        $this->assertViewHasAll(['products']);
    }


    // Test that Show route returns valid response and data is present
    public function testResponseShow()
    {
        // Setup
        $model = factory(DanPowell\Shop\Models\Product::class, 'published')->create();

        // Actions
        $this->visit(route('shop.product.show', $model->slug));

        // Assertions
        $this->assertResponseOk();
        $this->assertViewHasAll(['product']);
        $this->see($model->title);
    }


}
