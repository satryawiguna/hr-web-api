<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentOtherEquipmentRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findWhereByCompanyId(int $companyId);

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findWhereByEmployeeId(int $employeeId);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
