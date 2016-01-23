<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DanPowell\Shop\Repositories\CategoryRepository;


class CategoryRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    private $repository;

    public function setUp()
    {

        $this->repository = new CategoryRepository();

        parent::setUp();
    }

    public function testBlank()
    {

    }

//    public function testMethodGetAll()
//    {
//
//        $result = $this->repository->getAll();
//        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $result);
//
//    }
//
//
//    public function testMethodGetBySlug()
//    {
//
//        $model = factory(DanPowell\Shop\Models\Category::class, 'published')->create();
//
//        $result = $this->repository->getBySlug($model->slug);
//
//        $this->assertInstanceOf('DanPowell\Shop\Models\Category', $result);
//
//    }
//
//
//    public function testMethodGetBySlugBad()
//    {
//
//        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
//
//        $this->repository->getBySlug('boobs');
//
//    }

}

