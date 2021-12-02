<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\WorkCompetence\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentWorkCompetenceRepositoryInterface extends EloquentRepositoryInterface
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
     * @param int $competenceId
     * @return mixed
     */
    public function findWhereByCompetenceId(int $competenceId);

    /**
     * @param DateTime $startIssueDate
     * @param DateTime $endIssueDate
     * @return mixed
     */
    public function findWhereBetweenByRangeIssueDate(DateTime $startIssueDate, DateTime $endIssueDate);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
