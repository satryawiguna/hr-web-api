<?php

namespace App\Domains\Commons\VacancyLocation\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\VacancyLocation\Contracts\EloquentVacancyLocationRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface VacancyLocationRepositoryInterface.
 */
interface VacancyLocationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyLocationRepositoryInterface constructor.
     *
     * @param EloquentVacancyLocationRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyLocationRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create VacancyLocation.
     *
     * @param VacancyLocationInterface $VacancyLocation
     *
     * @return mixed
     */
    public function create(VacancyLocationInterface $VacancyLocation);

    /**
     * Update VacancyLocation.
     *
     * @param VacancyLocationInterface $VacancyLocation
     *
     * @return mixed
     */
    public function update(VacancyLocationInterface $VacancyLocation);

    /**
     * Delete VacancyLocation.
     *
     * @param VacancyLocationInterface $VacancyLocation
     *
     * @return mixed
     */
    public function delete(VacancyLocationInterface $VacancyLocation);

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
     * @return mixed
     */
    public function vacancyLocationList(int $parentId = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function vacancyLocationListSearch(ListedSearchParameter $parameter, int $parentId = null, bool $count = null);

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function vacancyLocationPageSearch(PagedSearchParameter $parameter, int $parentId = null, bool $count = false);

    //</editor-fold>
}