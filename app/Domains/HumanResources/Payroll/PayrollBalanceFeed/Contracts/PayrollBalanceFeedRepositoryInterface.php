<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Payroll\PayrollBalanceFeed\Contracts\EloquentPayrollBalanceFeedRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface PayrollBalanceFeedRepositoryInterface.
 */
interface PayrollBalanceFeedRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBalanceFeedRepositoryInterface constructor.
     *
     * @param EloquentPayrollBalanceFeedRepositoryInterface $eloquent
     */
    public function __construct(EloquentPayrollBalanceFeedRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create PayrollBalanceFeed.
     *
     * @param PayrollBalanceFeedInterface $PayrollBalanceFeed
     *
     * @return mixed
     */
    public function create(PayrollBalanceFeedInterface $PayrollBalanceFeed);

    /**
     * Update PayrollBalanceFeed.
     *
     * @param PayrollBalanceFeedInterface $PayrollBalanceFeed
     *
     * @return mixed
     */
    public function update(PayrollBalanceFeedInterface $PayrollBalanceFeed);

    /**
     * Delete PayrollBalanceFeed.
     *
     * @param PayrollBalanceFeedInterface $PayrollBalanceFeed
     *
     * @return mixed
     */
    public function delete(PayrollBalanceFeedInterface $PayrollBalanceFeed);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @return mixed
     */
    public function payrollBalanceFeedList(int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @param bool $count
     * @return mixed
     */
    public function payrollBalanceFeedListSearch(ListedSearchParameter $parameter, int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @param bool $count
     * @return mixed
     */
    public function payrollBalanceFeedPageSearch(PagedSearchParameter $parameter, int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null, bool $count = false);

    //</editor-fold>
}
