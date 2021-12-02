<?php

namespace App\Infrastructures\Area\State\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentStateRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $countryId
     * @return mixed
     */
    public function findWereByCountryId(int $countryId);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
