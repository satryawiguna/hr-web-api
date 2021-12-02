<?php

namespace App\Infrastructures\HumanResources\Payroll\PayrollBalanceFeed\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentPayrollBalanceFeedRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $payrollBalanceId
     * @return mixed
     */
    public function findWhereByPayrollBalanceId(int $payrollBalanceId);

    /**
     * @param int $elementId
     * @return mixed
     */
    public function findWhereByElementId(int $elementId);

    /**
     * @param int $elementValueId
     * @return mixed
     */
    public function findWhereByElementValueId(int $elementValueId);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
