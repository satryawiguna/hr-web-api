<?php

namespace App\Infrastructures\HumanResources\Payroll\PayrollBatch\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentPayrollBatchRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
