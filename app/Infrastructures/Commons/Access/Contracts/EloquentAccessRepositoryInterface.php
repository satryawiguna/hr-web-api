<?php

namespace App\Infrastructures\Commons\Access\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentAccessRepositoryInterface extends EloquentRepositoryInterface
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
