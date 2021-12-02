<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalance\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Payroll\PayrollBalance\Contracts\EloquentPayrollBalanceRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface PayrollBalanceRepositoryInterface.
 */
interface PayrollBalanceRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBalanceRepositoryInterface constructor.
     *
     * @param EloquentPayrollBalanceRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollBalanceRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create PayrollBalance.
     *
     * @param PayrollBalanceInterface $PayrollBalance
     *
     * @return mixed
     */
    public function create(PayrollBalanceInterface $PayrollBalance);

    /**
     * Update PayrollBalance.
     *
     * @param PayrollBalanceInterface $PayrollBalance
     *
     * @return mixed
     */
    public function update(PayrollBalanceInterface $PayrollBalance);

    /**
     * Delete PayrollBalance.
     *
     * @param PayrollBalanceInterface $PayrollBalance
     *
     * @return mixed
     */
    public function delete(PayrollBalanceInterface $PayrollBalance);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @return mixed
     */
    public function payrollBalanceList();

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollBalanceListSearch(ListedSearchParameter $parameter, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollBalancePageSearch(PagedSearchParameter $parameter, bool $count = false);

    //</editor-fold>
}
