<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface PayrollBalanceFeedServiceInterface.
 */
interface PayrollBalanceFeedServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBalanceFeedServiceInterface constructor.
     *
     * @param PayrollBalanceFeedRepositoryInterface $repository
     */
    public function __construct(PayrollBalanceFeedRepositoryInterface $repository);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @return GenericCollectionResponse
     */
    public function payrollBalanceFeedList(int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @return GenericListSearchResponse
     */
    public function payrollBalanceFeedListSearch(ListSearchRequest $request, int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @return GenericPageSearchResponse
     */
    public function payrollBalanceFeedPageSearch(PageSearchRequest $request, int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null): GenericPageSearchResponse;

    //</editor-fold>
}
