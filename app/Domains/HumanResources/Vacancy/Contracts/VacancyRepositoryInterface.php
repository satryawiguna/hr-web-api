<?php

namespace App\Domains\HumanResources\Vacancy\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Vacancy\Contracts\EloquentVacancyRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface VacancyRepositoryInterface.
 */
interface VacancyRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyRepositoryInterface constructor.
     *
     * @param EloquentVacancyRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Vacancy.
     *
     * @param VacancyInterface $Vacancy
     * @param array|null $relation
     *
     * @return mixed
     */
    public function create(VacancyInterface $Vacancy, array $relation = null);

    /**
     * Update Vacancy.
     *
     * @param VacancyInterface $Vacancy
     * @param array|null $relation
     *
     * @return mixed
     */
    public function update(VacancyInterface $Vacancy, array $relation = null);

    /**
     * Delete Vacancy.
     *
     * @param VacancyInterface $Vacancy
     * @param bool $isPermanentDelete
     * @param array|null $relation
     * @return mixed
     */
    public function delete(VacancyInterface $Vacancy, bool $isPermanentDelete = false, array $relation = null);

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
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @return mixed
     */
    public function vacancyList(int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @param bool $count
     * @return mixed
     */
    public function vacancyListSearch(ListedSearchParameter $parameter, int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @param bool $count
     * @return mixed
     */
    public function vacancyPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null, bool $count = false);

    //</editor-fold>
}
