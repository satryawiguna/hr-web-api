<?php

namespace App\Http\Controllers\API\v1\Commons;

use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Permission\Contracts\PermissionServiceInterface;
use App\Domains\Commons\Permission\Contracts\Request\CreatePermissionRequest;
use App\Domains\Commons\Permission\Contracts\Request\EditPermissionAccessRequest;
use App\Domains\Commons\Permission\Contracts\Request\EditPermissionRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class PermissionController extends Controller
{
    use BaseController;

    private $_permissionServiceInterface;

    public function __construct(PermissionServiceInterface $permissionServiceInterface)
    {
        $this->_permissionServiceInterface = $permissionServiceInterface;
    }

    /**
     * @OA\Get(
     *     path="/permission/list",
     *     operationId="getPermissionList",
     *     summary="Get list of permission",
     *     tags={"Permission"},
     *     description="Get list of permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="is_active",
     *          in="query",
     *          description="Is active parameter (active = 1; not active = 0)",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissionList(Request $request)
    {
        $isActive = $request->get('is_active');

        return $this->getListJson([$this->_permissionServiceInterface, 'permissionList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'server' => $entity->server,
                        'path' => $entity->path,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            }, $isActive);
    }

    /**
     * @OA\Post(
     *     path="/permission/list-search",
     *     operationId="postPermissionListSearch",
     *     summary="Get list of permission with query search",
     *     tags={"Permission"},
     *     description="Get list of permission with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter name, slug, server, path and description)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/PermissionEloquent/properties/is_active")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPermissionListSearch(Request $request)
    {
        $isActive = $request->input('is_active');

        return $this->getListSearchJson($request,
            [$this->_permissionServiceInterface, 'permissionListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'server' => $entity->server,
                        'path' => $entity->path,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            }, $isActive);
    }

    /**
     * @OA\Post(
     *     path="/permission/page-search",
     *     operationId="postPermissionPageSearch",
     *     summary="Get list of permission with query and page parameter search",
     *     tags={"Permission"},
     *     description="Get list of permission with query and page parameter search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="query",
     *                              description="Query property (Keyword would be filter name, slug, server, path and description)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="is_active", ref="#/components/schemas/PermissionEloquent/properties/is_active")
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/PagedSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function postPermissionPageSearch(Request $request)
    {
        $isActive = $request->input('is_active');

        return $this->getPagedSearchJson($request,
            [$this->_permissionServiceInterface, 'permissionPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'server' => $entity->server,
                        'path' => $entity->path,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            }, $isActive);
    }

    /**
     * @OA\Get(
     *     path="/permission/detail/{id}",
     *     operationId="getPermissionDetail",
     *     summary="Get detail permission",
     *     tags={"Permission"},
     *     description="Get detail permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissionDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_permissionServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'server' => $entity->server,
                        'path' => $entity->path,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });

    }

    /**
     * @OA\Get(
     *     path="/permission/detail/{id}/access",
     *     operationId="getPermissionAccess",
     *     summary="Get access role",
     *     tags={"Permission"},
     *     description="Get access role",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissionAccess(int $id)
    {
        return $this->getPermissionAccessListJson($id,
            [$this->_permissionServiceInterface, 'findPermissionAccess'],
            function ($entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'type' => $entity->pivot->type,
                        'value' => $entity->pivot->value,
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/permission/create",
     *     operationId="postPermissionCreate",
     *     summary="Create permission",
     *     tags={"Permission"},
     *     description="Create permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/CreatePermissionEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="access_ids",
     *                              description="Access ids property",
     *                              example={{1, "READ", "ALLOW"},{2, "WRITE", "DENY"}}
     *                          )
     *                      )
     *                  }
     *              )
     *
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function postPermissionCreate(Request $request)
    {
        $createPermissionRequest = new CreatePermissionRequest();

        $createPermissionRequest->name = $request->input('name');
        $createPermissionRequest->slug = $request->input('slug');
        $createPermissionRequest->server = $request->input('server');
        $createPermissionRequest->path = $request->input('path');
        $createPermissionRequest->description = $request->input('description');
        $createPermissionRequest->is_active = $request->input('is_active');

        $createPermissionRequest->access_ids = $request->input('access_ids');

        $this->setRequestAuthor($createPermissionRequest);

        $response = $this->_permissionServiceInterface->create($createPermissionRequest);
        $roleCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $roleCreated);
    }

    /**
     * @OA\Put(
     *     path="/permission/update",
     *     operationId="putPermissionUpdate",
     *     summary="Update permission",
     *     tags={"Permission"},
     *     description="Return object of permission updated",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/UpdatePermissionEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="access_ids",
     *                              description="Access ids property",
     *                              example={{1, "READ", "ALLOW"},{2, "WRITE", "DENY"}}
     *                          )
     *                      )
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putPermissionUpdate(Request $request)
    {
        $editPermissionRequest = new EditPermissionRequest();
        $editPermissionRequest->id = $request->input('id');
        $editPermissionRequest->name = $request->input('name');
        $editPermissionRequest->slug = $request->input('slug');
        $editPermissionRequest->server = $request->input('server');
        $editPermissionRequest->path = $request->input('path');
        $editPermissionRequest->description = $request->input('description');
        $editPermissionRequest->is_active = $request->input('is_active');

        $editPermissionRequest->access_ids = $request->input('access_ids');

        $this->setRequestAuthor($editPermissionRequest);

        $response = $this->_permissionServiceInterface->update($editPermissionRequest);
        $roleUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $roleUpdated);
    }

    /**
     * @OA\Put(
     *     path="/permission/update/access",
     *     operationId="putPermissionAccessUpdate",
     *     summary="Update permission access",
     *     tags={"Permission"},
     *     description="Update permission access",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdatePermissionAccessEloquent")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putPermissionUpdateAccess(Request $request)
    {
        $editPermissionAccessRequest = new EditPermissionAccessRequest();
        $editPermissionAccessRequest->id = $request->input('id');
        $editPermissionAccessRequest->access_ids = $request->input('access_ids');

        $this->setRequestAuthor($editPermissionAccessRequest);

        $response = $this->_permissionServiceInterface->updatePermissionAccess($editPermissionAccessRequest);
        $userRoleUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $userRoleUpdated);
    }

    /**
     * @OA\Delete(
     *     path="/permission/delete/{id}",
     *     operationId="deletePermission",
     *     summary="Delete permission",
     *     tags={"Permission"},
     *     description="Delete permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePermission(int $id)
    {
        $permission = $this->_permissionServiceInterface->find($id);

        $result = $permission->getObject();

        $response = $this->_permissionServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/permission/deletes",
     *     operationId="deleteBulkPermission",
     *     summary="Delete bulk permission",
     *     tags={"Permission"},
     *     description="Delete bulk permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="ids",
     *                      description="Ids property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          format="int64",
     *                          example=1
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return ObjectResponse|\Illuminate\Http\JsonResponse|mixed
     */
    public function deleteBulkPermission(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_permissionServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/permission/active",
     *     operationId="putPermissionActive",
     *     summary="Set active permission",
     *     tags={"Permission"},
     *     description="Set active permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                       property="id",
     *                       type="integer",
     *                       format="int64",
     *                       description="Id property",
     *                       example=1
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/PermissionEloquent/properties/is_active"),
     *                  required={
     *                      "id",
     *                      "is_active"
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putPermissionActive(Request $request)
    {
        $role = $this->_permissionServiceInterface->find($request->input('id'));

        $result = $role->getObject();

        $result->is_active = $request->input('is_active');

        $this->setRequestAuthor($result);

        $response = $this->_permissionServiceInterface->permissionSetActive($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/permission/slug/{name}",
     *     operationId="getPermissionSlug",
     *     summary="Get slug of permission",
     *     tags={"Permission"},
     *     description="Get slug of permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissionSlug(string $name)
    {
        return $this->getSlugObjectJson($name,
            [$this->_permissionServiceInterface, 'permissionSlug'],
            function ($entity) {
                $rowJsonData = new Collection();

                $rowJsonData->push([
                    'slug' => $entity->slug
                ]);

                return $rowJsonData->first();
            });
    }

    private function getListSearchJson(Request $request,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod,
                                       int $isActive = null)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $isActive);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    private function getListJson(callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod,
                                 int $isActive = null)
    {
        $response = $searchMethod($isActive);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param null $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPermissionAccessListJson($id = null,
                                            callable $searchMethod,
                                            callable $dtoObjectToRowJsonMethod)
    {
        $response = $searchMethod($id);
        $itemJsonData = $dtoObjectToRowJsonMethod($response->getDtoList());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    private function getPagedSearchJson(Request $request,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod,
                                        int $isActive = null)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $isActive);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            if ($parameter->draw) {
                return response()->json([
                    'rows' => $rowJsonData,
                    'rowCountPage' => $response->getTotalPage(),
                    'rowCountTotal' => $response->getTotalCount()
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'page' => (integer)$parameter->pagination['page'],
                        'pages' => $response->getTotalPage(),
                        'perpage' => (integer)$parameter->pagination['perpage'],
                        'total' => $response->getTotalCount(),
                        'sort' => $parameter->sort['sort'],
                        'field' => $parameter->sort['field']
                    ],
                    'rows' => $rowJsonData
                ]);
            }
        }

        return $this->getBasicErrorJson($response);
    }

    private function getDetailObjectJson(int $id,
                                         callable $searchMethod,
                                         callable $dtoObjectToJsonMethod)
    {
        $response = $searchMethod($id);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    private function getSlugObjectJson(string $name,
                                       callable $searchMethod,
                                       callable $dtoObjectToJsonMethod)
    {
        $role = $this->_permissionServiceInterface->newInstance();
        $role->name = $name;

        $response = $searchMethod($role);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }
}
