<?php
namespace App\Domains;


use App\Infrastructures\Contracts\EloquentRepositoryInterface;

abstract class RepositoryAbstract
{
    //<editor-fold desc="#field">

    /**
     * Responsible eloquent.
     * @var EloquentRepositoryInterface
     */
    protected $eloquent;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * RepositoryAbstract constructor.
     * @param EloquentRepositoryInterface $eloquentRepository
     */
    public function __construct(EloquentRepositoryInterface $eloquentRepository)
    {
        $this->eloquent = $eloquentRepository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Magic method to call repository methods.
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call(string $method, array $args)
    {
        if (method_exists($this->eloquent, $method)) {
            return call_user_func_array(array($this->eloquent, $method), $args);
        }

        if ($this->eloquent()->isCallable($method)) {
            return call_user_func_array(array($this->eloquent, $method), $args);
        }

        throw new \BadMethodCallException(
            sprintf('Call to undefined method %s::%s', get_class($this->eloquent), $method)
        );
    }

    /**
     * Returns eloquent repository interface.
     * @return EloquentRepositoryInterface
     */
    public function eloquent()
    {
        return $this->eloquent;
    }

    /**
     * Returns new instance.
     * @param array|null $attributes
     * @return mixed
     */
    public function newInstance(array $attributes = null)
    {
        return $this->eloquent()->newInstance($attributes);
    }

    /**
     * Get all records.
     * @return mixed
     */
    public function all()
    {
        return $this->eloquent()->all();
    }

    /**
     * Paginated List.
     * @param int $limit
     * @param int $offset
     * @param array $columns
     * @return mixed
     */
    public function lists(int $limit = 10, int $offset = 0, array $columns = ['*'])
    {
        return $this->eloquent()->paginate($limit, $offset, $columns);
    }

    /**
     * Get record by ID.
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return $this->eloquent()->find($id);
    }

    /**
     * Find record by ID.
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->eloquent()->findWithoutFail($id);
    }

    /**
     * Find record by multiple fields.
     * @param array $where
     * @return mixed
     */
    public function findWhere(array $where)
    {
        return $this->eloquent()->findWhere($where);
    }

    /**
     * Delete record by multiple fields condition.
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where)
    {
        return $this->eloquent()->deleteWhere($where);
    }

    /**
     * First entity or create new.
     * @param array $attributes
     * @return mixed
     */
    public function firstOrCreate(array $attributes)
    {
        return $this->eloquent()->firstOrCreate($attributes);
    }

    /**
     * First entity or Null.
     * @param array $attributes
     * @return mixed
     */
    public function firstOrNull(array $attributes)
    {
        return $this->eloquent()->firstOrNull($attributes);
    }

    /**
     * Get Count.
     * @return mixed
     */
    public function count()
    {
        return $this->eloquent()->all()
            ->count();
    }

    //</editor-fold>
}
