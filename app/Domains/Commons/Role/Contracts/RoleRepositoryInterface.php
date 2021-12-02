<?php

namespace App\Domains\Commons\Role\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Commons\Role\Contracts\EloquentRoleRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface RoleRepositoryInterface.
 */
interface RoleRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RoleRepositoryInterface constructor.
     *
     * @param EloquentRoleRepositoryInterface $eloquent
     */
    public function __construct(EloquentRoleRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Create Role.
     *
     * @param RoleInterface $Role
     *
     * @param array|null $relations
     * @return mixed
     */
    public function create(RoleInterface $Role, array $relations = null);

    /**
     * Update Role.
     *
     * @param RoleInterface $Role
     *
     * @param array|null $relations
     * @return mixed
     */
    public function update(RoleInterface $Role, array $relations = null);

    /**
     * Delete Role.
     *
     * @param RoleInterface $Role
     *
     * @param array|null $relations
     * @return mixed
     */
    public function delete(RoleInterface $Role, array $relations = null);

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
     * @param int $id
     * @return mixed
     */
    public function findRolePermission(int $id);

    /**
     * @param int|null $isActive
     * @return mixed
     */
    public function roleList(int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function roleListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function rolePageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false);

    //</editor-fold>
}
