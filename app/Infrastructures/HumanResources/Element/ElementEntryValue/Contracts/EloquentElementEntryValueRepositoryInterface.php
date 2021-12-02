<?php

namespace App\Infrastructures\HumanResources\Element\ElementEntryValue\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentElementEntryValueRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $elementEntryId
     * @return mixed
     */
    public function findWhereByElementEntryId(int $elementEntryId);

    /**
     * @param int $elementValueId
     * @return mixed
     */
    public function findWhereByElementValueId(int $elementValueId);

    /**
     * @param DateTime $date
     * @return mixed
     */
    public function findWhereEffectiveDateByDate(DateTime $date);

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
