<?php

namespace App\Domains\Commons\Company\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Company\Contracts\EloquentCompanyRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use App\Infrastructures\MediaLibrary\Contracts\EloquentMediaLibraryRepositoryInterface;
use Closure;

/**
 * Interface CompanyRepositoryInterface.
 */
interface CompanyRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompanyRepositoryInterface constructor.
     *
     * @param EloquentCompanyRepositoryInterface $eloquent
     */
    public function __construct(EloquentCompanyRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Company.
     *
     * @param CompanyInterface $Company
     *
     * @param array|null $relations
     * @return mixed
     */
    public function create(CompanyInterface $Company, array $relations = null);

    /**
     * Update Company.
     *
     * @param CompanyInterface $Company
     *
     * @param array|null $relations
     * @return mixed
     */
    public function update(CompanyInterface $Company, array $relations = null);

    /**
     * Delete Company.
     *
     * @param CompanyInterface $Company
     *
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function delete(CompanyInterface $Company, bool $isPermanentDelete = false, array $relations = null);

    /**
     * @param array $ids
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isPermanentDelete = false, array $relations = null);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @return mixed
     */
    public function companyList(int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @param bool $count
     * @return mixed
     */
    public function companyListSearch(ListedSearchParameter $parameter, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @param bool $count
     * @return mixed
     */
    public function companyPageSearch(PagedSearchParameter $parameter, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
