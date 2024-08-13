<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepositoryEloquent implements BaseRepositoryInterface
{
    /**
     * @var $model
     */
    private $model;

    /**
     * BaseRepositoryEloquent constructor.
     * @param  Model  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Get records.
     *
     * @param  string[]  $columns
     * @return Collection|\Illuminate\Support\Collection|Model[]
     */
    public function get($columns = ['*'])
    {
        return $this->model()->get($columns);
    }

    /**
     * Get all records.
     *
     * @param  string[]  $columns
     * @return Collection|Model[]
     */
    public function all($columns = ['*'])
    {
        return $this->model()->all($columns);
    }

    /**
     * Execute the query and get the first result.
     *
     * @return Model|object|null
     */
    public function first()
    {
        return $this->model()->first();
    }

    /**
     * Find a record.
     *
     * @param  int  $id
     * @return Collection|Model|Model[]|mixed|null
     */
    public function find(int $id)
    {
        return $this->model()->find($id);
    }

    /**
     * Create a record.
     *
     * @param  array  $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model()->create($data);
    }

    /**
     * Update a record.
     *
     * @param  Model  $model
     * @param  array  $data
     * @return Model
     */
    public function update(Model $model, array $data)
    {
        $model->update($data);

        return $model;
    }

    /**
     * Delete a record.
     *
     * @param  Model  $model
     * @return bool|mixed|null
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * Eager load related tables.
     *
     * @param array $relationships
     * @return Builder
     */
    public function with(array $relationships): Builder
    {
        return $this->model()->with($relationships);
    }
}
