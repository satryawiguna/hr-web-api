<?php

namespace App\Infrastructures\HumanResources\Mutation\PositionMutation\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentPositionMutationRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findWhereByEmployeeId(int $employeeId);

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $positionId
     * @return mixed
     */
    public function findWhereByPositionId(int $positionId);

    /**
     * @param int $gradeId
     * @return mixed
     */
    public function findWhereByGradeId(int $gradeId);

    /**
     * @param $startMutationDate
     * @param $endMutationDate
     * @return mixed
     */
    public function findWhereBetweenByRangeMutationDate(DateTime $startMutationDate, Datetime $endMutationDate);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQueryEmployee(string $searchQuery);

    //</editor-fold>
}
