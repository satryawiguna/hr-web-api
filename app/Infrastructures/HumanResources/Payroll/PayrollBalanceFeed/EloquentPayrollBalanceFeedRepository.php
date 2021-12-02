<?php
namespace App\Infrastructures\HumanResources\Payroll\PayrollBalanceFeed;

use App\Infrastructures\HumanResources\Payroll\PayrollBalanceFeed\Contracts\EloquentPayrollBalanceFeedRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentPayrollBalanceFeedRepository Class.
 */
class EloquentPayrollBalanceFeedRepository extends EloquentRepositoryAbstract implements EloquentPayrollBalanceFeedRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $payrollBalanceId
     * @return $this|mixed
     */
    public function findWhereByPayrollBalanceId(int $payrollBalanceId)
    {
        $this->model = $this->model->where('payroll_balance_id', $payrollBalanceId);

        return $this;
    }

    /**
     * @param int $elementId
     * @return $this|mixed
     */
    public function findWhereByElementId(int $elementId)
    {
        $this->model = $this->model->where('element_id', $elementId);

        return $this;
    }

    /**
     * @param int $elementValueId
     * @return $this|mixed
     */
    public function findWhereByElementValueId(int $elementValueId)
    {
        $this->model = $this->model->where('element_value_id', $elementValueId);

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        return $this;
    }

    //</editor-fold>
}
