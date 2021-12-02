<?php

namespace App\Domains\HumanResources\Element\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface ElementServiceInterface.
 */
interface ElementServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementServiceInterface constructor.
     *
     * @param ElementRepositoryInterface $repository
     */
    public function __construct(ElementRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Element.
     *
     * @param ElementInterface $Element
     *
     * @return mixed
     */
    public function create(ElementInterface $Element);

    /**
     * Update Element.
     *
     * @param ElementInterface $Element
     *
     * @return mixed
     */
    public function update(ElementInterface $Element);

    /**
     * Delete Element.
     *
     * @param ElementInterface $Element
     *
     * @return mixed
     */
    public function delete(ElementInterface $Element);

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
     * @param int|null $formulaId
     * @return GenericCollectionResponse
     */
    public function elementList(int $formulaId = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $formulaId
     * @return GenericListSearchResponse
     */
    public function elementListSearch(ListSearchRequest $request, int $formulaId = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $formulaId
     * @return GenericPageSearchResponse
     */
    public function elementPageSearch(PageSearchRequest $request, int $formulaId = null): GenericPageSearchResponse;

    /**
     * @param ElementInterface $Element
     * @return ObjectResponse
     */
    public function elementSlug(ElementInterface $Element): ObjectResponse;

    //</editor-fold>
}
