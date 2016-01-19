<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DanPowell\Shop\Http\Controllers\CategoryController;

class CategoryControllerTest extends TestCase
{

    use DatabaseMigrations;

    private $controller;
    private $categoryRepository;

    public function setUp()
    {

        $this->categoryRepository = $this->getMock(
            'DanPowell\Shop\Repositories\CategoryRepository'
        );

        $this->controller = new CategoryController($this->categoryRepository);

        parent::setUp();
    }


    public function testIndexMethod()
    {

        $this->categoryRepository->expects($this->once())
            ->method('getAll');

        $result = $this->controller->index();
        $this->assertInstanceOf('Illuminate\View\View', $result);
    }


    public function testShowMethodSlug()
    {
        $this->categoryRepository->expects($this->once())
            ->method('getBySlug');

        $result = $this->controller->show('string');
        $this->assertInstanceOf('Illuminate\View\View', $result);
    }


    public function testShowMethodId()
    {
        $this->categoryRepository->expects($this->once())
            ->method('redirectId');

        $this->controller->show(1);
    }

}