<?php

namespace App\Domains\Commons\Permission\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Permission\Contracts\EloquentPermissionRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface PermissionRepositoryInterface.
 */
interface PermissionRepositoryInterface
{
    /**
     * PermissionRepositoryInterface constructor.
     *
     * @param EloquentPermissionRepositoryInterface $eloquent
     */
    public function __construct(EloquentPermissionRepositoryInterface $eloquent);

    /**
     * Create Permission.
     *
     * @param PermissionInterface $Permission
     *
     * @param array|null $relations
     * @return mixed
     */
    public function create(PermissionInterface $Permission, array $relations = null);

    /**
     * Update Permission.
     *
     * @param PermissionInterface $Permission
     *
     * @param array|null $relations
     * @return mixed
     */
    public function update(PermissionInterface $Permission, array $relations = null);

    /**
     * Delete Permission.
     *
     * @param PermissionInterface $Permission
     *
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function delete(PermissionInterface $Permission, array $relations = null, bool $isPermanentDelete = false);

    /**
     * @param array $ids
     * @param bool $isDeletePermanent
     * @param array|null $relations
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isDeletePermanent = false, array $relations = null);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function findPermissionAccess(int $id);

    /**
     * @param int|null $isActive
     * @return mixed
     */
    public function permissionList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function permissionListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function permissionPageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);
}
