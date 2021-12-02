<?php

namespace App\Domains\Commons\MaritalStatus\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\MaritalStatus\Contracts\EloquentMaritalStatusRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface MaritalStatusRepositoryInterface.
 */
interface MaritalStatusRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * MaritalStatusRepositoryInterface constructor.
     *
     * @param EloquentMaritalStatusRepositoryInterface $eloquent
     */
    public function __construct(EloquentMaritalStatusRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create MaritalMaritalStatus.
     *
     * @param MaritalStatusInterface $MaritalStatus
     *
     * @return mixed
     */
    public function create(MaritalStatusInterface $MaritalStatus);

    /**
     * Update MaritalStatus.
     *
     * @param MaritalStatusInterface $MaritalStatus
     *
     * @return mixed
     */
    public function update(MaritalStatusInterface $MaritalStatus);

    /**
     * Delete MaritalStatus.
     *
     * @param MaritalStatusInterface $MaritalStatus
     *
     * @return mixed
     */
    public function delete(MaritalStatusInterface $MaritalStatus);

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

    public function findWhere(array $where);

    /**
     * @param int|null $isActive
     * @return mixed
     */
    public function maritalStatusList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function maritalStatusListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function maritalStatusPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
