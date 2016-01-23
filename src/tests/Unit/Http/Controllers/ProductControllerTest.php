<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DanPowell\Shop\Http\Controllers\ProductController;

class ProductControllerTest extends TestCase
{

    use DatabaseMigrations;

    private $controller;
    private $productRepository;

    public function setUp()
    {

        $this->productRepository = $this->getMockBuilder('DanPowell\Shop\Repositories\ProductPublicRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new ProductController($this->productRepository);

        parent::setUp();
    }

    public function testBlank()
    {

    }

//    public function testIndexMethod()
//    {
//
//        $this->productRepository->expects($this->once())
//            ->method('getAll');
//
//        $result = $this->controller->index();
//        $this->assertInstanceOf('Illuminate\View\View', $result);
//    }
//
//
//    public function testShowMethodSlug()
//    {
//        $this->productRepository->expects($this->once())
//            ->method('getBySlug');
//
//        $result = $this->controller->show('woof');
//        $this->assertInstanceOf('Illuminate\View\View', $result);
//    }
//
//
//    public function testShowMethodId()
//    {
//        $this->productRepository->expects($this->once())
//            ->method('redirectId');
//
//        $this->controller->show(1);
//    }

}