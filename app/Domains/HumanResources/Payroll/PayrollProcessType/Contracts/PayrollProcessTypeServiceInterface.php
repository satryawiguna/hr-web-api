<?php

namespace App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface PayrollProcessTypeServiceInterface.
 */
interface PayrollProcessTypeServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PayrollProcessTypeServiceInterface constructor.
     *
     * @param PayrollProcessTypeRepositoryInterface $repository
     */
    public function __construct(PayrollProcessTypeRepositoryInterface $repository);

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
     * @return GenericCollectionResponse
     */
    public function payrollProcessTypeList(): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @return mixed
     */
    public function payrollProcessTypeListSearch(ListSearchRequest $request): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @return mixed
     */
    public function payrollProcessTypePageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    /**
     * @param PayrollProcessTypeInterface $PayrollProcessType
     * @return ObjectResponse
     */
    public function payrollProcessTypeSlug(PayrollProcessTypeInterface $PayrollProcessType): ObjectResponse;

    //</editor-fold>
}
