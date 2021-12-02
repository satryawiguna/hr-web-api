<?php

namespace App\Infrastructures\HumanResources\Project\ProjectTerms\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentProjectTermsRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $projectId
     * @return mixed
     */
    public function findWhereByProjectId(int $projectId);

    /**
     * @param float $startValue
     * @param float $endValue
     * @return mixed
     */
    public function findWhereBetweenByRangeValue(float $startValue, float $endValue);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
