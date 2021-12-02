<?php

namespace App\Domains\Commons\Role\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\Commons\Role\Contracts\Request\CreateRoleRequest;
use App\Domains\Commons\Role\Contracts\Request\EditRolePermissionRequest;
use App\Domains\Commons\Role\Contracts\Request\EditRoleRequest;

/**
 * Interface RoleServiceInterface.
 */
interface RoleServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RoleServiceInterface constructor.
     *
     * @param RoleRepositoryInterface $repository
     */
    public function __construct(RoleRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Role.
     *
     * @param CreateRoleRequest $request
     * @return mixed
     */
    public function create(CreateRoleRequest $request): ObjectResponse;

    /**
     * Update Role.
     *
     * @param EditRoleRequest $request
     *
     * @return mixed
     */
    public function update(EditRoleRequest $request): ObjectResponse;

    /**
     * @param EditRolePermissionRequest $request
     * @return ObjectResponse
     */
    public function updateRolePermission(EditRolePermissionRequest $request): ObjectResponse;

    /**
     * Delete Role.
     *
     * @param RoleInterface $Role
     *
     * @return mixed
     */
    public function delete(RoleInterface $Role): BasicResponse;

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids): BasicResponse;

    /**
     * @param int $id
     * @return mixed
     */
    public function findRolePermission(int $id): GenericCollectionResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function roleList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function roleListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function rolePageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param RoleInterface $Role
     * @return mixed
     */
    public function roleSetActive(RoleInterface $Role): BasicResponse;

    /**
     * @param RoleInterface $Role
     * @return ObjectResponse
     */
    public function roleSlug(RoleInterface $Role): ObjectResponse;

    //</editor-fold>
}
