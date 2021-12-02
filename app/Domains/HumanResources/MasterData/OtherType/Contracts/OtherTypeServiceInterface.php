<?php

namespace App\Domains\HumanResources\MasterData\OtherType\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface OtherTypeServiceInterface.
 */
interface OtherTypeServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OtherTypeServiceInterface constructor.
     *
     * @param OtherTypeRepositoryInterface $repository
     */
    public function __construct(OtherTypeRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create OtherType.
     *
     * @param OtherTypeInterface $OtherType
     *
     * @return mixed
     */
    public function create(OtherTypeInterface $OtherType);

    /**
     * Update OtherType.
     *
     * @param OtherTypeInterface $OtherType
     *
     * @return mixed
     */
    public function update(OtherTypeInterface $OtherType);

    /**
     * Delete OtherType.
     *
     * @param OtherTypeInterface $OtherType
     *
     * @return mixed
     */
    public function delete(OtherTypeInterface $OtherType);

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
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function otherTypeList(int $companyId = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function otherTypeListSearch(ListSearchRequest $request, int $companyId = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function otherTypePageSearch(PageSearchRequest $request, int $companyId = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param OtherTypeInterface $OtherType
     * @return mixed
     */
    public function otherTypeSetActive(OtherTypeInterface $OtherType): BasicResponse;

    /**
     * @param OtherTypeInterface $OtherType
     * @return ObjectResponse
     */
    public function otherTypeSlug(OtherTypeInterface $OtherType): ObjectResponse;

    //</editor-fold>
}
