<?php

namespace App\Domains\HumanResources\Element\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Element\Contracts\EloquentElementRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface ElementRepositoryInterface.
 */
interface ElementRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ElementRepositoryInterface constructor.
     *
     * @param EloquentElementRepositoryInterface $eloquent
     */
    public function __construct(EloquentElementRepositoryInterface $eloquent);

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
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $formulaId
     * @return mixed
     */
    public function elementList(int $formulaId = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $formulaId
     * @param bool $count
     * @return mixed
     */
    public function elementListSearch(ListedSearchParameter $parameter, int $formulaId = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $formulaId
     * @param bool $count
     * @return mixed
     */
    public function elementPageSearch(PagedSearchParameter $parameter, int $formulaId = null, bool $count = false);

    //</editor-fold>
}
