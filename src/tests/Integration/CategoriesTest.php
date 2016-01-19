<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class CategoriesTest extends TestCase
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
        $this->visit(route('shop.category.index'));

        // Assertions
        $this->assertResponseOk();
        $this->assertViewHasAll(['categories']);
    }


    // Test that Show route returns valid response and data is present
    public function testResponseShow()
    {
        // Setup
        $model = factory(DanPowell\Shop\Models\Category::class, 'published')->create();

        // Actions
        $this->visit(route('shop.category.show', $model->slug));

        // Assertions
        $this->assertResponseOk();
        $this->assertViewHasAll(['category']);
        $this->see($model->title);
    }

    // TODO - Don't forget to check that 'published' relations appear correctly on the page.


}
