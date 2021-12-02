<?php

namespace App\Domains\Commons\CompanyCategory\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\CompanyCategory\Contracts\EloquentCompanyCategoryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface CompanyCategoryRepositoryInterface.
 */
interface CompanyCategoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompanyCategoryRepositoryInterface constructor.
     *
     * @param EloquentCompanyCategoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentCompanyCategoryRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create CompanyCategory.
     *
     * @param CompanyCategoryInterface $CompanyCategory
     *
     * @return mixed
     */
    public function create(CompanyCategoryInterface $CompanyCategory);

    /**
     * Update CompanyCategory.
     *
     * @param CompanyCategoryInterface $CompanyCategory
     *
     * @return mixed
     */
    public function update(CompanyCategoryInterface $CompanyCategory);

    /**
     * Delete CompanyCategory.
     *
     * @param CompanyCategoryInterface $CompanyCategory
     *
     * @return mixed
     */
    public function delete(CompanyCategoryInterface $CompanyCategory);

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
     * @param int|null $isActive
     * @return mixed
     */
    public function companyCategoryList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function companyCategoryListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function companyCategoryPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
