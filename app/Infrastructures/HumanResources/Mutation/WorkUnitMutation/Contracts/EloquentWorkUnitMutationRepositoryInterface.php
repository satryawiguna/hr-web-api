<?php

namespace App\Infrastructures\HumanResources\Mutation\WorkUnitMutation\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentWorkUnitMutationRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findWhereByEmployeeId(int $employeeId);

    /**
     * @param int $workUnitId
     * @return mixed
     */
    public function findWhereByWorkUnitId(int $workUnitId);

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
