<?php

namespace App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\BaseSalaryCustomType\Contracts\EloquentBaseSalaryCustomTypeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface BaseSalaryCustomTypeRepositoryInterface.
 */
interface BaseSalaryCustomTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * BaseSalaryCustomTypeRepositoryInterface constructor.
     *
     * @param EloquentBaseSalaryCustomTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentBaseSalaryCustomTypeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create BaseSalaryCustomType.
     *
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     *
     * @return mixed
     */
    public function create(BaseSalaryCustomTypeInterface $BaseSalaryCustomType);

    /**
     * Update BaseSalaryCustomType.
     *
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     *
     * @return mixed
     */
    public function update(BaseSalaryCustomTypeInterface $BaseSalaryCustomType);

    /**
     * Delete BaseSalaryCustomType.
     *
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     *
     * @return mixed
     */
    public function delete(BaseSalaryCustomTypeInterface $BaseSalaryCustomType);

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
     * @param int|null $companyId
     * @param int|null $isActive
     * @return mixed
     */
    public function baseSalaryCustomTypeList(int $companyId = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function baseSalaryCustomTypeListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function baseSalaryCustomTypePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
