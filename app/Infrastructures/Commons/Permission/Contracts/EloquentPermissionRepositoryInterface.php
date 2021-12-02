<?php

namespace App\Infrastructures\Commons\Permission\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentPermissionRepositoryInterface extends EloquentRepositoryInterface
{
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
}
