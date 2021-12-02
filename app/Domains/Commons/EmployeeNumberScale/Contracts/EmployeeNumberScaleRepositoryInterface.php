<?php

namespace App\Domains\Commons\EmployeeNumberScale\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\EmployeeNumberScale\Contracts\EloquentEmployeeNumberScaleRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface EmployeeNumberScaleRepositoryInterface.
 */
interface EmployeeNumberScaleRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * EmployeeNumberScaleRepositoryInterface constructor.
     *
     * @param EloquentEmployeeNumberScaleRepositoryInterface $eloquent
     */
    public function __construct(EloquentEmployeeNumberScaleRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create EmployeeNumberScale.
     *
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     *
     * @return mixed
     */
    public function create(EmployeeNumberScaleInterface $EmployeeNumberScale);

    /**
     * Update EmployeeNumberScale.
     *
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     *
     * @return mixed
     */
    public function update(EmployeeNumberScaleInterface $EmployeeNumberScale);

    /**
     * Delete EmployeeNumberScale.
     *
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     *
     * @return mixed
     */
    public function delete(EmployeeNumberScaleInterface $EmployeeNumberScale);

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
    public function employeeNumberScaleList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function employeeNumberScaleListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function employeeNumberScalePageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
