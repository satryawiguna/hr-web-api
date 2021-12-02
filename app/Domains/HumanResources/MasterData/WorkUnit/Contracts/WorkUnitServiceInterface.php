<?php

namespace App\Domains\HumanResources\MasterData\WorkUnit\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface WorkUnitServiceInterface.
 */
interface WorkUnitServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkUnitServiceInterface constructor.
     *
     * @param WorkUnitRepositoryInterface $repository
     */
    public function __construct(WorkUnitRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkUnit.
     *
     * @param WorkUnitInterface $WorkUnit
     *
     * @return mixed
     */
    public function create(WorkUnitInterface $WorkUnit);

    /**
     * Update WorkUnit.
     *
     * @param WorkUnitInterface $WorkUnit
     *
     * @return mixed
     */
    public function update(WorkUnitInterface $WorkUnit);

    /**
     * Delete WorkUnit.
     *
     * @param WorkUnitInterface $WorkUnit
     *
     * @return mixed
     */
    public function delete(WorkUnitInterface $WorkUnit);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param $id
     * @return mixed
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function workUnitList(int $parentId = null, int $companyId = null, string $country = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function workUnitListHierarchical(int $companyId = null, string $country = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function workUnitListSearch(ListSearchRequest $request, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function workUnitPageSearch(PageSearchRequest $request, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param WorkUnitInterface $WorkUnit
     * @return mixed
     */
    public function workUnitSetActive(WorkUnitInterface $WorkUnit): BasicResponse;

    /**
     * @param WorkUnitInterface $WorkUnit
     * @return ObjectResponse
     */
    public function workUnitSlug(WorkUnitInterface $WorkUnit): ObjectResponse;

    //</editor-fold>
}
