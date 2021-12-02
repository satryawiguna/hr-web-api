<?php

namespace App\Domains\Commons\Role;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
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
use App\Domains\ServiceAbstract;
use App\Domains\Commons\Role\Contracts\RoleRepositoryInterface;
use App\Domains\Commons\Role\Contracts\RoleServiceInterface;
use App\Domains\Commons\Role\Contracts\RoleInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

/**
 * RoleService Class
 * It has all useful methods for business logic.
 */
class RoleService extends ServiceAbstract implements RoleServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var RoleRepositoryInterface
     */
    protected $repository;

    /**
     * Loads our $repo with the actual Repo associated with our RoleInterface
     * RoleService constructor.
     *
     * @param RoleRepositoryInterface $repository
     */
    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(CreateRoleRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'group_id' => 'required',
            'name'     => 'required',
            'slug'     => 'required'
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $role = $this->repository->newInstance([
                "group_id"    => $request->group_id,
                "name"        => $request->name,
                "slug"        => $request->slug,
                "description" => $request->description,
                "is_active"   => $request->is_active,
            ]);

            $this->setAuditableInformationFromRequest($role, $request);

            $relation = null;
            $permissions = [];

            if (!is_null($request->permission_ids) && !empty($request->permission_ids)) {
                foreach($request->permission_ids as $permission_ids){
                    $permissions[] = [
                        "permission_id" => $permission_ids[0],
                        "type" => $permission_ids[1],
                        "value" => $permission_ids[2],
                    ];
                }

                $relation["permissions"]['data'] = $permissions;
                $relation["permissions"]['method'] = "attach";
            }

            $result = $this->repository->create($role, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Role was created', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function update(EditRoleRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'group_id' => 'required',
            'name'     => 'required',
            'slug'     => 'required'
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $role = $this->repository->find($request->id);

        $role->fill([
            "group_id"    => $request->group_id,
            "name"        => $request->name,
            "slug"        => $request->slug,
            "description" => $request->description,
            "is_active"   => $request->is_active,
        ]);

        $this->setAuditableInformationFromRequest($role);

        try {
            $relation = null;

            if (!is_null($request->permission_ids) && !empty($request->permission_ids)) {
                foreach($request->permission_ids as $permission_ids){
                    $permissions[] = [
                        "permission_id" => $permission_ids[0],
                        "type" => $permission_ids[1],
                        "value" => $permission_ids[2],
                    ];

                    $detachIds[] = [
                        "permission_id" => $permission_ids[0]
                    ];
                }

                $relation["permissions"]['data'] = $permissions;
                $relation["permissions"]['detachIds'] = $detachIds;
                $relation["permissions"]['method'] = "detachAttach";
            }

            $result = $this->repository->update($role, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Role was updated', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param EditRolePermissionRequest $request
     * @return ObjectResponse
     */
    public function updateRolePermission(EditRolePermissionRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $role = $this->repository->find($request->id);

            $relation = null;

            if (!is_null($request->permission_ids) && !empty($request->permission_ids)) {
                foreach($request->permission_ids as $permission_ids) {
                    $permissions[] = [
                        "permission_id" => $permission_ids[0],
                        "type" => $permission_ids[1],
                        "value" => $permission_ids[2],
                    ];

                    $detachIds[] = [
                        "permission_id" => $permission_ids[0]
                    ];
                }

                $relation["permissions"]['data'] = $permissions;
                $relation["permissions"]['detachIds'] = $detachIds;
                $relation["permissions"]['method'] = "detachAttach";
            }

            $roleResult = $this->repository->update($role, $relation);

            $response->setResult($roleResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'User roles was updated', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new \App\Exceptions\ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RoleInterface $Role): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'permissions' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->delete($Role, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Role was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param array $ids
     * @return BasicResponse
     */
    public function deleteBulk(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'permissions' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->deleteBulk($ids, true, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Roles was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findRolePermission(int $id): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->findRolePermission($id);

            $response->setDtoList($results);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new \App\Exceptions\ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function roleList(int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->roleList($isActive);

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function roleListSearch(ListSearchRequest $listSearchRequest, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->roleListSearch($parameter, $isActive);
            $totalCount = $this->repository->roleListSearch($parameter, $isActive, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function rolePageSearch(PageSearchRequest $pageSearchRequest, int $isActive = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

        try {
            if ($pageSearchRequest->draw) {
                $parameter->draw = $pageSearchRequest->draw;
                $parameter->columns = $pageSearchRequest->columns;
                $parameter->order = $pageSearchRequest->order;
                $parameter->start = $pageSearchRequest->start;
                $parameter->length = $pageSearchRequest->length;
                $parameter->search = $pageSearchRequest->search;
            } else {
                $parameter->pagination = $pageSearchRequest->pagination;
                $parameter->query = $pageSearchRequest->query;
                $parameter->sort = $pageSearchRequest->sort;
            }

            $results = $this->repository->rolePageSearch($parameter, $isActive);
            $totalCount = $this->repository->rolePageSearch($parameter, $isActive, true);
            if ($pageSearchRequest->draw) {
                $totalPage = ceil($totalCount / $parameter->length);
            } else {
                $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
            }

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);
            $response->setTotalPage($totalPage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param RoleInterface $Role
     * @return BasicResponse
     */
    public function roleSetActive(RoleInterface $Role): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($Role->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Role);

        try {
            $result = $this->repository->update($Role);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Role was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Role was deactivated', 200);
            }

        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param RoleInterface $Role
     * @return ObjectResponse
     */
    public function roleSlug(RoleInterface $Role): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = (object)[
                'slug' => SlugService::createSlug($Role, 'slug', $Role->getName())
            ];

            $response->setResult($result);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    //</editor-fold>
}
