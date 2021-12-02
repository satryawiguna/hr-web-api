<?php

namespace App\Domains\HumanResources\Element\ElementEntry\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use DateTime;

/**
 * Interface ElementEntryServiceInterface.
 */
interface ElementEntryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementEntryServiceInterface constructor.
     *
     * @param ElementEntryRepositoryInterface $repository
     */
    public function __construct(ElementEntryRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create ElementEntry.
     *
     * @param ElementEntryInterface $ElementEntry
     *
     * @return mixed
     */
    public function create(ElementEntryInterface $ElementEntry);

    /**
     * Update ElementEntry.
     *
     * @param ElementEntryInterface $ElementEntry
     *
     * @return mixed
     */
    public function update(ElementEntryInterface $ElementEntry);

    /**
     * Delete ElementEntry.
     *
     * @param ElementEntryInterface $ElementEntry
     *
     * @return mixed
     */
    public function delete(ElementEntryInterface $ElementEntry);

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
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function elementEntryList(int $elementId = null, int $employeeId = null, DateTime $date = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function elementEntryListSearch(ListSearchRequest $request, int $elementId = null, int $employeeId = null, DateTime $date = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function elementEntryPageSearch(PageSearchRequest $request, int $elementId = null, int $employeeId = null, DateTime $date = null): GenericPageSearchResponse;

    //</editor-fold>
}
