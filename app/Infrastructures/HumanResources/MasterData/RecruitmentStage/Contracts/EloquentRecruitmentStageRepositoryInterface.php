<?php

namespace App\Infrastructures\HumanResources\MasterData\RecruitmentStage\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentRecruitmentStageRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
