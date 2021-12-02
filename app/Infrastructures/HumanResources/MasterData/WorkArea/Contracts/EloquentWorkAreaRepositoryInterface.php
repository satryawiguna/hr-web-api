<?php

namespace App\Infrastructures\HumanResources\MasterData\WorkArea\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentWorkAreaRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param string $country
     * @return mixed
     */
    public function findWhereByCountry(string $country);

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
