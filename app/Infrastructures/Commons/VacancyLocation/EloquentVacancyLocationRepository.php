<?php
namespace App\Infrastructures\Commons\VacancyLocation;

use App\Infrastructures\Commons\VacancyLocation\Contracts\EloquentVacancyLocationRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentVacancyLocationRepository Class.
 */
class EloquentVacancyLocationRepository extends EloquentRepositoryAbstract implements EloquentVacancyLocationRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $parentId
     * @return $this|mixed
     */
    public function findWhereByParentId(int $parentId)
    {
        if ($parentId <> 0) {
            $this->model = $this->model->where('parent_id', $parentId);
        } else {
            $this->model = $this->model->whereNull('parent_id');
        }

        return $this;
    }

    /**
     * @return $this|mixed
     */
    public function findWhereByParentIdIsNull()
    {
        $this->model = $this->model->where('parent_id', null);

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
            'slug' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR slug LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
