<?php

namespace App\Domains\Commons\Religion\Contracts;


use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface ReligionServiceInterface.
 */
interface ReligionServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ReligionServiceInterface constructor.
     *
     * @param ReligionRepositoryInterface $repository
     */
    public function __construct(ReligionRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Religion.
     *
     * @param ReligionInterface $Religion
     *
     * @return mixed
     */
    public function create(ReligionInterface $Religion): ObjectResponse;

    /**
     * Update Religion.
     *
     * @param ReligionInterface $Religion
     *
     * @return mixed
     */
    public function update(ReligionInterface $Religion): BasicResponse;

    /**
     * Delete Religion.
     *
     * @param ReligionInterface $Religion
     *
     * @return mixed
     */
    public function delete(ReligionInterface $Religion): BasicResponse;

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
    public function religionList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function religionListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function religionPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param ReligionInterface $Religion
     * @return mixed
     */
    public function religionSetActive(ReligionInterface $Religion): BasicResponse;

    /**
     * @param ReligionInterface $Religion
     * @return ObjectResponse
     */
    public function religionSlug(ReligionInterface $Religion): ObjectResponse;

    //</editor-fold>
}
