<?php
namespace App\Infrastructures\HumanResources\Payroll\PayrollProcessType;

use App\Infrastructures\HumanResources\Payroll\PayrollProcessType\Contracts\EloquentPayrollProcessTypeRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentPayrollProcessTypeRepository Class.
 */
class EloquentPayrollProcessTypeRepository extends EloquentRepositoryAbstract implements EloquentPayrollProcessTypeRepositoryInterface
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
