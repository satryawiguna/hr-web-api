<?php

namespace App\Infrastructures\HumanResources\Element\ElementEntry\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentElementEntryRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $elementId
     * @return mixed
     */
    public function findWhereByElementId(int $elementId);

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findWhereByEmployeeId(int $employeeId);

    /**
     * @param DateTime $date
     * @return mixed
     */
    public function findWhereEffectiveDateByDate(DateTime $date);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
