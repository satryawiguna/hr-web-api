<?php

namespace App\Domains\Commons\VacancyLocation\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface VacancyLocationServiceInterface.
 */
interface VacancyLocationServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyLocationServiceInterface constructor.
     *
     * @param VacancyLocationRepositoryInterface $repository
     */
    public function __construct(VacancyLocationRepositoryInterface $repository);

    //</editor-fold>

    //<editor-fold desc="#public (method)">

    /**
     * Create VacancyLocation.
     *
     * @param VacancyLocationInterface $VacancyLocation
     *
     * @return mixed
     */
    public function create(VacancyLocationInterface $VacancyLocation): ObjectResponse;

    /**
     * Update VacancyLocation.
     *
     * @param VacancyLocationInterface $VacancyLocation
     *
     * @return mixed
     */
    public function update(VacancyLocationInterface $VacancyLocation): BasicResponse;

    /**
     * Delete VacancyLocation.
     *
     * @param VacancyLocationInterface $VacancyLocation
     *
     * @return mixed
     */
    public function delete(VacancyLocationInterface $VacancyLocation): BasicResponse;

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
     * @return GenericCollectionResponse
     */
    public function vacancyLocationList(int $parentId = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @return GenericListSearchResponse
     */
    public function vacancyLocationListSearch(ListSearchRequest $request, int $parentId = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @return GenericPageSearchResponse
     */
    public function vacancyLocationPageSearch(PageSearchRequest $request, int $parentId = null): GenericPageSearchResponse;

    /**
     * @param VacancyLocationInterface $VacancyLocation
     * @return ObjectResponse
     */
    public function vacancyLocationSlug(VacancyLocationInterface $VacancyLocation): ObjectResponse;

    //</editor-fold>
}