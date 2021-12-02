<?php
namespace App\Infrastructures\HumanResources\Payroll\PayrollBalance;

use App\Infrastructures\HumanResources\Payroll\PayrollBalance\Contracts\EloquentPayrollBalanceRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentPayrollBalanceRepository Class.
 */
class EloquentPayrollBalanceRepository extends EloquentRepositoryAbstract implements EloquentPayrollBalanceRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $this->model = $this->model->where('name', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('slug', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'LIKE', '%' . $searchQuery . '%');

        return $this;
    }

    //</editor-fold>
}
