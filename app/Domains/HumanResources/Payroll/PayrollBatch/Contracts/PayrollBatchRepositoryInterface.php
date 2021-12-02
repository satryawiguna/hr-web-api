<?php

namespace App\Domains\HumanResources\Payroll\PayrollBatch\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Payroll\PayrollBatch\Contracts\EloquentPayrollBatchRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface PayrollBatchRepositoryInterface.
 */
interface PayrollBatchRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBatchRepositoryInterface constructor.
     *
     * @param EloquentPayrollBatchRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollBatchRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create PayrollBatch.
     *
     * @param PayrollBatchInterface $PayrollBatch
     *
     * @return mixed
     */
    public function create(PayrollBatchInterface $PayrollBatch);

    /**
     * Update PayrollBatch.
     *
     * @param PayrollBatchInterface $PayrollBatch
     *
     * @return mixed
     */
    public function update(PayrollBatchInterface $PayrollBatch);

    /**
     * Delete PayrollBatch.
     *
     * @param PayrollBatchInterface $PayrollBatch
     *
     * @return mixed
     */
    public function delete(PayrollBatchInterface $PayrollBatch);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @return mixed
     */
    public function payrollBatchList();

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollBatchListSearch(ListedSearchParameter $parameter, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function payrollBatchPageSearch(PagedSearchParameter $parameter, bool $count = false);

    //</editor-fold>
}
