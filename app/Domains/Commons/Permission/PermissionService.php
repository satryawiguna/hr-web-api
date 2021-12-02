<?php

namespace App\Domains\Commons\Permission;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
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
use App\Domains\ServiceAbstract;
use App\Domains\Commons\Permission\Contracts\PermissionRepositoryInterface;
use App\Domains\Commons\Permission\Contracts\PermissionServiceInterface;
use App\Domains\Commons\Permission\Contracts\PermissionInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * PermissionService Class
 * It has all useful methods for business logic.
 */
class PermissionService extends ServiceAbstract implements PermissionServiceInterface
{
    /**
     * @var PermissionRepositoryInterface
     */
    protected $repository;

    /**
     * Loads our $repo with the actual Repo associated with our PermissionInterface
     * PermissionService constructor.
     *
     * @param PermissionRepositoryInterface $repository
     */
    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(CreatePermissionRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'server' => 'required',
            'path' => 'required'
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $permission = $this->repository->newInstance([
                "name" => $request->name,
                "slug" => $request->slug,
                "server" => $request->server,
                "path" => $request->path,
                "description" => $request->description,
                "is_active" => $request->is_active,
            ]);

            $this->setAuditableInformationFromRequest($permission, $request);

            $relation = null;
            $accesses = [];

            if (!is_null($request->access_ids) && !empty($request->access_ids)) {
                foreach($request->access_ids as $access_ids){
                    $accesses[] = [
                        "access_id" => $access_ids[0],
                        "type"      => $access_ids[1],
                        "value"     => $access_ids[2],
                    ];
                }

                $relation["accesses"]['data'] = $accesses;
                $relation["accesses"]['method'] = "attach";
            }

            $result = $this->repository->create($permission, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Permission was created', 200);
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
    public function update(EditPermissionRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'server' => 'required',
            'path' => 'required',
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $permission = $this->repository->find($request->id);

        $permission->fill([
            "name" => $request->name,
            "slug" => $request->slug,
            "server" => $request->server,
            "path" => $request->path,
            "description" => $request->description,
            "is_active" => $request->is_active
        ]);

        $this->setAuditableInformationFromRequest($permission, $request);

        try {
            $relation = null;

            if (!is_null($request->access_ids) && !empty($request->access_ids)) {
                foreach($request->access_ids as $access_ids){
                    $accesses[] = [
                        "access_id" => $access_ids[0],
                        "type"      => $access_ids[1],
                        "value"     => $access_ids[2],
                    ];

                    $detachIds[] = [
                        "permission_id" => $access_ids[0]
                    ];
                }

                $relation["accesses"]['data'] = $accesses;
                $relation["accesses"]['detachIds'] = $detachIds;
                $relation["accesses"]['method'] = "detachAttach";
            }

            $result = $this->repository->update($permission, $relation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Permission was updated', 200);
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
     * @param EditPermissionAccessRequest $request
     * @return ObjectResponse
     */
    public function updatePermissionAccess(EditPermissionAccessRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $permission = $this->repository->find($request->id);

            $relation = null;

            if (!is_null($request->access_ids) && !empty($request->access_ids)) {
                foreach($request->access_ids as $access_ids) {
                    $accesses[] = [
                        "access_id" => $access_ids[0],
                        "type" => $access_ids[1],
                        "value" => $access_ids[2],
                    ];

                    $detachIds[] = [
                        "access_id" => $access_ids[0]
                    ];
                }

                $relation["accesses"]['data'] = $accesses;
                $relation["accesses"]['detachIds'] = $detachIds;
                $relation["accesses"]['method'] = "detachAttach";
            }

            $permissionResult = $this->repository->update($permission, $relation);

            $response->setResult($permissionResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Permission access was updated', 200);
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
    public function delete(PermissionInterface $Permission): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'accesses' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->delete($Permission, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Permission was deleted', 200);
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
                'accesses' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->deleteBulk($ids, true, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Permissions was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    public function findPermissionAccess(int $id): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->findPermissionAccess($id);

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

    public function permissionList(int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->permissionList($isActive);

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

    public function permissionListSearch(ListSearchRequest $listSearchRequest, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->permissionListSearch($parameter, $isActive);
            $totalCount = $this->repository->permissionListSearch($parameter, $isActive, true);

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

    public function permissionPageSearch(PageSearchRequest $pageSearchRequest, int $isActive = null): GenericPageSearchResponse
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

            $results = $this->repository->permissionPageSearch($parameter, $isActive);
            $totalCount = $this->repository->permissionPageSearch($parameter, $isActive, true);
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
     * @param PermissionInterface $Permission
     * @return BasicResponse
     */
    public function permissionSetActive(PermissionInterface $Permission): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($Permission->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Permission);

        try {
            $result = $this->repository->update($Permission);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Permission was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Permission was deactivated', 200);
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
     * @param PermissionInterface $Permission
     * @return ObjectResponse
     */
    public function permissionSlug(PermissionInterface $Permission): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = (object)[
                'slug' => SlugService::createSlug($Permission, 'slug', $Permission->getName())
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
}
