<?php

namespace App\Infrastructures\HumanResources\Element\ElementValue\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentElementValueRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $elementId
     * @return mixed
     */
    public function findWhereByElementId(int $elementId);

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
