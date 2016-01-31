<?php namespace DanPowell\Shop\Repositories;

abstract class AbstractRepository
{



    public function getAll(array $with = [], $limit = null)
    {
        return $this->makeQuery($with, [], $limit)->get();
    }


    public function getById($id, array $with = [])
    {
        return $this->makeQuery($with, ['id' => $id])->first();
    }


    public function getBySlug($slug, array $with = [])
    {
        return $this->makeQuery($with, ['slug' => $slug])->first();

    }


    public function create(array $fill) {

        // ...create and save a new item
        $this->model->fill($fill);
        return $this->model->save();

    }

    public function update($id, $fill) {

        // ...create and save a new item
        return $this->makeQuery([], ['id' => $id])->update($fill);

    }

    public function delete($id) {

        // ...create and save a new item
        return $this->makeQuery([], ['id' => $id])->delete();

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