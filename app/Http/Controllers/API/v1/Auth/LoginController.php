<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Domains\User\Contracts\Request\LoginRequest;
use App\Domains\User\Contracts\Request\LogoutRequest;
use App\Domains\User\Contracts\UserServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    use BaseController, AuthenticatesUsers;


    //<editor-fold desc="#field">

    private $_userServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * UserController constructor.
     * @param UserServiceInterface $userServiceInterface
     */
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->_userServiceInterface = $userServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="postLogin",
     *     summary="Login user",
     *     tags={"Login"},
     *     description="Login user",
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
     *                      property="identity",
     *                      description="identity property",
     *                      type="string"
     *                  ),
     *                  @OA\Property(property="password", ref="#/components/schemas/UserEloquent/properties/password"),
     *                  required={
     *                      "identity",
     *                      "password"
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
    public function postLogin(Request $request)
    {
        $loginRequest = new LoginRequest();

        if (filter_var($request->input('identity'), FILTER_VALIDATE_EMAIL)) {
            $loginRequest->email = $request->input('identity');
        } else {
            $loginRequest->username = $request->input('identity');
        }

        $loginRequest->password = $request->input('password');

        $responseLogin = $this->_userServiceInterface->login($loginRequest);

        if (!$responseLogin->isSuccess()) {
            return $this->getBasicErrorJson($responseLogin);
        }

        return $this->getBasicSuccessJson($responseLogin, $responseLogin->getObject());
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     operationId="postLogout",
     *     tags={"Logout"},
     *     description="Logout user",
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
     *                      format="int64"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogout(Request $request)
    {

        $logoutRequest = new LogoutRequest();

        $logoutRequest->id = (int)$request->input('id');

        $response = $this->_userServiceInterface->logout($logoutRequest);

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/token-refresh",
     *     operationId="postTokenRefresh",
     *     summary="Token refresh user",
     *     tags={"Token Refresh"},
     *     description="Token refresh user",
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
     *                      property="refresh_token",
     *                      description="Refresh token property",
     *                      type="string"
     *                  ),
     *                  required={
     *                      "refresh_token"
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
    public function postTokenRefresh(Request $request)
    {
        $refresh_token = $request->input('refresh_token');

        $response = $this->_userServiceInterface->tokenRefresh($refresh_token);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $response->getObject());
    }

    //</editor-fold>
}
