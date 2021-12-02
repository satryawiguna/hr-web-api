<?php

namespace App\Infrastructures\Commons\Office\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentOfficeRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param string $type
     * @return mixed
     */
    public function findWhereByType(string $type);

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
