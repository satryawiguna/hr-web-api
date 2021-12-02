<?php

namespace App\Http\Controllers\API\v1;

use App\Domains\User\Profile\Contracts\ProfileServiceInterface;
use App\Domains\User\Profile\Contracts\Request\EditProfileRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_profileServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * ProfileController constructor.
     * @param ProfileServiceInterface $profileServiceInterface
     */
    public function __construct(ProfileServiceInterface $profileServiceInterface)
    {
        $this->_profileServiceInterface = $profileServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Post(
     *     path="/profile/create",
     *     operationId="postProfileCreate",
     *     summary="Create profile",
     *     tags={"Profile"},
     *     description="Create profile",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateProfileEloquent"),
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="media_libraries",
     *                      description="Media library property",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(
     *                              property="media_library_id",
     *                              description="Media library id property",
     *                              type="string",
     *                              example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *                          ),
     *                          @OA\Property(
     *                              property="pivot",
     *                              description="Pivot property",
     *                              @OA\Property(
     *                                  property="attribute",
     *                                  type="string",
     *                                  example="photo"
     *                              )
     *                          )
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
     * @return mixed
     */
    public function postProfileCreate(Request $request)
    {
        $profile = $this->_profileServiceInterface->newInstance();

        $profile->id = $request->input('id');
        $profile->full_name = $request->input('full_name');
        $profile->nick_name = $request->input('nick_name');
        $profile->country = $request->input('country');
        $profile->state_or_province = $request->input('state_or_province');
        $profile->city = $request->input('city');
        $profile->address = $request->input('address');
        $profile->postcode = $request->input('postcode');
        $profile->phone = $request->input('phone');
        $profile->mobile = $request->input('mobile');
        $profile->email = $request->input('email');
        $profile->media_libraries = $request->input('media_libraries');

        $this->setRequestAuthor($profile);

        $response = $this->_profileServiceInterface->create($profile);
        $profileCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $profileCreated);
    }
    
    /**
     * @OA\Put(
     *     path="/profile/update",
     *     operationId="putProfileUpdate",
     *     summary="Update profile",
     *     tags={"Profile"},
     *     description="Update profile",
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
     *                      @OA\Schema(ref="#/components/schemas/UpdateProfileEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="media_libraries",
     *                              description="Media library property",
     *                              type="array",
     *                              @OA\Items(
     *                                  @OA\Property(
     *                                      property="media_library_id",
     *                                      description="Media library id property",
     *                                      type="string",
     *                                      example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="pivot",
     *                                      description="Pivot property",
     *                                      @OA\Property(
     *                                          property="attribute",
     *                                          type="string",
     *                                          example="photo"
     *                                      )
     *                                  )
     *                              )
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
    public function putProfileUpdate(Request $request)
    {
        $editProfileRequest = new EditProfileRequest();
        $editProfileRequest->id = $request->input('id');
        $editProfileRequest->full_name = $request->input('full_name');
        $editProfileRequest->nick_name = $request->input('nick_name');
        $editProfileRequest->country = $request->input('country');
        $editProfileRequest->state_or_province = $request->input('state_or_province');
        $editProfileRequest->city = $request->input('city');
        $editProfileRequest->address = $request->input('address');
        $editProfileRequest->postcode = $request->input('postcode');
        $editProfileRequest->phone = $request->input('phone');
        $editProfileRequest->mobile = $request->input('mobile');
        $editProfileRequest->email = $request->input('email');
        $editProfileRequest->media_libraries = $request->input('media_libraries');

        $this->setRequestAuthor($editProfileRequest);

        $response = $this->_profileServiceInterface->update($editProfileRequest);
        $profileUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $profileUpdated);
    }

    /**
     * @OA\Get(
     *     path="/profile/detail/{id}",
     *     operationId="getProfileDetail",
     *     summary="Get detail profile",
     *     tags={"Profile"},
     *     description="Get detail profile",
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
     *              example="1"
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
    public function getProfileDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_profileServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'mobile' => $entity->mobile,
                        'email' => $entity->email,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Get(
     *     path="/profile/user/",
     *     operationId="getProfileUser",
     *     summary="Get user profile",
     *     tags={"Profile"},
     *     description="Get user profile",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfileUser()
    {
        return $this->getDetailObjectJson(Auth::user()->id,
            [$this->_profileServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'mobile' => $entity->mobile,
                        'email' => $entity->email,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Delete(
     *     path="/profile/delete/{id}",
     *     operationId="postProfileDelete",
     *     summary="Delete profile",
     *     tags={"Profile"},
     *     description="Delete profile",
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
    public function postProfileDelete(int $id)
    {
        $profile = $this->_profileServiceInterface->find($id);

        $result = $profile->getObject();

        $response = $this->_profileServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param int $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
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

    //</editor-fold>
}
