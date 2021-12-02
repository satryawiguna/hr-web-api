<?php

namespace App\Domains\HumanResources\Element\ElementEntry\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Element\ElementEntry\Contracts\EloquentElementEntryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;

/**
 * Interface ElementEntryRepositoryInterface.
 */
interface ElementEntryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementEntryRepositoryInterface constructor.
     *
     * @param EloquentElementEntryRepositoryInterface $eloquent
     */
    public function __construct(EloquentElementEntryRepositoryInterface $eloquent);

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
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return mixed
     */
    public function elementEntryList(int $elementId = null, int $employeeId = null, DateTime $date = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function elementEntryListSearch(ListedSearchParameter $parameter, int $elementId = null, int $employeeId = null, DateTime $date = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $elementId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function elementEntryPageSearch(PagedSearchParameter $parameter, int $elementId = null, int $employeeId = null, DateTime $date = null, bool $count = false);

    //</editor-fold>
}
