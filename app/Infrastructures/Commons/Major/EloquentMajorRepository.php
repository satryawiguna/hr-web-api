<?php
namespace App\Infrastructures\Commons\Major;

use App\Infrastructures\Commons\Major\Contracts\EloquentMajorRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentMajorRepository Class.
 */
class EloquentMajorRepository extends EloquentRepositoryAbstract implements EloquentMajorRepositoryInterface
{
    //<editor-fold desc="#public (method)">

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

    //</editor-fold>
}
