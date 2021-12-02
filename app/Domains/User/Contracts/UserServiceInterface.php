<?php

namespace App\Domains\User\Contracts;


use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\Commons\Company\Contracts\CompanyRepositoryInterface;
use App\Domains\Commons\Permission\Contracts\PermissionRepositoryInterface;
use App\Domains\User\Contracts\Request\EditUserPermissionRequest;
use App\Domains\User\Contracts\Request\EditUserPasswordRequest;
use App\Domains\User\Contracts\Request\EditUserRoleRequest;
use App\Domains\User\Contracts\Request\LoginRequest;
use App\Domains\User\Contracts\Request\LogoutRequest;
use App\Domains\User\Contracts\Request\RegisterUserRequest;
use App\Domains\User\Profile\Contracts\ProfileRepositoryInterface;

/**
 * Interface UserServiceInterface.
 */
interface UserServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * UserServiceInterface constructor.
     *
     * @param UserRepositoryInterface $repository
     * @param ProfileRepositoryInterface $profileRepository
     * @param CompanyRepositoryInterface $companyRepository
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(UserRepositoryInterface $repository,
                                ProfileRepositoryInterface $profileRepository,
                                CompanyRepositoryInterface $companyRepository,
                                PermissionRepositoryInterface $permissionRepository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @param RegisterUserRequest $request
     * @return mixed
     */
    public function registerUser(RegisterUserRequest $request): ObjectResponse;

    /**
     * @param EditUserPasswordRequest $request
     * @return mixed
     */
    public function updateUserPassword(EditUserPasswordRequest $request): ObjectResponse;

    /**
     * @param EditUserRoleRequest $request
     * @return mixed
     */
    public function updateUserRole(EditUserRoleRequest $request): ObjectResponse;

    /**
     * @param EditUserPermissionRequest $request
     * @return mixed
     */
    public function updateUserPermission(EditUserPermissionRequest $request): ObjectResponse;

    /**
     * Delete User.
     *
     * @param UserInterface $User
     *
     * @return mixed
     */
    public function delete(UserInterface $User): BasicResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findUserCompany(int $id): GenericCollectionResponse;

    /**
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findUserApplication(int $id): GenericCollectionResponse;

    /**
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findUserRole(int $id): GenericCollectionResponse;

    /**
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findUserRolePermission(int $id): GenericCollectionResponse;

    /**
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @return GenericCollectionResponse
     */
    public function userList(int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @return mixed
     */
    public function userListSearch(ListSearchRequest $request, int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @return mixed
     */
    public function userPageSearch(PageSearchRequest $request, int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null): GenericPageSearchResponse;

    /**
     * @param UserInterface $User
     * @return mixed
     */
    public function userSetActive(UserInterface $User): BasicResponse;

    /**
     * @param UserInterface $User
     * @return BasicResponse
     */
    public function userSetBlock(UserInterface $User): BasicResponse;


    /**
     * @param LoginRequest $request
     * @return ObjectResponse
     */
    public function login(LoginRequest $request): ObjectResponse;

    /**
     * @param LoginRequest $request
     * @return ObjectResponse
     */
    public function loginToApiDocument(LoginRequest $request): ObjectResponse;

    /**
     * @param LogoutRequest $request
     * @return BasicResponse
     */
    public function logout(LogoutRequest $request): BasicResponse;

    /**
     * @param string $refreshToken
     * @return ObjectResponse
     */
    public function tokenRefresh(string $refreshToken = null): ObjectResponse;

    //</editor-fold>
}
