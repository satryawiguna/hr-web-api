<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\WorkExperience\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentWorkExperienceRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findWhereByEmployeeId(int $employeeId);

    /**
     * @param DateTime $date
     * @return mixed
     */
    public function findWhereDateByDate(DateTime $date);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
