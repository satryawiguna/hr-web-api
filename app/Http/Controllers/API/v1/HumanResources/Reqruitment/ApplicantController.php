<?php

namespace App\Http\Controllers\API\v1\HumanResources\Reqruitment;

use App\Domains\HumanResources\Recruitment\Applicant\Contracts\ApplicantServiceInterface;
use App\Domains\Commons\Gender\GenderEloquent;
use App\Domains\Commons\MaritalStatus\MaritalStatusEloquent;
use App\Domains\Commons\Religion\ReligionEloquent;
use App\Domains\User\Profile\ProfileEloquent;;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Helpers\DateTimeRange;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_applicantServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * ApplicantController constructor.
     * @param ApplicantServiceInterface $applicantServiceInterface
     */
    public function __construct(ApplicantServiceInterface $applicantServiceInterface)
    {
        $this->_applicantServiceInterface = $applicantServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/applicant",
     *     operationId="getApplicantList",
     *     summary="Get list of applicant",
     *     tags={"Applicant"},
     *     description="Get list of applicant",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="profile_id",
     *          in="query",
     *          description="Profile id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="gender_id",
     *          in="query",
     *          description="Gender id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="religion_id",
     *          in="query",
     *          description="Religion id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="marital_status_id",
     *          in="query",
     *          description="Marital status id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_birth_date",
     *          in="query",
     *          description="Start birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_birth_date",
     *          in="query",
     *          description="End birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_passport_expired_date",
     *          in="query",
     *          description="Start passport expired date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_passport_expired_date",
     *          in="query",
     *          description="End passport expired date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_visa_expired_date",
     *          in="query",
     *          description="Start visa expired date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_visa_expired_date",
     *          in="query",
     *          description="End visa expired date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
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
    public function getApplicantList(Request $request)
    {
        $profileId = $request->get('profile_id');
        $genderId = $request->get('gender_id');
        $religionId = $request->get('religion_id');
        $maritalStatusId = $request->get('marital_status_id');

        // $rangeBirthDate = $request->get('range_birth_date');
        // $rangePassportExpiredDate = $request->get('range_passport_expired_date');
        // $rangeVisaExpiredDate = $request->get('range_visa_expired_date');

        $rangeBirthDate = new DateTimeRange($request->get('start_birth_date'), $request->get('end_birth_date'));
        $rangePassportExpiredDate = new DateTimeRange($request->get('start_passport_expired_date'), $request->get('end_passport_expired_date'));
        $rangeVisaExpiredDate = new DateTimeRange($request->get('start_visa_expired_date'), $request->get('end_visa_expired_date'));

        return $this->getListJson($profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate,
            [$this->_applicantServiceInterface, 'applicantList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'profile' => Common::isDataExist($entity->profile) ? $this->getListSearchJsonProfile($entity->profile) : null,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getListSearchJsonGender($entity->gender) : null,
                        'religion' => Common::isDataExist($entity->religion) ? $this->getListSearchJsonReligion($entity->religion) : null,
                        'marital_status' => Common::isDataExist($entity->maritalStatus) ? $this->getListSearchJsonMaritalStatus($entity->maritalStatus) : null,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'passport_number' => $entity->passport_number,
                        'passport_expired_date' => $entity->passport_expired_date,
                        'visa_number' => $entity->visa_number,
                        'visa_expired_date' => $entity->visa_expired_date,
                        'birth_date' => $entity->birth_date,
                        'birth_place' => $entity->birth_place,
                        'age' => $entity->age,
                        'weight' => $entity->weight,
                        'height' => $entity->height,
                        'linkedin' => $entity->linkedin,
                        'facebook' => $entity->facebook,
                        'instagram' => $entity->instagram,
                        'skype' => $entity->skype,
                        'website' => $entity->website,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/applicant/list-search",
     *     operationId="postApplicantListSearch",
     *     summary="Get list of applicant with query search",
     *     tags={"Applicant"},
     *     description="Get list of applicant with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter identity_number, identity_address, passport_number, visa_number, and birth_place)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="profile_id", ref="#/components/schemas/ApplicantEloquent/properties/profile_id"),
     *                  @OA\Property(property="gender_id", ref="#/components/schemas/ApplicantEloquent/properties/gender_id"),
     *                  @OA\Property(property="religion_id", ref="#/components/schemas/ApplicantEloquent/properties/religion_id"),
     *                  @OA\Property(property="marital_status_id", ref="#/components/schemas/ApplicantEloquent/properties/marital_status_id"),
     *                  @OA\Property(
     *                      property="start_birth_date",
     *                      description="Start birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_birth_date",
     *                      description="End birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_passport_expired_date",
     *                      description="Start passport expired date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_passport_expired_date",
     *                      description="End passport expired date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_visa_expired_date",
     *                      description="Start visa expired date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_visa_expired_date",
     *                      description="End visa expired date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function postApplicantListSearch(Request $request)
    {
        $profileId = $request->input('profile_id');
        $genderId = $request->input('gender_id');
        $religionId = $request->input('religion_id');
        $maritalStatusId = $request->input('marital_status_id');
        
        // $rangeBirthDate = $request->input('range_birth_date');
        // $rangePassportExpiredDate = $request->input('range_passport_expired_date');
        // $rangeVisaExpiredDate = $request->input('range_visa_expired_date');
        
        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));
        $rangePassportExpiredDate = new DateTimeRange($request->input('start_passport_expired_date'), $request->input('end_passport_expired_date'));
        $rangeVisaExpiredDate = new DateTimeRange($request->input('start_visa_expired_date'), $request->input('end_visa_expired_date'));

        return $this->getListSearchJson($request, $profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate,
            [$this->_applicantServiceInterface, 'applicantListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'profile' => Common::isDataExist($entity->profile) ? $this->getListSearchJsonProfile($entity->profile) : null,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getListSearchJsonGender($entity->gender) : null,
                        'religion' => Common::isDataExist($entity->religion) ? $this->getListSearchJsonReligion($entity->religion) : null,
                        'marital_status' => Common::isDataExist($entity->maritalStatus) ? $this->getListSearchJsonMaritalStatus($entity->maritalStatus) : null,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'passport_number' => $entity->passport_number,
                        'passport_expired_date' => $entity->passport_expired_date,
                        'visa_number' => $entity->visa_number,
                        'visa_expired_date' => $entity->visa_expired_date,
                        'birth_date' => $entity->birth_date,
                        'birth_place' => $entity->birth_place,
                        'age' => $entity->age,
                        'weight' => $entity->weight,
                        'height' => $entity->height,
                        'linkedin' => $entity->linkedin,
                        'facebook' => $entity->facebook,
                        'instagram' => $entity->instagram,
                        'skype' => $entity->skype,
                        'website' => $entity->website,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/applicant/page-search",
     *     operationId="postApplicantPageSearch",
     *     summary="Get list of applicant with query and page parameter search",
     *     tags={"Applicant"},
     *     description="Get list of applicant with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter identity_number, identity_address, passport_number, visa_number, and birth_place)",
     *                              type="string",
     *                              example="keyword"
     *                          ),
     *                          @OA\Property(property="profile_id", ref="#/components/schemas/ApplicantEloquent/properties/profile_id"),
     *                          @OA\Property(property="gender_id", ref="#/components/schemas/ApplicantEloquent/properties/gender_id"),
     *                          @OA\Property(property="religion_id", ref="#/components/schemas/ApplicantEloquent/properties/religion_id"),
     *                          @OA\Property(property="marital_status_id", ref="#/components/schemas/ApplicantEloquent/properties/marital_status_id"),
     *                          @OA\Property(
     *                              property="start_birth_date",
     *                              description="Start birth date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_birth_date",
     *                              description="End birth date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_passport_expired_date",
     *                              description="Start passport expired date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_passport_expired_date",
     *                              description="End passport expired date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_visa_expired_date",
     *                              description="Start visa expired date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_visa_expired_date",
     *                              description="End visa expired date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
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
    public function postApplicantPageSearch(Request $request)
    {
        $profileId = $request->input('profile_id');
        $genderId = $request->input('gender_id');
        $religionId = $request->input('religion_id');
        $maritalStatusId = $request->input('marital_status_id');
        
        // $rangeBirthDate = $request->input('range_birth_date');
        // $rangePassportExpiredDate = $request->input('range_passport_expired_date');
        // $rangeVisaExpiredDate = $request->input('range_visa_expired_date');
        
        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));
        $rangePassportExpiredDate = new DateTimeRange($request->input('start_passport_expired_date'), $request->input('end_passport_expired_date'));
        $rangeVisaExpiredDate = new DateTimeRange($request->input('start_visa_expired_date'), $request->input('end_visa_expired_date'));

        return $this->getPagedSearchJson($request, $profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate,
            [$this->_applicantServiceInterface, 'applicantPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'profile' => Common::isDataExist($entity->profile) ? $this->getListSearchJsonProfile($entity->profile) : null,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getListSearchJsonGender($entity->gender) : null,
                        'religion' => Common::isDataExist($entity->religion) ? $this->getListSearchJsonReligion($entity->religion) : null,
                        'marital_status' => Common::isDataExist($entity->maritalStatus) ? $this->getListSearchJsonMaritalStatus($entity->maritalStatus) : null,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'passport_number' => $entity->passport_number,
                        'passport_expired_date' => $entity->passport_expired_date,
                        'visa_number' => $entity->visa_number,
                        'visa_expired_date' => $entity->visa_expired_date,
                        'birth_date' => $entity->birth_date,
                        'birth_place' => $entity->birth_place,
                        'age' => $entity->age,
                        'weight' => $entity->weight,
                        'height' => $entity->height,
                        'linkedin' => $entity->linkedin,
                        'facebook' => $entity->facebook,
                        'instagram' => $entity->instagram,
                        'skype' => $entity->skype,
                        'website' => $entity->website,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }


    /**
     * @OA\Get(
     *     path="/applicant/{id}",
     *     operationId="getApplicantDetail",
     *     summary="Get detail applicant",
     *     tags={"Applicant"},
     *     description="Get detail applicant",
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
    public function getApplicantDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_applicantServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'profile' => Common::isDataExist($entity->profile) ? $this->getListSearchJsonProfile($entity->profile) : null,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getListSearchJsonGender($entity->gender) : null,
                        'religion' => Common::isDataExist($entity->religion) ? $this->getListSearchJsonReligion($entity->religion) : null,
                        'marital_status' => Common::isDataExist($entity->maritalStatus) ? $this->getListSearchJsonMaritalStatus($entity->maritalStatus) : null,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'passport_number' => $entity->passport_number,
                        'passport_expired_date' => $entity->passport_expired_date,
                        'visa_number' => $entity->visa_number,
                        'visa_expired_date' => $entity->visa_expired_date,
                        'birth_date' => $entity->birth_date,
                        'birth_place' => $entity->birth_place,
                        'age' => $entity->age,
                        'weight' => $entity->weight,
                        'height' => $entity->height,
                        'linkedin' => $entity->linkedin,
                        'facebook' => $entity->facebook,
                        'instagram' => $entity->instagram,
                        'skype' => $entity->skype,
                        'website' => $entity->website,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/applicant/create",
     *     operationId="postApplicantCreate",
     *     summary="Create applicant",
     *     tags={"Applicant"},
     *     description="Create applicant",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateApplicantEloquent")
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
    public function postApplicantCreate(Request $request)
    {
        $applicant = $this->_applicantServiceInterface->newInstance();

        $applicant->gender_id = $request->input('gender_id');
        $applicant->religion_id = $request->input('religion_id');
        $applicant->marital_status_id = $request->input('marital_status_id');
        $applicant->identity_number = $request->input('identity_number');
        $applicant->identity_expired_date = $request->input('identity_expired_date');
        $applicant->identity_address = $request->input('identity_address');
        $applicant->passport_number = $request->input('passport_number');
        $applicant->passport_expired_date = $request->input('passport_expired_date');
        $applicant->visa_number = $request->input('visa_number');
        $applicant->visa_expired_date = $request->input('visa_expired_date');
        $applicant->birth_date = $request->input('birth_date');
        $applicant->birth_place = $request->input('birth_place');
        $applicant->age = $request->input('age');
        $applicant->weight = $request->input('weight');
        $applicant->height = $request->input('height');
        $applicant->linkedin = $request->input('linkedin');
        $applicant->facebook = $request->input('facebook');
        $applicant->instagram = $request->input('instagram');
        $applicant->skype = $request->input('skype');
        $applicant->website = $request->input('website');

        $this->setRequestAuthor($applicant);

        $response = $this->_applicantServiceInterface->create($applicant);
        $applicantCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $applicantCreated);
    }

    /**
     * @OA\Put(
     *     path="/applicant/update",
     *     operationId="putApplicantUpdate",
     *     summary="Update applicant",
     *     tags={"Applicant"},
     *     description="Update applicant",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateApplicantEloquent")
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function putApplicantUpdate(Request $request)
    {
        $applicant = $this->_applicantServiceInterface->find($request->input('id'));

        $result = $applicant->getObject();

        $result->gender_id = $request->input('gender_id');
        $result->religion_id = $request->input('religion_id');
        $result->marital_status_id = $request->input('marital_status_id');
        $result->identity_number = $request->input('identity_number');
        $result->identity_expired_date = $request->input('identity_expired_date');
        $result->identity_address = $request->input('identity_address');
        $result->passport_number = $request->input('passport_number');
        $result->passport_expired_date = $request->input('passport_expired_date');
        $result->visa_number = $request->input('visa_number');
        $result->visa_expired_date = $request->input('visa_expired_date');
        $result->birth_date = $request->input('birth_date');
        $result->birth_place = $request->input('birth_place');
        $result->age = $request->input('age');
        $result->weight = $request->input('weight');
        $result->height = $request->input('height');
        $result->linkedin = $request->input('linkedin');
        $result->facebook = $request->input('facebook');
        $result->instagram = $request->input('instagram');
        $result->skype = $request->input('skype');
        $result->website = $request->input('website');

        $this->setRequestAuthor($result);

        $response = $this->_applicantServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

        /**
     * @OA\Get(
     *     path="/user/applicant",
     *     operationId="getApplicantUser",
     *     summary="Get user applicant",
     *     tags={"Applicant"},
     *     description="Get user applicant",
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
    public function getApplicantUser()
    {
        return $this->getDetailObjectJson(Auth::user()->profile->applicant->id,
            [$this->_applicantServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'profile' => Common::isDataExist($entity->profile) ? $this->getListSearchJsonProfile($entity->profile) : null,
                        'gender' => Common::isDataExist($entity->gender) ? $this->getListSearchJsonGender($entity->gender) : null,
                        'religion' => Common::isDataExist($entity->religion) ? $this->getListSearchJsonReligion($entity->religion) : null,
                        'marital_status' => Common::isDataExist($entity->maritalStatus) ? $this->getListSearchJsonMaritalStatus($entity->maritalStatus) : null,
                        'identity_number' => $entity->identity_number,
                        'identity_expired_date' => $entity->identity_expired_date,
                        'identity_address' => $entity->identity_address,
                        'passport_number' => $entity->passport_number,
                        'passport_expired_date' => $entity->passport_expired_date,
                        'visa_number' => $entity->visa_number,
                        'visa_expired_date' => $entity->visa_expired_date,
                        'birth_date' => $entity->birth_date,
                        'birth_place' => $entity->birth_place,
                        'age' => $entity->age,
                        'weight' => $entity->weight,
                        'height' => $entity->height,
                        'linkedin' => $entity->linkedin,
                        'facebook' => $entity->facebook,
                        'instagram' => $entity->instagram,
                        'skype' => $entity->skype,
                        'website' => $entity->website,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Delete(
     *     path="/applicant/{id}",
     *     operationId="postApplicantDelete",
     *     summary="Delete applicant",
     *     tags={"Applicant"},
     *     description="Delete applicant",
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
    public function postApplicantDelete(int $id)
    {
        $applicant = $this->_applicantServiceInterface->find($id);

        $result = $applicant->getObject();

        $response = $this->_applicantServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
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

    /**
     * @param null $profileId
     * @param null $genderId
     * @param null $religionId
     * @param null $maritalStatusId
     * @param null $rangeBirthDate
     * @param null $rangePassportExpiredDate
     * @param null $rangeVisaExpiredDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson($profileId = null, $genderId = null, $religionId = null, $maritalStatusId = null, $rangeBirthDate = null, $rangePassportExpiredDate = null, $rangeVisaExpiredDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        $jsonData = response()->json([
            'rows' => $rowJsonData
        ]);

        return $jsonData;
    }

    /**
     * @param Request $request
     * @param null $profileId
     * @param null $genderId
     * @param null $religionId
     * @param null $maritalStatusId
     * @param null $rangeBirthDate
     * @param null $rangePassportExpiredDate
     * @param null $rangeVisaExpiredDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, $profileId = null, $genderId = null, $religionId = null, $maritalStatusId = null, $rangeBirthDate = null, $rangePassportExpiredDate = null, $rangeVisaExpiredDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate);
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
     * @param null $profileId
     * @param null $genderId
     * @param null $religionId
     * @param null $maritalStatusId
     * @param null $rangeBirthDate
     * @param null $rangePassportExpiredDate
     * @param null $rangeVisaExpiredDate
     * @param callable $searchMethod
     * @param callable $dtoPageSearchToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, $profileId = null, $genderId = null, $religionId = null, $maritalStatusId = null, $rangeBirthDate= null, $rangePassportExpiredDate = null, $rangeVisaExpiredDate = null,
                                        callable $searchMethod,
                                        callable $dtoPageSearchToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $profileId, $genderId, $religionId, $maritalStatusId, $rangeBirthDate, $rangePassportExpiredDate, $rangeVisaExpiredDate);
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
     * @param ProfileEloquent $entity
     * @return Collection
     */
    private function getListSearchJsonProfile(ProfileEloquent $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'full_name' => $entity->full_name
        ]);

        return $rowJsonData;
    }

    /**
     * @param GenderEloquent $entity
     * @return Collection
     */
    private function getListSearchJsonGender(GenderEloquent $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param ReligionEloquent $entity
     * @return Collection
     */
    private function getListSearchJsonReligion(ReligionEloquent $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param MaritalStatusEloquent $entity
     * @return Collection
     */
    private function getListSearchJsonMaritalStatus(MaritalStatusEloquent $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
