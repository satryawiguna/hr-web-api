<?php

namespace App\Infrastructures\HumanResources\Project\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentProjectRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $parentId
     * @return mixed
     */
    public function findWhereByParentId(int $parentId);

    /**
     * @return mixed
     */
    public function findWhereByParentIdIsNull();

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $contractTypeId
     * @return mixed
     */
    public function findWhereByContractTypeId(int $contractTypeId);

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
