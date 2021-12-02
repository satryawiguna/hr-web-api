<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalance\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface PayrollBalanceServiceInterface.
 */
interface PayrollBalanceServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBalanceServiceInterface constructor.
     *
     * @param PayrollBalanceRepositoryInterface $repository
     */
    public function __construct(PayrollBalanceRepositoryInterface $repository);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @return GenericCollectionResponse
     */
    public function payrollBalanceList(): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @return mixed
     */
    public function payrollBalanceListSearch(ListSearchRequest $request): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @return mixed
     */
    public function payrollBalancePageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    /**
     * @param PayrollBalanceInterface $PayrollBalance
     * @return ObjectResponse
     */
    public function payrollBalanceSlug(PayrollBalanceInterface $PayrollBalance): ObjectResponse;

    //</editor-fold>
}
