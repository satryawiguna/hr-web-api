<?php

namespace App\Domains\HumanResources\Element\ElementEntryValue\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Element\ElementEntryValue\Contracts\EloquentElementEntryValueRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;

/**
 * Interface ElementEntryValueRepositoryInterface.
 */
interface ElementEntryValueRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementEntryValueRepositoryInterface constructor.
     *
     * @param EloquentElementEntryValueRepositoryInterface $eloquent
     */
    public function __construct(EloquentElementEntryValueRepositoryInterface $eloquent);

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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return mixed
     */
    public function elementEntryValueList(int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function elementEntryValueListSearch(ListedSearchParameter $parameter, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function elementEntryValuePageSearch(PagedSearchParameter $parameter, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null, bool $count = false);

    //</editor-fold>
}
