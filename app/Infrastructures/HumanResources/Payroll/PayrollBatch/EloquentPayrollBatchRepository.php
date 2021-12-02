<?php
namespace App\Infrastructures\HumanResources\Payroll\PayrollBatch;

use App\Infrastructures\HumanResources\Payroll\PayrollBatch\Contracts\EloquentPayrollBatchRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentPayrollBatchRepository Class.
 */
class EloquentPayrollBatchRepository extends EloquentRepositoryAbstract implements EloquentPayrollBatchRepositoryInterface
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
