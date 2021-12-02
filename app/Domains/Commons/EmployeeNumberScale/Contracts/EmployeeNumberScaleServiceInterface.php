<?php

namespace App\Domains\Commons\EmployeeNumberScale\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface EmployeeNumberScaleServiceInterface.
 */
interface EmployeeNumberScaleServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * EmployeeNumberScaleServiceInterface constructor.
     *
     * @param EmployeeNumberScaleRepositoryInterface $repository
     */
    public function __construct(EmployeeNumberScaleRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create EmployeeNumberScale.
     *
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     *
     * @return mixed
     */
    public function create(EmployeeNumberScaleInterface $EmployeeNumberScale): ObjectResponse;

    /**
     * Update EmployeeNumberScale.
     *
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     *
     * @return mixed
     */
    public function update(EmployeeNumberScaleInterface $EmployeeNumberScale): BasicResponse;

    /**
     * Delete EmployeeNumberScale.
     *
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     *
     * @return mixed
     */
    public function delete(EmployeeNumberScaleInterface $EmployeeNumberScale): BasicResponse;

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function employeeNumberScaleList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function employeeNumberScaleListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function employeeNumberScalePageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     * @return mixed
     */
    public function employeeNumberScaleSetActive(EmployeeNumberScaleInterface $EmployeeNumberScale): BasicResponse;

    /**
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     * @return ObjectResponse
     */
    public function employeeNumberScaleSlug(EmployeeNumberScaleInterface $EmployeeNumberScale): ObjectResponse;

    //</editor-fold>
}
