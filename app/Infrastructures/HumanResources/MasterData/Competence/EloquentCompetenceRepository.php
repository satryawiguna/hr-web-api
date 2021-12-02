<?php
namespace App\Infrastructures\HumanResources\MasterData\Competence;

use App\Infrastructures\HumanResources\MasterData\Competence\Contracts\EloquentCompetenceRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentCompetenceRepository Class.
 */
class EloquentCompetenceRepository extends EloquentRepositoryAbstract implements EloquentCompetenceRepositoryInterface
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
            'code' => '%' . $searchQuery . '%',
            'name' => '%' . $searchQuery . '%',
            'slug' => '%' . $searchQuery . '%',
            'description' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(code LIKE ?
            OR name LIKE ?
            OR slug LIKE ?
            OR description LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
