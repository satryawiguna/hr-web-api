<?php

namespace App\Infrastructures\HumanResources\Mutation\ProjectMutation\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentProjectMutationRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findWhereByEmployeeId(int $employeeId);

    /**
     * @param int $projectId
     * @return mixed
     */
    public function findWhereByProjectId(int $projectId);

    /**
     * @param DateTime $startMutationDate
     * @param DateTime $endMutationDate
     * @return mixed
     */
    public function findWhereBetweenByRangeMutationDate(DateTime $startMutationDate, DateTime $endMutationDate);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
