<?php

namespace App\Domains\Commons\Permission\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Permission\Contracts\Request\CreatePermissionRequest;
use App\Domains\Commons\Permission\Contracts\Request\EditPermissionAccessRequest;
use App\Domains\Commons\Permission\Contracts\Request\EditPermissionRequest;
use App\Domains\Commons\Role\Contracts\Request\EditRolePermissionRequest;

/**
 * Interface PermissionServiceInterface.
 */
interface PermissionServiceInterface
{
    /**
     * PermissionServiceInterface constructor.
     *
     * @param PermissionRepositoryInterface $repository
     */
    public function __construct(PermissionRepositoryInterface $repository);

    /**
     * Create Permission.
     *
     * @param CreatePermissionRequest $request
     *
     * @return mixed
     */
    public function create(CreatePermissionRequest $request): ObjectResponse;

    /**
     * Update Permission.
     *
     * @param EditPermissionRequest $request
     *
     * @return mixed
     */
    public function update(EditPermissionRequest $request): ObjectResponse;

    /**
     * @param EditPermissionAccessRequest $request
     * @return ObjectResponse
     */
    public function updatePermissionAccess(EditPermissionAccessRequest $request): ObjectResponse;

    /**
     * Delete Permission.
     *
     * @param PermissionInterface $Permission
     *
     * @return mixed
     */
    public function delete(PermissionInterface $Permission): BasicResponse;

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids): BasicResponse;

    /**
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findPermissionAccess(int $id): GenericCollectionResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function permissionList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function permissionListSearch(ListSearchRequest $listSearchRequest, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function permissionPageSearch(PageSearchRequest $pageSearchRequest, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param PermissionInterface $Permission
     * @return BasicResponse
     */
    public function permissionSetActive(PermissionInterface $Permission): BasicResponse;

    /**
     * @param PermissionInterface $Permission
     * @return ObjectResponse
     */
    public function permissionSlug(PermissionInterface $Permission): ObjectResponse;
}
