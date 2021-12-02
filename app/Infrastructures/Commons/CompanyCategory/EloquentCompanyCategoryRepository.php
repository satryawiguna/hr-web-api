<?php
namespace App\Infrastructures\Commons\CompanyCategory;

use App\Infrastructures\Commons\CompanyCategory\Contracts\EloquentCompanyCategoryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentCompanyCategoryRepository Class.
 */
class EloquentCompanyCategoryRepository extends EloquentRepositoryAbstract implements EloquentCompanyCategoryRepositoryInterface
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
