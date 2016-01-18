<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class ShopTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
    }


    // Test that Show route returns valid response and data is present
    public function testResponseHome()
    {
        // Setup
        $models = factory(DanPowell\Shop\Models\Product::class, 'featured', 3)->create();

        // Actions
        $this->visit(route('shop'));

        // Assertions
        $this->assertResponseOk();
        $this->see($models[0]->title);
    }


/*
    // Test that Admin route redirects if not logged in
    public function testResponseAdminRedirect()
    {
        // Setup

        // Actions
        $this->call('GET', route('admin'));

        // Assertions
        $this->assertResponseStatus('302');
        $this->assertRedirectedTo('auth/login');
    }


    // Test that Admin route returns
    public function testResponseAdminRedirect()
    {
        // Setup
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->call('GET', route('admin'));

        // Assertions
        $this->assertResponseOk();
    }
*/

}
