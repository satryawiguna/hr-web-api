<?php

namespace App\Domains\Area\City\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface CityServiceInterface.
 */
interface CityServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CityServiceInterface constructor.
     *
     * @param CityRepositoryInterface $repository
     */
    public function __construct(CityRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create City.
     *
     * @param CityInterface $City
     *
     * @return mixed
     */
    public function create(CityInterface $City): ObjectResponse;

    /**
     * Update City.
     *
     * @param CityInterface $City
     *
     * @return mixed
     */
    public function update(CityInterface $City): BasicResponse;

    /**
     * Delete City.
     *
     * @param CityInterface $City
     *
     * @return mixed
     */
    public function delete(CityInterface $City): BasicResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $stateId
     * @return GenericCollectionResponse
     */
    public function cityList(int $stateId = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $stateId
     * @return GenericListSearchResponse
     */
    public function cityListSearch(ListSearchRequest $request, int $stateId = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $stateId
     * @return GenericPageSearchResponse
     */
    public function cityPageSearch(PageSearchRequest $request, int $stateId = null): GenericPageSearchResponse;

    //</editor-fold>
}
