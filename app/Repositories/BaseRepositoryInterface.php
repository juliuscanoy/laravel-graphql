<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * @return mixed
     */
    public function model();

    /**
     * Get records.
     *
     * @param  string[]  $columns
     * @return mixed
     */
    public function get($columns = ['*']);

    /**
     * Get all records.
     *
     * @param  string[]  $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Execute the query and get the first result.
     *
     * @return mixed
     */
    public function first();

    /**
     * Find a record.
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * Create a record.
     *
     * @param  array  $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a record.
     *
     * @param  Model  $model
     * @param  array  $data
     * @return mixed
     */
    public function update(Model $model, array $data);

    /**
     * Delete a record.
     *
     * @param  Model  $model
     * @return mixed
     */
    public function delete(Model $model);

    /**
     * Eager load related tables.
     *
     * @param array $relationships
     * @return mixed
     */
    public function with(array $relationships);
}
