<?php

namespace App\Domains\User\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\User\Contracts\EloquentUserRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface UserRepositoryInterface.
 */
interface UserRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * UserRepositoryInterface constructor.
     * @param EloquentUserRepositoryInterface $eloquent
     */
    public function __construct(EloquentUserRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create User.
     * @param UserInterface $User
     * @param array|null $relations
     * @return mixed
     */
    public function create(UserInterface $User, array $relations = null);

    /**
     * Update User.
     * @param UserInterface $User
     * @param array|null $relations
     * @return mixed
     */
    public function update(UserInterface $User, array $relations = null);

    /**
     * Delete User.
     * @param UserInterface $User
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function delete(UserInterface $User, bool $isPermanentDelete = false, array $relations = null);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param string $email
     * @return mixed
     */
    public function findUserLoginByEmail(string $email);

    /**
     * @param string $username
     * @return mixed
     */
    public function findUserLoginByUsername(string $username);

    /**
     * @param int $userId
     * @param int $permissionId
     * @return mixed
     */
    public function findUserPermission(int $userId, int $permissionId);

    /**
     * @param int $userId
     * @param int $permissionId
     * @param int $accessId
     * @return mixed
     */
    public function findUserAccess(int $userId, int $permissionId, int $accessId);

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserCompany(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserWhereHasCompany(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserApplication(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserRole(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserRolePermission(int $id);

    /**
     * @param string $email
     * @return mixed
     */
    public function findUserLoginToApiDocumentByEmail(string $email);

    /**
     * @param int $companyId
     * @param int $roleId
     * @param int|null $applicationId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @return mixed
     */
    public function userList(int $companyId = null, int $roleId = null, int $applicationId = null, int $permissionId = null, int $isActive = null, int $isBlock = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @param bool $count
     * @return mixed
     */
    public function userListSearch(ListedSearchParameter $parameter, int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @param bool $count
     * @return mixed
     */
    public function userPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null, bool $count = false);

    //</editor-fold>
}
