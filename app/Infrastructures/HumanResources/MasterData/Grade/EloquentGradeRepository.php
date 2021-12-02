<?php
namespace App\Infrastructures\HumanResources\MasterData\Grade;

use App\Infrastructures\HumanResources\MasterData\Grade\Contracts\EloquentGradeRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentGradeRepository Class.
 */
class EloquentGradeRepository extends EloquentRepositoryAbstract implements EloquentGradeRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return $this|mixed
     */
    public function findWhereByCompanyId(int $companyId)
    {
        $this->model = $this->model->where('company_id', $companyId);

        return $this;
    }

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
