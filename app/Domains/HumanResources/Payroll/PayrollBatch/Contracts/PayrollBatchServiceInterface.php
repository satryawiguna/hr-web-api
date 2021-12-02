<?php

namespace App\Domains\HumanResources\Payroll\PayrollBatch\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface PayrollBatchServiceInterface.
 */
interface PayrollBatchServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollBatchServiceInterface constructor.
     *
     * @param PayrollBatchRepositoryInterface $repository
     */
    public function __construct(PayrollBatchRepositoryInterface $repository);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @return GenericCollectionResponse
     */
    public function payrollBatchList(): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @return mixed
     */
    public function payrollBatchListSearch(ListSearchRequest $request): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @return GenericPageSearchResponse
     */
    public function payrollBatchPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    /**
     * @param PayrollBatchInterface $PayrollBatch
     * @return ObjectResponse
     */
    public function payrollBatchSlug(PayrollBatchInterface $PayrollBatch): ObjectResponse;

    //</editor-fold>
}
