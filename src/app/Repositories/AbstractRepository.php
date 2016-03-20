<?php namespace DanPowell\Shop\Repositories;

abstract class AbstractRepository
{

    /** Get all records
     * @param array $with
     * @param null $limit
     * @return mixed
     */
    public function getAll(array $with = [], $limit = null)
    {
        return $this->makeQuery($with, [], $limit)->get();
    }

    /** Get record by ID
     * @param $id
     * @param array $with
     * @return mixed
     */
    public function getById($id, array $with = [])
    {
        return $this->makeQuery($with, ['id' => $id])->first();
    }

    /** get record by Slug
     * @param $slug
     * @param array $with
     * @return mixed
     */
    public function getBySlug($slug, array $with = [])
    {
        return $this->makeQuery($with, ['slug' => $slug])->first();
    }

    /** get validation rules from model
     * @param $passthru
     * @return array
     */
    public function getValidationRules($passthru = null)
    {
        return $this->model->validation($passthru);
    }

    /** Create new record
     * @param array $fill
     * @return mixed
     */
    public function create(array $fill)
    {
        $this->model->fill($fill);
        return $this->model->save();
    }

    /** Update record
     * @param $id
     * @param $fill
     * @return mixed
     */
    public function update($id, array $fill)
    {
        return $this->makeQuery([], ['id' => $id])->update($fill);
    }

    /** Delete record
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->makeQuery([], ['id' => $id])->delete();
    }

    /** Begin the make a new query
     * @param array $with
     * @param array $where
     * @param null $limit
     * @return mixed
     */
    public function makeQuery(array $with = [], array $where = [], $limit = null)
    {
        $query = $this->makeModel();
        return $query->with($with)->where($where)->limit($limit);
    }

    /** Get an instance of the associated model
     * @return mixed
     */
    public function makeModel()
    {
        return $this->model;
    }

}