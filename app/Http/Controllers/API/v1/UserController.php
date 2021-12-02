<?php

namespace App\Http\Controllers\API\v1;


use App\Domains\User\Contracts\Request\EditUserPermissionRequest;
use App\Domains\User\Contracts\Request\EditUserPasswordRequest;
use App\Domains\User\Contracts\Request\EditUserRoleRequest;
use App\Domains\User\Contracts\UserServiceInterface;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    use BaseController;


    //<editor-fold desc="fields">

    private $_userServiceInterface;

    //</editor-fold>


    //<editor-fold desc="constructor">

    /**
     * UserController constructor.
     * @param UserServiceInterface $userServiceInterface
     */
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->_userServiceInterface = $userServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="public (method)">

    /**
     * @OA\Get(
     *     path="/user/list",
     *     operationId="getUserList",
     *     summary="Get list of user",
     *     tags={"User"},
     *     description="Get list of user",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="company_id",
     *          in="query",
     *          description="Company id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="application_id",
     *          in="query",
     *          description="Application id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="role_id",
     *          in="query",
     *          description="Role id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="permission_id",
     *          in="query",
     *          description="Permission id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
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
     *     @OA\Parameter(
     *          name="is_block",
     *          in="query",
     *          description="Is block parameter (blocked = 1; not unblocked = 0)",
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
    public function getUserList(Request $request)
    {
        $companyId = $request->get('company_id');
        $applicationId = $request->get('application_id');
        $roleId = $request->get('role_id');
        $permissionId = $request->get('permission_id');
        $isActive = $request->get('is_active');
        $isBlock = $request->get('is_block');

        return $this->getListJson($companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock,
            [$this->_userServiceInterface, 'userList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'username' => '***',
                        'email' => $entity->email,
                        'password' => '***',
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/user/list-search",
     *     operationId="postUserListSearch",
     *     summary="Get list of user with query search",
     *     tags={"User"},
     *     description="Get list of user with query search",
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
     *                      description="Query property (Keyword would be filter username and email)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(
     *                      property="company_id",
     *                      description="Company id property",
     *                      type="integer",
     *                      format="int64",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="application_id",
     *                      description="Application id property",
     *                      type="integer",
     *                      format="int32",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="role_id",
     *                      description="Role id property",
     *                      type="integer",
     *                      format="int32",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="permission_id",
     *                      description="Permission id property",
     *                      type="integer",
     *                      format="int64",
     *                      example=1
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/UserEloquent/properties/is_active"),
     *                  @OA\Property(property="is_block", ref="#/components/schemas/UserEloquent/properties/is_block")
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
    public function postUserListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $applicationId = $request->input('application_id');
        $roleId = $request->input('role_id');
        $permissionId = $request->input('permission_id');
        $isActive = $request->input('is_active');
        $isBlock = $request->input('is_block');

        return $this->getListSearchJson($request, $companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock,
            [$this->_userServiceInterface, 'userListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'companies' => $this->getCompanyObject($entity->companies),
                        'applications' => $this->getApplicationObject($entity->applications),
                        'roles' => $this->getRoleObject($entity->roles),
                        'permissions' => $this->getPermissionObject($entity->permissions),
                        'username' => '***',
                        'email' => $entity->email,
                        'password' => '***',
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/user/page-search",
     *     operationId="postUserPageSearch",
     *     summary="Get list of user with query and page parameter search",
     *     tags={"User"},
     *     description="Get list of user with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter username and email)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(
     *                              property="company_id",
     *                              description="Company id property",
     *                              type="integer",
     *                              format="int64",
     *                              example=1
     *                          ),
     *                          @OA\Property(
     *                              property="application_id",
     *                              description="Application id property",
     *                              type="integer",
     *                              format="int32",
     *                              example=1
     *                          ),
     *                          @OA\Property(
     *                              property="role_id",
     *                              description="Role id property",
     *                              type="integer",
     *                              format="int32",
     *                              example=1
     *                          ),
     *                          @OA\Property(
     *                              property="permission_id",
     *                              description="Permission id property",
     *                              type="integer",
     *                              format="int64",
     *                              example=1
     *                          ),
     *                          @OA\Property(property="is_active", ref="#/components/schemas/UserEloquent/properties/is_active"),
     *                          @OA\Property(property="is_block", ref="#/components/schemas/UserEloquent/properties/is_block")
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
    public function postUserPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $applicationId = $request->input('application_id');
        $roleId = $request->input('role_id');
        $permissionId = $request->input('permission_id');
        $isActive = $request->input('is_active');
        $isBlock = $request->input('is_block');

        return $this->getPagedSearchJson($request, $companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock,
            [$this->_userServiceInterface, 'userPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'companies' => $this->getCompanyObject($entity->companies),
                        'applications' => $this->getApplicationObject($entity->applications),
                        'roles' => $this->getRoleObject($entity->roles),
                        'permissions' => $this->getPermissionObject($entity->permissions),
                        'username' => $entity->username,
                        'email' => $entity->email,
                        'password' => $entity->password,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/user/detail/{id}",
     *     operationId="getUserDetail",
     *     summary="Get detail user",
     *     tags={"User"},
     *     description="Get detail user",
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserDetail(int $id)
    {
        return $this->getUserDetailObjectJson($id,
            [$this->_userServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'username' => '***',
                        'email' => $entity->email,
                        'password' => '***',
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
     *     path="/user/detail/{id}/company",
     *     operationId="getUserCompany",
     *     summary="Get company user",
     *     tags={"User"},
     *     description="Get company user",
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
    public function getUserCompany(int $id)
    {
        return $this->getUserCompanyListJson($id,
            [$this->_userServiceInterface, 'findUserCompany'],
            function ($entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'name' => $entity->name,
                        'slug' => $entity->slug
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/user/detail/{id}/application",
     *     operationId="getUserApplication",
     *     summary="Get application user",
     *     tags={"User"},
     *     description="Get application user",
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
     *              format="int64"
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
    public function getUserApplication(int $id)
    {
        return $this->getUserApplicationListJson($id,
            [$this->_userServiceInterface, 'findUserApplication'],
            function ($entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'name' => $entity->name,
                        'slug' => $entity->slug
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/user/detail/{id}/role",
     *     operationId="getUserRole",
     *     summary="Get role user",
     *     tags={"User"},
     *     description="Get role user",
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserRole(int $id)
    {
        return $this->getUserRoleListJson($id,
            [$this->_userServiceInterface, 'findUserRole'],
            function ($entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'name' => $entity->name,
                        'slug' => $entity->slug
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/user/detail/{id}/role/permission",
     *     operationId="getUserRolePermission",
     *     summary="Get role permission user",
     *     tags={"User"},
     *     description="Get role permission user",
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserPermission(int $id)
    {
        return $this->getUserPermissionListJson($id,
            [$this->_userServiceInterface, 'findUserPermission'],
            function ($entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'permissions' => Common::isDataExist($entity->permissions) ? $this->getPermissionObject($entity->permissions) : null
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Put(
     *     path="/user/update/password",
     *     operationId="putUserUpdatePassword",
     *     summary="User update password",
     *     tags={"User"},
     *     description="User update password",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateUserPasswordEloquent")
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
    public function putUserUpdatePassword(Request $request)
    {
        $editUserPasswordRequest = new EditUserPasswordRequest();
        $editUserPasswordRequest->id = $request->input('id');
        $editUserPasswordRequest->password = $request->input('password');
        $editUserPasswordRequest->confirm_password = $request->input('confirm_password');

        $this->setRequestAuthor($editUserPasswordRequest);

        $response = $this->_userServiceInterface->updateUserPassword($editUserPasswordRequest);
        $userPasswordUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $userPasswordUpdated);
    }

    /**
     * @OA\Put(
     *     path="/user/update/role",
     *     operationId="putUserUpdateRole",
     *     summary="User update role",
     *     tags={"User"},
     *     description="User update role",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateUserRoleEloquent")
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
    public function putUserUpdateRole(Request $request)
    {
        $editUserRoleRequest = new EditUserRoleRequest();
        $editUserRoleRequest->id = $request->input('id');
        $editUserRoleRequest->role_ids = $request->input('role_ids');

        $this->setRequestAuthor($editUserRoleRequest);

        $response = $this->_userServiceInterface->updateUserRole($editUserRoleRequest);
        $userRoleUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $userRoleUpdated);
    }

    /**
     * @OA\Put(
     *     path="/user/update/permission",
     *     operationId="putUserUpdatePermission",
     *     summary="User update permission",
     *     tags={"User"},
     *     description="User update permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateUserPermissionEloquent")
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
    public function putUserUpdatePermission(Request $request)
    {
        $editUserPermissionRequest = new EditUserPermissionRequest();
        $editUserPermissionRequest->id = $request->input('id');
        $editUserPermissionRequest->permission_ids = $request->input('permission_ids');

        $this->setRequestAuthor($editUserPermissionRequest);

        $response = $this->_userServiceInterface->updateUserPermission($editUserPermissionRequest);
        $userRoleUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $userRoleUpdated);
    }

    /**
     * @OA\Delete(
     *     path="/user/delete/{id}",
     *     operationId="deleteUser",
     *     summary="Delete user",
     *     tags={"User"},
     *     description="Delete user",
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
    public function postUserDelete(int $id)
    {
        $user = $this->_userServiceInterface->find($id);

        $result = $user->getObject();

        $response = $this->_userServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/user/active",
     *     operationId="putUserActive",
     *     summary="Set active user",
     *     tags={"User"},
     *     description="Set active user",
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
     *                      property="id",
     *                      description="Id property",
     *                      type="integer",
     *                      format="int64",
     *                      example=1
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/UserEloquent/properties/is_active"),
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
    public function putUserActive(Request $request)
    {
        $user = $this->_userServiceInterface->find($request->input('id'));

        $result = $user->getObject();

        $result->is_active = $request->input('is_active');

        $this->setRequestAuthor($result);

        $response = $this->_userServiceInterface->userSetActive($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/user/block",
     *     operationId="putUserBlock",
     *     summary="Set block user",
     *     tags={"User"},
     *     description="Set block user",
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
     *                      property="id",
     *                      description="Id parameter",
     *                      type="integer",
     *                      format="int64",
     *                      example=1
     *                  ),
     *                  @OA\Property(property="is_block", ref="#/components/schemas/UserEloquent/properties/is_block"),
     *                  required={
     *                      "id",
     *                      "is_block"
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
    public function putUserBlock(Request $request)
    {
        $user = $this->_userServiceInterface->find($request->input('id'));

        $result = $user->getObject();

        $result->is_block = $request->input('is_block');

        $this->setRequestAuthor($result);

        $response = $this->_userServiceInterface->userSetBlock($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    //</editor-fold>


    //<editor-fold desc="private (method)">

    /**
     * @param null $companyId
     * @param int|null $applicationId
     * @param int|null $roleId
     * @param int|null $permissionId
     * @param null $isActive
     * @param null $isBlock
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson($companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, $isActive = null, $isBlock = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock);
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
    private function getUserCompanyListJson($id = null,
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

    /**
     * @param null $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getUserApplicationListJson($id = null,
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

    /**
     * @param null $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getUserRoleListJson($id = null,
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

    /**
     * @param null $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getUserPermissionListJson($id = null,
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

    /**
     * @param Request $request
     * @param null $companyId
     * @param int|null $applicationId
     * @param int|null $roleId
     * @param int|null $permissionId
     * @param null $isActive
     * @param null $isBlock
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, $companyId = null, int $applicationId = null,  int $roleId = null, int $permissionId = null,
                                       $isActive = null, $isBlock = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param null $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param null $isActive
     * @param null $isBlock
     * @param callable $searchMethod
     * @param callable $dtoPageSearchToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null,
                                        $isActive = null, $isBlock = null,
                                        callable $searchMethod,
                                        callable $dtoPageSearchToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock);
        $rowJsonData = $dtoPageSearchToRowJsonMethod($response->getDtoCollection());

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

    /**
     * @param null $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getUserDetailObjectJson($id = null,
                                             callable $searchMethod,
                                             callable $dtoObjectToRowJsonMethod)
    {
        $response = $searchMethod($id);
        $itemJsonData = $dtoObjectToRowJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Collection $entities
     * @return Collection
     */
    private function getCompanyObject(Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $rowJsonData->push([
                'id' => $entity->id,
                'name' => $entity->name,
                'slug' => $entity->slug
            ]);
        }

        return $rowJsonData;
    }

    /**
     * @param Collection $entities
     * @return Collection
     */
    private function getApplicationObject(Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $rowJsonData->push([
                'id' => $entity->id,
                'name' => $entity->name,
                'slug' => $entity->slug
            ]);
        }

        return $rowJsonData;
    }

    /**
     * @param Collection $entities
     * @return Collection
     */
    private function getRoleObject(Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $rowJsonData->push([
                'id' => $entity->id,
                'name' => $entity->name,
                'slug' => $entity->slug
            ]);
        }

        return $rowJsonData;
    }

    /**
     * @param Collection $entities
     * @return Collection
     */
    private function getPermissionObject(Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $rowJsonData->push([
                'id' => $entity->id,
                'name' => $entity->name,
                'slug' => $entity->slug
            ]);
        }

        return $rowJsonData;
    }

    //</editor-fold>
}
