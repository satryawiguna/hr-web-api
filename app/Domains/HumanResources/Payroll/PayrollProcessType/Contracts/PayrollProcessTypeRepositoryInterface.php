<?php

namespace App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Payroll\PayrollProcessType\Contracts\EloquentPayrollProcessTypeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface PayrollProcessTypeRepositoryInterface.
 */
interface PayrollProcessTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollProcessTypeRepositoryInterface constructor.
     *
     * @param EloquentPayrollProcessTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollProcessTypeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create PayrollProcessType.
     *
     * @param PayrollProcessTypeInterface $PayrollProcessType
     *
     * @return mixed
     */
    public function create(PayrollProcessTypeInterface $PayrollProcessType);

    /**
     * Update PayrollProcessType.
     *
     * @param PayrollProcessTypeInterface $PayrollProcessType
     *
     * @return mixed
     */
    public function update(PayrollProcessTypeInterface $PayrollProcessType);

    /**
     * Delete PayrollProcessType.
     *
     * @param PayrollProcessTypeInterface $PayrollProcessType
     *
     * @return mixed
     */
    public function delete(PayrollProcessTypeInterface $PayrollProcessType);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @return mixed
     */
    public function payrollProcessTypeList();

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollProcessTypeListSearch(ListedSearchParameter $parameter, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollProcessTypePageSearch(PagedSearchParameter $parameter, bool $count = false);

    //</editor-fold>
}
