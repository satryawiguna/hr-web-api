<?php
namespace App\Infrastructures\Commons\Access;

use App\Infrastructures\Commons\Access\Contracts\EloquentAccessRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentAccessRepository Class.
 */
class EloquentAccessRepository extends EloquentRepositoryAbstract implements EloquentAccessRepositoryInterface
{
    /**
     * @param int $isActive
     * @return $this|mixed
     */
    public function findWhereByIsActive(int $isActive)
    {
        $this->model = $this->model->where('is_active', $isActive);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'name' => '%' . $searchQuery . '%',
            'slug' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR slug LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }
}
