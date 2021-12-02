<?php

namespace App\Domains\HumanResources\Element\ElementValue\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface ElementValueServiceInterface.
 */
interface ElementValueServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementValueServiceInterface constructor.
     *
     * @param ElementValueRepositoryInterface $repository
     */
    public function __construct(ElementValueRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create ElementValue.
     *
     * @param ElementValueInterface $ElementValue
     *
     * @return mixed
     */
    public function create(ElementValueInterface $ElementValue);

    /**
     * Update ElementValue.
     *
     * @param ElementValueInterface $ElementValue
     *
     * @return mixed
     */
    public function update(ElementValueInterface $ElementValue);

    /**
     * Delete ElementValue.
     *
     * @param ElementValueInterface $ElementValue
     *
     * @return mixed
     */
    public function delete(ElementValueInterface $ElementValue);

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @return GenericCollectionResponse
     */
    public function elementValueList(int $elementId = null, object $rangeValue = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @return GenericListSearchResponse
     */
    public function elementValueListSearch(ListSearchRequest $request, int $elementId = null, object $rangeValue = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @return GenericPageSearchResponse
     */
    public function elementValuePageSearch(PageSearchRequest $request, int $elementId = null, object $rangeValue = null): GenericPageSearchResponse;

    /**
     * @param ElementValueInterface $ElementValue
     * @return ObjectResponse
     */
    public function elementValueSlug(ElementValueInterface $ElementValue): ObjectResponse;

    //</editor-fold>
}
