<?php

namespace App\Infrastructures\HumanResources\Recruitment\RecruitmentSchedule\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentRecruitmentScheduleRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $vacancyApplicationId
     * @return mixed
     */
    public function findWhereByVacancyApplicationId(int $vacancyApplicationId);

    /**
     * @param DateTime $startScheduleDate
     * @param DateTime $endScheduleDate
     * @return mixed
     */
    public function findWhereBetweenByRangeScheduleDate(DateTime $startScheduleDate, DateTime $endScheduleDate);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);


    //</editor-fold>
}
