<?php

namespace App\Domains\HumanResources\MasterData\Position\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface PositionServiceInterface.
 */
interface PositionServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PositionServiceInterface constructor.
     *
     * @param PositionRepositoryInterface $repository
     */
    public function __construct(PositionRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Position.
     *
     * @param PositionInterface $Position
     *
     * @return mixed
     */
    public function create(PositionInterface $Position);

    /**
     * Update Position.
     *
     * @param PositionInterface $Position
     *
     * @return mixed
     */
    public function update(PositionInterface $Position);

    /**
     * Delete Position.
     *
     * @param PositionInterface $Position
     *
     * @return mixed
     */
    public function delete(PositionInterface $Position);

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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function positionList(int $parentId = null, int $companyId = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function positionListHierarchical(int $companyId = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function positionListSearch(ListSearchRequest $request, int $parentId = null, int $companyId = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function positionPageSearch(PageSearchRequest $request, int $parentId = null, int $companyId = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param PositionInterface $Position
     * @return mixed
     */
    public function positionSetActive(PositionInterface $Position): BasicResponse;

    /**
     * @param PositionInterface $Position
     * @return ObjectResponse
     */
    public function positionSlug(PositionInterface $Position): ObjectResponse;

    //</editor-fold>
}
