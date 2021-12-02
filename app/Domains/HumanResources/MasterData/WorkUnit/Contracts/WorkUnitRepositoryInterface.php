<?php

namespace App\Domains\HumanResources\MasterData\WorkUnit\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\WorkUnit\Contracts\EloquentWorkUnitRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface WorkUnitRepositoryInterface.
 */
interface WorkUnitRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkUnitRepositoryInterface constructor.
     *
     * @param EloquentWorkUnitRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkUnitRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkUnit.
     *
     * @param WorkUnitInterface $WorkUnit
     *
     * @return mixed
     */
    public function create(WorkUnitInterface $WorkUnit);

    /**
     * Update WorkUnit.
     *
     * @param WorkUnitInterface $WorkUnit
     *
     * @return mixed
     */
    public function update(WorkUnitInterface $WorkUnit);

    /**
     * Delete WorkUnit.
     *
     * @param WorkUnitInterface $WorkUnit
     *
     * @return mixed
     */
    public function delete(WorkUnitInterface $WorkUnit);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * Get CompanySize.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return mixed
     */
    public function workUnitList(int $parentId = null, int $companyId = null, string $country = null, int $isActive = null);

    /**
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return mixed
     */
    public function workUnitListHierarchical(int $companyId = null, string $country = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function workUnitListSearch(ListedSearchParameter $parameter, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function workUnitPageSearch(PagedSearchParameter $parameter, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
