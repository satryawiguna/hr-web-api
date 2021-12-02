<?php

namespace App\Infrastructures\Contracts;


interface EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * Retrieve all data of repository.
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    /**
     * Retrieve data array for populate field select.
     * @param string|null $key
     * @return \Illuminate\Support\Collection|array
     */
    public function lists(string $key = null);

    /**
     * Retrieve all data of repository, paginated.
     * @param int $limit
     * @param int $offset
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $limit = 10, int $offset = 0, array $columns = ['*']);

    /**
     * Find data by id.
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find(int $id, array $columns = ['*']);

    /**
     * Find data by multiple fields.
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, array $columns = ['*']);

    /**
     * Find data by multiple values in one field.
     * @param string $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereIn(string $field, array $values, array $columns = ['*']);

    /**
     * Find data by excluding multiple values in one field.
     * @param string $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereNotIn(string $field, array $values, array $columns = ['*']);

    /**
     * Find data by excluding error if data was not found.
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function findWithoutFail(int $id, array $columns = ['*']);

    /**
     * Save a new entity in repository.
     * @param array $attributes
     * @param array|null $relations
     * @return mixed
     */
    public function create(array $attributes, array $relations = null);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function insert(array $attributes);

    /**
     * Update a entity in repository by id.
     * @param array $attributes
     * @param int $id
     * @param array|null $relations
     * @return mixed
     */
    public function update(array $attributes, int $id, array $relations = null);

    /**
     * Update or Create an entity in repository.
     * @param array $params
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $params, array $attributes);

    /**
     * Delete a entity in repository by id.
     * @param int|array $id
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function delete($id, bool $isPermanentDelete = false, array $relations = null);

    /**
     * Delete a entity with where condition.
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where);

    /**
     * Retrieve first data of repository.
     * @param array $columns
     * @return mixed
     */
    public function first(array $columns = ['*']);

    /**
     * Retrieve first data of repository or return null.
     * @param array $attributes
     * @return mixed
     */
    public function firstOrNull(array $attributes);

    /**
     * Find data with attributes match $attributes or create new one.
     * @param array $attributes;
     * @return mixed
     */
    public function firstOrCreate(array $attributes);

    /**
     * Count data by multiple fields.
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function countWhere(array $where, array $columns = ['*']);

    /**
     * Load relations.
     * @param $relations
     * @return $this
     */
    public function with($relations);

    /**
     * @param $relations
     * @return mixed
     */
    public function withCount($relations);

    /**
     * @param $relation
     * @return mixed
     */
    public function has($relation);

    /**
     * @param $relation
     * @return mixed
     */
    public function doesntHave($relation);

    /**
     * @param $relation
     * @param $closure
     * @return mixed
     */
    public function whereHas($relation, $closure);

    /**
     * @param $relation
     * @param $closure
     * @return mixed
     */
    public function orWhereHas($relation, $closure);


    /**
     * Order collection by a given column.
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'asc');

    /**
     * Set hidden fields.
     * @param array $fields
     * @return $this
     */
    public function hidden(array $fields);

    /**
     * Set visible fields.
     * @param array $fields
     * @return $this
     */
    public function visible(array $fields);

    //</editor-fold>
}
