<?php

namespace App\Infrastructures\Commons\Group\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentGroupRepositoryInterface extends EloquentRepositoryInterface
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
