<?php

namespace App\Infrastructures\Commons\Gender\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentGenderRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $isActive
     * @return mixed
     */
    public function findWhereByIsActive(int $isActive);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
