<?php

namespace App\Infrastructures\HumanResources\Project\ProjectAddendum\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentProjectAddendumRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $projectId
     * @return mixed
     */
    public function findWhereByProjectId(int $projectId);

    /**
     * @param DateTime $date
     * @return mixed
     */
    public function findWhereDateByDate(DateTime $date);

    /**
     * @param DateTime $startIssueDate
     * @param DateTime $endIssueDate
     * @return mixed
     */
    public function findWhereBetweenByRangeIssueDate(DateTime $startIssueDate, DateTime $endIssueDate);

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
