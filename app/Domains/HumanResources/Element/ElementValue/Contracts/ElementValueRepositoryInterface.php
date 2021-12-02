<?php

namespace App\Domains\HumanResources\Element\ElementValue\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Element\ElementValue\Contracts\EloquentElementValueRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface ElementValueRepositoryInterface.
 */
interface ElementValueRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementValueRepositoryInterface constructor.
     *
     * @param EloquentElementValueRepositoryInterface $eloquent
     */
    public function __construct(EloquentElementValueRepositoryInterface $eloquent);

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
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @return mixed
     */
    public function elementValueList(int $elementId = null, object $rangeValue = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $elementId
     * @param $
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function elementValueListSearch(ListedSearchParameter $parameter, int $elementId = null, object $rangeValue = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function elementValuePageSearch(PagedSearchParameter $parameter, int $elementId = null, object $rangeValue = null, bool $count = false);

    //</editor-fold>
}
