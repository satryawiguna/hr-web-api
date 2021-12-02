<?php

namespace App\Domains\HumanResources\MasterData\WorkArea\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\WorkArea\Contracts\EloquentWorkAreaRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface WorkAreaRepositoryInterface.
 */
interface WorkAreaRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkAreaRepositoryInterface constructor.
     *
     * @param EloquentWorkAreaRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkAreaRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkArea.
     *
     * @param WorkAreaInterface $WorkArea
     *
     * @return mixed
     */
    public function create(WorkAreaInterface $WorkArea);

    /**
     * Update WorkArea.
     *
     * @param WorkAreaInterface $WorkArea
     *
     * @return mixed
     */
    public function update(WorkAreaInterface $WorkArea);

    /**
     * Delete WorkArea.
     *
     * @param WorkAreaInterface $WorkArea
     *
     * @return mixed
     */
    public function delete(WorkAreaInterface $WorkArea);

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
     * @param string|null $country
     * @param int|null $isActive
     * @return mixed
     */
    public function workAreaList(int $companyId = null, string $country = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function workAreaListSearch(ListedSearchParameter $parameter, int $companyId = null, string $country = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function workAreaPageSearch(PagedSearchParameter $parameter, int $companyId = null, string $country = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
