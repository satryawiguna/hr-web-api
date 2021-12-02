<?php

namespace App\Domains\Commons\Office\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface OfficeServiceInterface.
 */
interface OfficeServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OfficeServiceInterface constructor.
     *
     * @param OfficeRepositoryInterface $repository
     */
    public function __construct(OfficeRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Office.
     *
     * @param OfficeInterface $Office
     *
     * @return mixed
     */
    public function create(OfficeInterface $Office): ObjectResponse;

    /**
     * Update Office.
     *
     * @param OfficeInterface $Office
     *
     * @return mixed
     */
    public function update(OfficeInterface $Office): ObjectResponse;

    /**
     * Delete Office.
     *
     * @param OfficeInterface $Office
     *
     * @return mixed
     */
    public function delete(OfficeInterface $Office): BasicResponse;

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
     * @param int|null $companyId
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function officeList(int $companyId = null, string $type = null, string $country = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function officeListSearch(ListSearchRequest $request, int $companyId = null, string $type = null, string $country = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function officePageSearch(PageSearchRequest $request, int $companyId = null, string $type = null, string $country = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param OfficeInterface $Office
     * @return BasicResponse
     */
    public function officeSetActive(OfficeInterface $Office): BasicResponse;

    /**
     * @param OfficeInterface $Office
     * @return ObjectResponse
     */
    public function officeSlug(OfficeInterface $Office): ObjectResponse;

    //</editor-fold>
}
