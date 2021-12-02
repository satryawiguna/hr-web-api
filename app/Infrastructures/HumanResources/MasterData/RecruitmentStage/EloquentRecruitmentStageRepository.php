<?php
namespace App\Infrastructures\HumanResources\MasterData\RecruitmentStage;

use App\Infrastructures\HumanResources\MasterData\RecruitmentStage\Contracts\EloquentRecruitmentStageRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentRecruitmentStageRepository Class.
 */
class EloquentRecruitmentStageRepository extends EloquentRepositoryAbstract implements EloquentRecruitmentStageRepositoryInterface
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
