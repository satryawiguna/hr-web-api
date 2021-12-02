<?php

namespace App\Infrastructures\HumanResources\Termination\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentTerminationRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findWhereByEmployeeId(int $employeeId);

    /**
     * @param string $type
     * @return mixed
     */
    public function findWhereByType(string $type);

    /**
     * @param DateTime $startTerminationDate
     * @param DateTime $endTerminationDate
     * @return mixed
     */
    public function findWhereBetweenByRangeTerminationDate(DateTime $startTerminationDate, DateTime $endTerminationDate);

    /**
     * @param float $startSeverance
     * @param float $endSeverance
     * @return mixed
     */
    public function findWhereBetweenByRangeSeverance(float $startSeverance, float $endSeverance);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
