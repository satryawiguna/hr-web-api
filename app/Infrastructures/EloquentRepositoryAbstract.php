<?php

namespace App\Infrastructures;

use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Infrastructures\Contracts\EloquentRepositoryInterface;

abstract class EloquentRepositoryAbstract implements EloquentRepositoryInterface
{
    //<editor-fold desc="#field">

    protected $connection;

    /**
     * Eloquent Model.
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $scopeQuery = null;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Setting our class $model to the injected model.
     * @param EloquentAbstract $model
     */
    public function __construct(EloquentAbstract $model)
    {
        $this->connection = $model->getConnection();

        $this->model = $model;

        $this->boot();
    }

    //</editor-fold>


    //<editor-fold desc="#public (magic) method">

    /**
     * Magic method to call model's methods.
     * @param $method
     * @param $args
     * @return mixed
     * @throws RepositoryException
     */
    public function __call($method, $args)
    {
        $this->applyScope();
        $this->resetScope();

        $model = $this->model;

        $this->resetModel();

        if ($this->isCallable($method)) {
            $result = call_user_func_array(array($model, $method), $args);

            return $result;
        }

        throw new \BadMethodCallException(sprintf('Call to undefined method %s::%s', get_class($this->model), $method));
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @return EloquentAbstract|Model
     */
    public function modelInstance()
    {
        if ($this->model instanceof EloquentAbstract) {
            return $this->model;
        }

        return $this->model->getModel();
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        return $this->model = $this->newInstance([]);
    }

    /**
     * Create a new instance of entity.
     * @param array|null $attributes
     * @return EloquentAbstract|Model
     */
    public function newInstance(array $attributes = null)
    {
        return $this->modelInstance()->newInstance($attributes);
    }

    /**
     * @throws RepositoryException
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * Check if model has this method.
     * @param string $method
     * @return bool
     */
    public function isCallable(string $method)
    {
        return method_exists($this->model, $method) ||
            method_exists($this->model->toBase(), $method);
    }

    /**
     * Raw.
     * @param string $rawString
     * @return \Illuminate\Database\Query\Expression
     */
    public function raw(string $rawString)
    {
        return $this->connection->raw($rawString);
    }

    /**
     * Get table.
     * @return string
     */
    public function getTable()
    {
        return $this->modelInstance()->getTable();
    }

    /**
     * @param Closure $scope
     * @return $this
     */
    public function scopeQuery(Closure $scope)
    {
        $this->scopeQuery = $scope;

        return $this;
    }


    //<editor-fold desc="#implementation">

    /**
     * Retrieve all data of repository.
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     * @throws RepositoryException
     */
    public function all(array $columns = ['*'])
    {
        $this->applyScope();

        if ($columns = ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();

        $this->resetScope();

        return $results;
    }

    /**
     * Retrieve data array for populate field select.
     * @param string|null $key
     * @return array|Collection
     * @throws RepositoryException
     */
    public function lists(string $key = null)
    {
        $results = $this->model->pluck($key);

        $this->resetModel();

        return $results;
    }

    /**
     * Retrieve all data of repository, paginated.
     * @param int $limit
     * @param int $offset
     * @param array $columns
     * @return Collection|mixed
     * @throws RepositoryException
     */
    public function paginate(int $limit = 10, int $offset = 0, array $columns = ['*'])
    {
        $this->applyScope();

        $query = $this->model->toBase();

        $select = 'distinct '.env('DB_TABLE_PREFIX').$this->modelInstance()->getTable().'.id';
        $total = $query->getCountForPagination([$this->connection->raw($select)]);

        if (!$total || (int) $limit <= 0 || $offset < 0 || $offset >= $total) {
            $this->resetModel();
            $this->resetScope();

            return new Collection();
        }

        $results = $this->model->take($limit)->offset($offset)->get($columns);

        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    /**
     * Find data by id.
     * @param int $id
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function find(int $id, array $columns = ['*'])
    {
        $this->applyScope();

        if ($columns = ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $results = $this->model->findOrFail($id, $columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find data by multiple fields.
     * @param array $where
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function findWhere(array $where, array $columns = ['*'])
    {
        $this->applyScope();

        $this->applyConditions($where);

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $results = $this->model->get($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find data by multiple values in one field.
     * @param string $field
     * @param array $values
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function findWhereIn(string $field, array $values, array $columns = ['*'])
    {
        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $results = $this->model->whereIn($field, $values)->get($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find data by excluding multiple values in one field.
     * @param string $field
     * @param array $values
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function findWhereNotIn(string $field, array $values, array $columns = ['*'])
    {
        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $results = $this->model->whereNotIn($field, $values)->get($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Find data by id.
     * @param int $id
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function findWithoutFail(int $id, array $columns = ['*'])
    {
        $this->applyScope();

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $result = $this->model->find($id, $columns);

        $this->resetModel();

        return $result;
    }

    /**
     * Save a new entity in repository.
     * @param array $attributes
     * @param array|null $relations
     * @return mixed|static
     */
    public function create(array $attributes, array $relations = null)
    {
        $model = $this->modelInstance()->newInstance($attributes);

        // Attach, CreateMany, SaveMany
        if (!is_null($relations)) {
            foreach ($relations as $key => $value) {
                if ($value['method'] == 'associate') {
                    if (method_exists($model, $key)) {
                        $model->$key()->{$value['method']}($value['data']);
                    }
                }
            }

            $model->save();

            foreach ($relations as $key => $value) {
                if ($value['method'] != 'associate') {
                    if (method_exists($model, $key)) {
                        $model->$key()->{$value['method']}($value['data']);
                    }
                }
            }
        } else {
            $model->save();
        }

        $this->resetModel();

        return $model;
    }

    /**
     * @param array $attributes
     * @return EloquentAbstract|Model|mixed
     */
    public function insert(array $attributes)
    {
        $model = $this->modelInstance()->newInstance();
        $model->insert($attributes);

        $this->resetModel();

        return $model;
    }

    /**
     * Update a entity in repository by id.
     * @param array $attributes
     * @param int $id
     * @param array|null $relations
     * @return mixed
     */
    public function update(array $attributes, int $id, array $relations = null)
    {
        $model = $this->modelInstance()->findOrFail($id);
        $model->fill($attributes);

        // Sync
        if (!is_null($relations)) {
            foreach ($relations as $key => $value) {
                if (method_exists($model, $key)) {
                    switch ($value['method']) {
                        case "push":
                            $model->save();

                            $data = $model->$key()->first()->fill($value['data']);
                            $model->$key()->save($data);
                            break;

                        case "detachAttach":
                            $model->save();

                            $model->$key()->detach($value['detachIds']);
                            $model->$key()->attach($value['data']);
                            break;

                        default:
                            $model->save();

                            if (array_key_exists('isDetach', $value)
                                && $value['isDetach']) {
                                $model->$key()->{$value['method']}($value['data'], $value['isDetach']);
                            } else {
                                $model->$key()->{$value['method']}($value['data']);
                            }
                            break;
                    }
                }
            }
        } else {
            $model->save();
        }

        $this->resetModel();

        return $model;
    }

    /**
     * Update or Create an entity in repository.
     * @param array $params
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $params, array $attributes)
    {
        return $this->modelInstance()->updateOrCreate($params, $attributes);
    }

    /**
     * Delete a entity in repository by id.
     * @param int|array $id
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return int
     */
    public function delete($id, bool $isPermanentDelete = false, array $relations = null)
    {
        $this->resetModel();

        $ids = is_array($id) ? $id : [$id];

        // Detach
        if (!is_null($relations)) {
            foreach ($relations as $key => $value) {
                if (method_exists($this->modelInstance(), $key)) {
                    $this->modelInstance()->$key()->{$value['method']}($ids);
                }
            }
        }

        if ($isPermanentDelete) {
            $model = $this->modelInstance()->whereIn('id', $ids)->delete();
        } else {
            $model = $this->modelInstance()->destroy($ids);
        }

        return $model;
    }

    /**
     * Delete multiple entities by given criteria.
     * @param array $where
     * @return bool|null
     * @throws RepositoryException
     * @throws \Exception
     */
    public function deleteWhere(array $where)
    {
        $this->applyScope();
        $this->applyConditions($where);

        $model = $this->model->delete();

        $this->resetModel();

        return $model;
    }

    /**
     * Retrieve first data of repository.
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function first(array $columns = ['*'])
    {
        $this->applyScope();

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}"];
        }

        $result = $this->model->first($columns);

        $this->resetModel();

        return $result;
    }

    /**
     * Retrieve first data of repository or return null.
     * @param array $attributes
     * @return null
     * @throws RepositoryException
     */
    public function firstOrNull(array $attributes)
    {
        $this->applyConditions($attributes);

        $result = $this->model->first();

        $this->resetModel();

        return $result ?: null;
    }

    /**
     * Retrieve first data of repository or create it.
     * @param array $attributes
     * @return EloquentRepositoryAbstract|mixed
     * @throws RepositoryException
     */
    public function firstOrCreate(array $attributes)
    {
        $this->applyConditions($attributes);

        $result = $this->model->first();

        $this->resetModel();

        return $result ?: $this->create($attributes);
    }

    /**
     * Count data by multiple fields.
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function countWhere(array $where, array $columns = ['id'])
    {
        $this->applyScope();
        $this->applyConditions($where);

        if ($columns = ['id']) {
            $columns = ["{$this->modelInstance()->getTable()}.id"];
        }

        $count = $this->model->count($columns);

        $this->resetModel();

        return $count;
    }

    /**
     * Load relations.
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * @param $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);

        return $this;
    }

    /**
     * Check if entity has relation.
     * @param $relation
     * @return $this
     */
    public function has($relation)
    {
        $this->model = $this->model->has($relation);

        return $this;
    }

    /**
     * Check if entity doesn't have relation.
     * @param $relation
     * @return $this|mixed
     */
    public function doesntHave($relation)
    {
        $this->model = $this->model->doesntHave($relation);

        return $this;
    }

    /**
     * Load relation with closure.
     * @param $relation
     * @param $closure
     * @return $this
     */
    public function whereHas($relation, $closure)
    {
        $this->model = $this->model->whereHas($relation, $closure);

        return $this;
    }

    /**
     * @param $relation
     * @param $closure
     * @return $this|mixed
     */
    public function orWhereHas($relation, $closure)
    {
        $this->model = $this->model->orWhereHas($relation, $closure);

        return $this;
    }

    /**
     * Set order column.
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    /**
     * Set hidden fields.
     * @param array $fields
     * @return $this
     */
    public function hidden(array $fields)
    {
        $this->model->setHidden($fields);

        return $this;
    }

    /**
     * Set visible fields.
     * @param array $fields
     * @return $this
     */
    public function visible(array $fields)
    {
        $this->model->setVisible($fields);

        return $this;
    }

    //</editor-fold>

    //</editor-fold>


    //<editor-fold desc="#protected (method)">

    /**
     * Called when constructed.
     */
    protected function boot()
    {
    }

    /**
     * Applies the given where conditions to the model.
     * @param array $where
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;

                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    /**
     * Apply scope in current Query.
     * @return $this
     */
    protected function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $callback = $this->scopeQuery;
            $this->model = $callback($this->model);
        }

        return $this;
    }

    /**
     * Reset Query Scope.
     * @return $this
     */
    public function resetScope()
    {
        $this->scopeQuery = null;

        return $this;
    }

    //</editor-fold>
}
