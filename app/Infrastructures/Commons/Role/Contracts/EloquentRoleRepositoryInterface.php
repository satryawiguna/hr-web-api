<?php

namespace App\Infrastructures\Commons\Role\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentRoleRepositoryInterface extends EloquentRepositoryInterface
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
