<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DanPowell\Shop\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::buildTree( $this->generateTree() );

    }


    private function makeModel()
    {
        $model = factory(DanPowell\Shop\Models\Category::class)->make()->toArray();

        unset($model['created_at_human']);
        unset($model['updated_at_human']);

        return $model;
    }


    private function generateTree()
    {

        $root = [];

        $rand = rand(1, 3);
        for ($i = 0; $i < $rand; $i++) {
            array_push($root, $this->makeRootNode() );
        }

        return $root;
    }


    private function makeRootNode()
    {
        $model = $this->makeModel();
        $model['children'] = $this->makeNodes(0);
        return $model;
    }


    private function makeNodes($depth, $min = 0, $max = 3)
    {
        $depth++;
        $maxdepth = 3;
        $arr = [];

        $rand = rand($min, $max);
        for ($i = 0; $i < $rand; $i++) {

            $model = $this->makeModel();

            if($depth < $maxdepth) {
                $model['children'] = $this->makeNodes($depth);
            }

            array_push($arr, $model);

        }

        return $arr;

    }

}