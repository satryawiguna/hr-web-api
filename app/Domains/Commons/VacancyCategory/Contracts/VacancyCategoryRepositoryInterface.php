<?php

namespace App\Domains\Commons\VacancyCategory\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\VacancyCategory\Contracts\EloquentVacancyCategoryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface VacancyCategoryRepositoryInterface.
 */
interface VacancyCategoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyCategoryRepositoryInterface constructor.
     *
     * @param EloquentVacancyCategoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyCategoryRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create VacancyCategory.
     *
     * @param VacancyCategoryInterface $VacancyCategory
     *
     * @return mixed
     */
    public function create(VacancyCategoryInterface $VacancyCategory);

    /**
     * Update VacancyCategory.
     *
     * @param VacancyCategoryInterface $VacancyCategory
     *
     * @return mixed
     */
    public function update(VacancyCategoryInterface $VacancyCategory);

    /**
     * Delete VacancyCategory.
     *
     * @param VacancyCategoryInterface $VacancyCategory
     *
     * @return mixed
     */
    public function delete(VacancyCategoryInterface $VacancyCategory);

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
    public function vacancyCategoryList();

    /**
     * @param ListedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function vacancyCategoryListSearch(ListedSearchParameter $parameter, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function vacancyCategoryPageSearch(PagedSearchParameter $parameter, bool $count = false);

    //</editor-fold>
}
