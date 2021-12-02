<?php

namespace App\Infrastructures\Area\City\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentCityRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $stateId
     * @return mixed
     */
    public function findWereByStateId(int $stateId);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
