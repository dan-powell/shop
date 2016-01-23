<?php namespace DanPowell\Shop\Repositories;

abstract class AbstractRepository
{



    public function getAll($limit = null)
    {
        return $this->makeQuery(['images', 'categories'], [], $limit)->get();
    }


    public function getById($id)
    {
        return $this->makeQuery(['optionGroups', 'personalisations'], ['id' => $id])->first();
    }


    public function getBySlug($slug)
    {
        return $this->makeQuery(['images', 'related.images', 'optionGroups', 'personalisations'], ['slug' => $slug])->first();

    }


    public function makeQuery(array $with = [], array $where = [], $limit = null)
    {

        $query = $this->makeModel();

        return $query->with($with)->where($where)->limit($limit);
    }


    public function makeModel()
    {
        return $this->model;
    }

}