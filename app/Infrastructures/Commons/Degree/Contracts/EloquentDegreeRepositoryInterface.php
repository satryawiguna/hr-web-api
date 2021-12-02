<?php

namespace App\Infrastructures\Commons\Degree\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentDegreeRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param $isActive
     * @return mixed
     */
    public function findWhereByIsActive(int $isActive);

    /**
     * @param $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
