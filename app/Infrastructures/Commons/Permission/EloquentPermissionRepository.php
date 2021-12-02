<?php
namespace App\Infrastructures\Commons\Permission;

use App\Infrastructures\Commons\Permission\Contracts\EloquentPermissionRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentPermissionRepository Class.
 */
class EloquentPermissionRepository extends EloquentRepositoryAbstract implements EloquentPermissionRepositoryInterface
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
            'server' => '%' . $searchQuery . '%',
            'path' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR slug LIKE ?
            OR server LIKE ?
            OR path LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }
}
