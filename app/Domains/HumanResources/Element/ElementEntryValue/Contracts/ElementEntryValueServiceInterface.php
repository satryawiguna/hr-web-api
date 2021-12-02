<?php

namespace App\Domains\HumanResources\Element\ElementEntryValue\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use DateTime;

/**
 * Interface ElementEntryValueServiceInterface.
 */
interface ElementEntryValueServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementEntryValueServiceInterface constructor.
     *
     * @param ElementEntryValueRepositoryInterface $repository
     */
    public function __construct(ElementEntryValueRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create ElementEntryValue.
     *
     * @param ElementEntryValueInterface $ElementEntryValue
     *
     * @return mixed
     */
    public function create(ElementEntryValueInterface $ElementEntryValue);

    /**
     * Update ElementEntryValue.
     *
     * @param ElementEntryValueInterface $ElementEntryValue
     *
     * @return mixed
     */
    public function update(ElementEntryValueInterface $ElementEntryValue);

    /**
     * Delete ElementEntryValue.
     *
     * @param ElementEntryValueInterface $ElementEntryValue
     *
     * @return mixed
     */
    public function delete(ElementEntryValueInterface $ElementEntryValue);


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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericCollectionResponse
     */
    public function elementEntryValueList(int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericListSearchResponse
     */
    public function elementEntryValueListSearch(ListSearchRequest $request, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericPageSearchResponse
     */
    public function elementEntryValuePageSearch(PageSearchRequest $request, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null): GenericPageSearchResponse;

    //</editor-fold>
}
