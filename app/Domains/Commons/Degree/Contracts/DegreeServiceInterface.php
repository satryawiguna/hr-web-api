<?php

namespace App\Domains\Commons\Degree\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface DegreeServiceInterface.
 */
interface DegreeServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * DegreeServiceInterface constructor.
     *
     * @param DegreeRepositoryInterface $repository
     */
    public function __construct(DegreeRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Degree.
     *
     * @param DegreeInterface $Degree
     *
     * @return mixed
     */
    public function create(DegreeInterface $Degree): ObjectResponse;

    /**
     * Update Degree.
     *
     * @param DegreeInterface $Degree
     *
     * @return mixed
     */
    public function update(DegreeInterface $Degree): BasicResponse;

    /**
     * Delete Degree.
     *
     * @param DegreeInterface $Degree
     *
     * @return mixed
     */
    public function delete(DegreeInterface $Degree): BasicResponse;

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
     * @param null $isActive
     * @return GenericCollectionResponse
     */
    public function degreeList($isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param null $isActive
     * @return mixed
     */
    public function degreeListSearch(ListSearchRequest $request, $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param null $isActive
     * @return mixed
     */
    public function degreePageSearch(PageSearchRequest $request, $isActive = null): GenericPageSearchResponse;

    /**
     * @param DegreeInterface $Degree
     * @return mixed
     */
    public function degreeSetActive(DegreeInterface $Degree): BasicResponse;

    /**
     * @param DegreeInterface $Degree
     * @return ObjectResponse
     */
    public function degreeSlug(DegreeInterface $Degree): ObjectResponse;

    //</editor-fold>
}
