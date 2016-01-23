<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DanPowell\Shop\Http\Controllers\CategoryController;

class CategoryControllerTest extends TestCase
{

    use DatabaseMigrations;

    private $controller;
    private $categoryPublicRepository;

    public function setUp()
    {

        $this->categoryPublicRepository = $this->getMockBuilder('DanPowell\Shop\Repositories\CategoryPublicRepository')
            //->disableOriginalConstructor()
            ->getMock();


        $this->controller = new CategoryController($this->categoryPublicRepository);

        parent::setUp();
    }

    public function testBlank()
    {

    }

//    public function testIndexMethod()
//    {
//
//        $this->categoryPublicRepository->expects($this->once())
//            ->method('getAll');
//
//        $result = $this->controller->index();
//        $this->assertInstanceOf('Illuminate\View\View', $result);
//    }
//
//
//    public function testShowMethodSlug()
//    {
//        $model = factory(DanPowell\Shop\Models\Category::class, 'published')->create();
//
//        $this->categoryPublicRepository->expects($this->once())
//            ->method('getBySlug');
//
//        $result = $this->controller->show($model->slug);
//        $this->assertInstanceOf('Illuminate\View\View', $result);
//    }
//
//
//    public function testShowMethodId()
//    {
//        $this->categoryPublicRepository->expects($this->once())
//            ->method('redirectById');
//
//        $this->controller->show(1);
//    }

}