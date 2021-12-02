<?php

namespace App\Domains\Area\State\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Area\State\Contracts\EloquentStateRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface StateRepositoryInterface.
 */
interface StateRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * StateRepositoryInterface constructor.
     *
     * @param EloquentStateRepositoryInterface $eloquent
     */
    public function __construct(EloquentStateRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create State.
     *
     * @param StateInterface $State
     *
     * @return mixed
     */
    public function create(StateInterface $State);

    /**
     * Update State.
     *
     * @param StateInterface $State
     *
     * @return mixed
     */
    public function update(StateInterface $State);

    /**
     * Delete State.
     *
     * @param StateInterface $State
     *
     * @return mixed
     */
    public function delete(StateInterface $State);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $countryId
     * @return mixed
     */
    public function stateList(int $countryId = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $countryId
     * @param bool $count
     * @return mixed
     */
    public function stateListSearch(ListedSearchParameter $parameter, int $countryId = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $countryId
     * @param bool $count
     * @return mixed
     */
    public function statePageSearch(PagedSearchParameter $parameter, int $countryId = null, bool $count = false);

    //</editor-fold>
}
