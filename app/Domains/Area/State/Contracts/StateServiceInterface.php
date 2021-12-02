<?php

namespace App\Domains\Area\State\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface StateServiceInterface.
 */
interface StateServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * StateServiceInterface constructor.
     *
     * @param StateRepositoryInterface $repository
     */
    public function __construct(StateRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create State.
     *
     * @param StateInterface $State
     *
     * @return mixed
     */
    public function create(StateInterface $State): ObjectResponse;

    /**
     * Update State.
     *
     * @param StateInterface $State
     *
     * @return mixed
     */
    public function update(StateInterface $State): BasicResponse;

    /**
     * Delete State.
     *
     * @param StateInterface $State
     *
     * @return mixed
     */
    public function delete(StateInterface $State): BasicResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $countryId
     * @return GenericCollectionResponse
     */
    public function stateList(int $countryId = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $countryId
     * @return GenericListSearchResponse
     */
    public function stateListSearch(ListSearchRequest $request, int $countryId = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $countryId
     * @return GenericPageSearchResponse
     */
    public function statePageSearch(PageSearchRequest $request, int $countryId = null): GenericPageSearchResponse;

    //</editor-fold>
}
