<?php

namespace App\Domains\Area\City\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Area\City\Contracts\EloquentCityRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface CityRepositoryInterface.
 */
interface CityRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CityRepositoryInterface constructor.
     *
     * @param EloquentCityRepositoryInterface $eloquent
     */
    public function __construct(EloquentCityRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create City.
     *
     * @param CityInterface $City
     *
     * @return mixed
     */
    public function create(CityInterface $City);

    /**
     * Update City.
     *
     * @param CityInterface $City
     *
     * @return mixed
     */
    public function update(CityInterface $City);

    /**
     * Delete City.
     *
     * @param CityInterface $City
     *
     * @return mixed
     */
    public function delete(CityInterface $City);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $stateId
     * @return mixed
     */
    public function cityList(int $stateId = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $stateId
     * @param bool $count
     * @return mixed
     */
    public function cityListSearch(ListedSearchParameter $parameter, int $stateId = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $stateId
     * @param bool $count
     * @return mixed
     */
    public function cityPageSearch(PagedSearchParameter $parameter, int $stateId = null, bool $count = false);

    //</editor-fold>
}
