<?php

namespace App\Infrastructures\Commons\Religion\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentReligionRepositoryInterface extends EloquentRepositoryInterface
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
