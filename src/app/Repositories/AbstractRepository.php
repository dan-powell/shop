<?php namespace DanPowell\Shop\Repositories;

abstract class AbstractRepository
{



    public function getAll(array $with = [], integer $limit = null)
    {
        return $this->makeQuery($with, [], $limit)->get();
    }


    public function getById(integer $id, array $with = [])
    {
        return $this->makeQuery($with, ['id' => $id])->first();
    }


    public function getBySlug($slug, array $with = [])
    {
        return $this->makeQuery($with, ['slug' => $slug])->first();

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