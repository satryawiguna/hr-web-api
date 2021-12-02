<?php

namespace App\Infrastructures\HumanResources\Payroll\PayrollProcessType\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentPayrollProcessTypeRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
