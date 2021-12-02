<?php

namespace App\Infrastructures\Vacancy\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentVacancyRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

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
     * @param int $degreeId
     * @return mixed
     */
    public function findWhereByDegreeId(int $degreeId);

    /**
     * @param int $status
     * @return mixed
     */
    public function findWhereByStatus(int $status);

    /**
     * @param DateTime $startPublishDate
     * @param DateTime $endPublishDate
     * @return mixed
     */
    public function findWhereBetweenByRangePublishDate(DateTime $startPublishDate, DateTime $endPublishDate);

    /**
     * @param DateTime $startExpiredDate
     * @param DateTime $endExpiredDate
     * @return mixed
     */
    public function findWhereBetweenByRangeExpiredDate(DateTime $startExpiredDate, DateTime $endExpiredDate);

    /**
     * @param int $startSalary
     * @param int $endSalary
     * @return mixed
     */
    public function findWhereBetweenByRangeSalary(int $startSalary, int $endSalary);

    /**
     * @param string $workStatus
     * @return mixed
     */
    public function findWhereByWorkStatus(string $workStatus);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);


    //</editor-fold>
}
