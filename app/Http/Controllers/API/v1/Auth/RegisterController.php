<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Domains\User\Contracts\Request\RegisterUserRequest;
use App\Domains\User\Contracts\UserServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    use BaseController;


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
     *     path="/register/{group}",
     *     operationId="postUserRegister",
     *     summary="User Register",
     *     tags={"User"},
     *     description="User Register",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="group",
     *          in="query",
     *          description="Group parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="company"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="full_name", ref="#/components/schemas/ProfileEloquent/properties/full_name"),
     *                  @OA\Property(property="nick_name", ref="#/components/schemas/ProfileEloquent/properties/nick_name"),
     *                  @OA\Property(property="email", ref="#/components/schemas/UserEloquent/properties/email"),
     *                  @OA\Property(property="username", ref="#/components/schemas/UserEloquent/properties/username"),
     *                  @OA\Property(property="password", ref="#/components/schemas/UserEloquent/properties/password"),
     *                  @OA\Property(
     *                      property="confirm_password",
     *                      description="Confirm password property",
     *                      type="string"
     *                  ),
     *                  @OA\Property(property="company_category_id", ref="#/components/schemas/CompanyEloquent/properties/company_category_id"),
     *                  @OA\Property(property="employee_number_scale_id", ref="#/components/schemas/CompanyEloquent/properties/employee_number_scale_id"),
     *                  @OA\Property(property="name", ref="#/components/schemas/CompanyEloquent/properties/name"),
     *                  @OA\Property(
     *                      property="application_ids",
     *                      description="Application ids property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          format="int64"
     *                      ),
     *                      example={1,2,3}
     *                  ),
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
     * @param string $group
     * @return mixed
     */
    public function postRegister(Request $request, string $group)
    {
        $registerUserRequest = new RegisterUserRequest();

        $registerUserRequest->group = $group;

        //Profil
        $registerUserRequest->full_name =  $request->input('full_name');
        $registerUserRequest->nick_name =  $request->input('nick_name');

        //User
        $registerUserRequest->application_id = $request->input('application_id');
        $registerUserRequest->email = $request->input('email');
        $registerUserRequest->username = $request->input('username');
        $registerUserRequest->password = $request->input('password');
        $registerUserRequest->confirm_password = $request->input('confirm_password');

        if ($group == 'company') {
            //Company
            $registerUserRequest->company_category_id = $request->input('company_category_id');
            $registerUserRequest->employee_number_scale_id = $request->input('employee_number_scale_id');
            $registerUserRequest->name = $request->input('name');
        }

        $registerUserRequest->application_ids = $request->input('application_ids');

        $this->setRequestAuthor($registerUserRequest);

        $response = $this->_userServiceInterface->registerUser($registerUserRequest);
        $userRegistered = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $userRegistered);
    }

    //</editor-fold>
}
