<?php

namespace App\Infrastructures\HumanResources\Vacancy\Contracts;

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
     * @param int $vacancyLocationId
     * @return mixed
     */
    public function findWhereByVacancyLocationId(int $vacancyLocationId);

    /**
     * @param int $vacancyCategoryId
     * @return mixed
     */
    public function findWhereByVacancyCategoryId(int $vacancyCategoryId);

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
     * @param string $workStatus
     * @return mixed
     */
    public function findWhereByWorkStatus(string $workStatus);

    /**
     * @param string $workType
     * @return mixed
     */
    public function findWhereByWorkType(string $workType);

    /**
     * @param string $status
     * @return mixed
     */
    public function findWhereByStatus(string $status);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);


    //</editor-fold>
}
