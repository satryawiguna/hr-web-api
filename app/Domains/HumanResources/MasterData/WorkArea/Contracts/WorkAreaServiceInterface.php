<?php

namespace App\Domains\HumanResources\MasterData\WorkArea\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface WorkAreaServiceInterface.
 */
interface WorkAreaServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkAreaServiceInterface constructor.
     *
     * @param WorkAreaRepositoryInterface $repository
     */
    public function __construct(WorkAreaRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkArea.
     *
     * @param WorkAreaInterface $WorkArea
     *
     * @return mixed
     */
    public function create(WorkAreaInterface $WorkArea);

    /**
     * Update WorkArea.
     *
     * @param WorkAreaInterface $WorkArea
     *
     * @return mixed
     */
    public function update(WorkAreaInterface $WorkArea);

    /**
     * Delete WorkArea.
     *
     * @param WorkAreaInterface $WorkArea
     *
     * @return mixed
     */
    public function delete(WorkAreaInterface $WorkArea);

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
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function workAreaList(int $companyId = null, string $country = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function workAreaListSearch(ListSearchRequest $request, int $companyId = null, string $country = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function workAreaPageSearch(PageSearchRequest $request, int $companyId = null, string $country = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param WorkAreaInterface $WorkArea
     * @return mixed
     */
    public function workAreaSetActive(WorkAreaInterface $WorkArea): BasicResponse;

    /**
     * @param WorkAreaInterface $WorkArea
     * @return ObjectResponse
     */
    public function workAreaSlug(WorkAreaInterface $WorkArea): ObjectResponse;

    //</editor-fold>
}
