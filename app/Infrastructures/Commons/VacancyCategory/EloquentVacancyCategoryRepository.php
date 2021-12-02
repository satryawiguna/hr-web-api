<?php
namespace App\Infrastructures\Commons\VacancyCategory;

use App\Infrastructures\Commons\VacancyCategory\Contracts\EloquentVacancyCategoryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentVacancyCategoryRepository Class.
 */
class EloquentVacancyCategoryRepository extends EloquentRepositoryAbstract implements EloquentVacancyCategoryRepositoryInterface
{
    //<editor-fold desc="#public (method)">

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
