<?php

namespace App\Infrastructures\HumanResources\Payroll\PayrollBalance\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentPayrollBalanceRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
