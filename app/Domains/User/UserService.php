<?php

namespace App\Domains\User;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\Commons\Company\Contracts\CompanyRepositoryInterface;
use App\Domains\Commons\Permission\Contracts\PermissionRepositoryInterface;
use App\Domains\ServiceAbstract;
use App\Domains\User\Contracts\Request\EditUserPermissionRequest;
use App\Domains\User\Contracts\Request\EditUserPasswordRequest;
use App\Domains\User\Contracts\Request\EditUserRoleRequest;
use App\Domains\User\Contracts\Request\LoginRequest;
use App\Domains\User\Contracts\Request\LogoutRequest;
use App\Domains\User\Contracts\Request\RegisterUserRequest;
use App\Domains\User\Contracts\UserRepositoryInterface;
use App\Domains\User\Contracts\UserServiceInterface;
use App\Domains\User\Contracts\UserInterface;
use App\Domains\User\Profile\Contracts\ProfileRepositoryInterface;
use ErrorException;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use GuzzleHttp;
use Laravel\Passport\Client as OClient;

/**
 * UserService Class
 * It has all useful methods for business logic.
 */
class UserService extends ServiceAbstract implements UserServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var UserRepositoryInterface
     */
    protected $repository;

    private $_profileRepository;

    private $_companyRepository;

    private $_permissionRepository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our UserInterface
     * UserService constructor.
     *
     * @param UserRepositoryInterface $repository
     * @param ProfileRepositoryInterface $profileRepository
     * @param CompanyRepositoryInterface $companyRepository
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(UserRepositoryInterface $repository,
                                ProfileRepositoryInterface $profileRepository,
                                CompanyRepositoryInterface $companyRepository,
                                PermissionRepositoryInterface $permissionRepository)
    {
        $this->repository = $repository;
        $this->_profileRepository = $profileRepository;
        $this->_companyRepository = $companyRepository;
        $this->_permissionRepository = $permissionRepository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @param RegisterUserRequest $request
     * @return ObjectResponse|mixed
     */
    public function registerUser(RegisterUserRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'full_name' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ];

        if ($request->group == "company") {
            $rules = array_merge($rules, [
                'company_category_id' => 'required',
                'employee_number_scale_id' => 'required',
                'name' => 'required'
            ]);
        }

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $profile = $this->_profileRepository->newInstance([
                "full_name" => $request->full_name,
                "nick_name" => $request->nick_name,
                "email" => $request->email
            ]);

            $this->setAuditableInformationFromRequest($profile);

            $profileResult = $this->_profileRepository->create($profile);

            $user = $this->repository->newInstance([
                "email" => $request->email,
                "username" => $request->username,
                "password" => $request->password
            ]);

            $this->setAuditableInformationFromRequest($user);

            $user->setAttribute("profile_id", $profileResult->id);
            $user->setAttribute("password", bcrypt($request->password));

            $relation = null;

            if (!is_null($request->application_ids) && !empty($request->application_ids)) {
                $relation['applications'] = $request->application_ids;
            }

            if ($request->group == "company") {
                $relation['roles'] = [3];
            } else if ($request->group == "employee") {
                $relation['roles'] = [7];
            }

            if ($request->group == "company") {
                $company = $this->_companyRepository->newInstance([
                    "company_category_id" => $request->company_category_id,
                    "employee_number_scale_id" => $request->employee_number_scale_id,
                    "name" => $request->name,
                    "email" => $request->email
                ]);

                $this->setAuditableInformationFromRequest($company);

                $companyResult = $this->_companyRepository->create($company);

                $relation['companies'] = [$companyResult->id];
            }

            $userResult = $this->repository->create($user, $relation);

            $response->setResult($userResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'User was registered', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }
    }

    /**
     * @param EditUserPasswordRequest $request
     * @return ObjectResponse|mixed
     */
    public function updateUserPassword(EditUserPasswordRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'confirm_password' => 'same:password'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            if (!is_null($request->password) && !empty($request->password)) {
                $user = $this->repository->find($request->id);

                $user->setAttribute("password", bcrypt($request->password));
                $userResult = $this->repository->update($user);

                $response->setResult($userResult);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'User password was updated', 200);
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
     * @param EditUserRoleRequest $request
     * @return ObjectResponse|mixed
     */
    public function updateUserRole(EditUserRoleRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            if (!is_null($request->role_ids) && !empty($request->role_ids)) {
                $user = $this->repository->find($request->id);

                $userResult = $this->repository->update($user, [
                    "roles" => $request->role_ids
                ], "sync");

                $response->setResult($userResult);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'User roles was updated', 200);
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
     * @param EditUserPermissionRequest $request
     * @return ObjectResponse|mixed
     */
    public function updateUserPermission(EditUserPermissionRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            if (!is_null($request->permission_ids) && !empty($request->permission_ids)) {
                $user = $this->repository->find($request->id);

                $userResult = $this->repository->update($user, [
                    "permissions" => $request->permission_ids
                ], "sync");

                $response->setResult($userResult);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'User permission was updated', 200);
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
     * @param UserInterface $User
     * @return BasicResponse|mixed
     */
    public function delete(UserInterface $User): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'companies',
                'applications',
                'roles',
                'permissions'
            ];

            $this->repository->delete($User, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'User was deleted', 200);
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
    public function findUserCompany(int $id): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->findUserCompany($id);

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
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findUserApplication(int $id): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->findUserApplication($id);

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
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findUserRole(int $id): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->findUserRole($id);

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
     * @param int $id
     * @return GenericCollectionResponse
     */
    public function findUserRolePermission(int $id): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->findUserRolePermission($id);

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
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @return GenericCollectionResponse
     */
    public function userList(int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->userList($companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock);

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
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @return GenericListSearchResponse
     */
    public function userListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->userListSearch($parameter, $companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock);
            $totalCount = $this->repository->userListSearch($parameter, $companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock, true);

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
     * @param int $companyId
     * @param int|null $applicationId
     * @param int $roleId
     * @param int|null $permissionId
     * @param int $isActive
     * @param int $isBlock
     * @return GenericPageSearchResponse|mixed
     */
    public function userPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $applicationId = null, int $roleId = null, int $permissionId = null, int $isActive = null, int $isBlock = null): GenericPageSearchResponse
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

            $results = $this->repository->userPageSearch($parameter, $companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock);
            $totalCount = $this->repository->userPageSearch($parameter, $companyId, $applicationId, $roleId, $permissionId, $isActive, $isBlock, true);

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
     * @param UserInterface $User
     * @return BasicResponse|mixed
     */
    public function userSetActive(UserInterface $User): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($User->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($User);

        try {
            $result = $this->repository->update($User);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'User was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'User was deactivated', 200);
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
     * @param UserInterface $User
     * @return BasicResponse
     */
    public function userSetBlock(UserInterface $User): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($User->toArray(), [
            'is_block' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($User);

        try {
            $result = $this->repository->update($User);

            if ($result->is_block == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(),'User was block enabled', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(),'User was block disabled', 200);
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
     * @param LoginRequest $request
     * @return ObjectResponse
     */
    public function login(LoginRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rule = [];

        if ($request->username) {
            $rule = ['username' => 'required'];
        }

        if ($request->email) {
            $rule = ['email' => 'required|email'];
        }

        $validator = Validator::make((array) $request, $rule);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $userResult = ($request->email !== null) ?
                $this->repository->findUserLoginByEmail($request->email)
                    ->first() :
                $this->repository->findUserLoginByUsername($request->username)
                    ->first();

            if (!$userResult) {
                $response->addErrorMessageResponse($response->getMessageCollection(), 'Credential doesn\'t match', 400);

                return $response;
            }

            if (!Hash::check($request->password, $userResult->password)) {
                $response->addErrorMessageResponse($response->getMessageCollection(),'Password doesn\'t match',  400);

                return $response;
            }

            //Overwrite permission and access
            foreach ($userResult->roles as $role) {
                foreach ($role->permissions as $permission) {
                    $userPermission = $this->repository->findUserPermission($userResult->id, $permission->id);

                    if ($userPermission->permissions->count() > 0) {
                        $permission->value = $userPermission->permissions->first()->value;
                    }

                    foreach ($permission->accesses as $access) {
                        $userAccess = $this->repository->findUserAccess($userResult->id, $permission->id, $access->id);

                        if ($userAccess->accesses->count() > 0) {
                            $access->value = $userAccess->accesses->first()->value;
                        }
                    }
                }
            }

            $oClient = OClient::where('password_client', 1)->first();

            $http = new Client(['verify' => false]);
            $token = $http->request('POST', env('APP_URL') . 'oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'username' => ($request->email !== null) ? $request->email : $request->username,
                    'password' => $request->password,
                    'scope' => '*'
                ]
            ]);

            $tokenResult = json_decode((string) $token->getBody(), true);

            $response->setResult(new Collection([
                'user' => $userResult,
                'token' => $tokenResult
            ]));


            $response->addSuccessMessageResponse($response->getMessageCollection(),'Logged', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), $ex->getCode());
        }

        return $response;
    }

    /**
     * @param LoginRequest $request
     * @return ObjectResponse
     */
    public function loginToApiDocument(LoginRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $userResult = $this->repository->findUserLoginToApiDocumentByEmail($request->email)->first();

            if (!Hash::check($request->password, $userResult->password)) {
                $response->addErrorMessageResponse($response->getMessageCollection(),'Password doesn\'t match',  400);

                return $response;
            }

            if (!$userResult) {
                $response->addErrorMessageResponse($response->getMessageCollection(),'Credential doesn\'t match',  400);

                return $response;
            }

            $response->setResult($userResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'OK', 200);

            return $response;
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), $ex->getCode());
        }

        return $response;
    }

    /**
     * @param LogoutRequest $request
     * @return BasicResponse
     */
    public function logout(LogoutRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $user = $this->repository->find($request->id);

            $oAuthAccessTokens = $user->oAuthAccessTokens();
            $oAuthAccessTokens->delete();

            $response->addSuccessMessageResponse($response->getMessageCollection(),'Logout', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), $ex->getCode());
        }

        return $response;
    }

    /**
     * @param $refreshToken
     * @return ObjectResponse
     */
    public function tokenRefresh(string $refreshToken = null): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $oClient = OClient::where('password_client', 1)->first();

            $http = new Client(['verify' => false]);
            $token = $http->request('POST', env('APP_URL') . 'oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'scope' => '*'
                ]
            ]);

            $tokenResult = json_decode((string) $token->getBody(), true);

            $response->setResult(new Collection([
                'token' => $tokenResult
            ]));

            $response->addSuccessMessageResponse($response->getMessageCollection(),'Token refreshed', 200);
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


    //<editor-fold desc="#private (method)">


    //</editor-fold>
}
