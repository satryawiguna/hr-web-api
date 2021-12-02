<?php

namespace App\Domains\Commons\Major\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface MajorServiceInterface.
 */
interface MajorServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * MajorServiceInterface constructor.
     *
     * @param MajorRepositoryInterface $repository
     */
    public function __construct(MajorRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Major.
     *
     * @param MajorInterface $Major
     *
     * @return mixed
     */
    public function create(MajorInterface $Major): ObjectResponse;

    /**
     * Update Major.
     *
     * @param MajorInterface $Major
     *
     * @return mixed
     */
    public function update(MajorInterface $Major): BasicResponse;

    /**
     * Delete Major.
     *
     * @param MajorInterface $Major
     *
     * @return mixed
     */
    public function delete(MajorInterface $Major): BasicResponse;

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
    public function majorList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function majorListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function majorPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param MajorInterface $Major
     * @return mixed
     */
    public function majorSetActive(MajorInterface $Major): BasicResponse;

    /**
     * @param MajorInterface $Major
     * @return ObjectResponse
     */
    public function majorSlug(MajorInterface $Major): ObjectResponse;

    //</editor-fold>
}
