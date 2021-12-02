<?php

namespace App\Http\Controllers\API\v1\HumanResources\Vacancy;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\Degree\DegreeEloquent;
use App\Domains\Commons\Skill\SkillEloquent;
use App\Domains\Commons\VacancyCategory\VacancyCategoryEloquent;
use App\Domains\Commons\VacancyLocation\VacancyLocationEloquent;
use App\Domains\HumanResources\MasterData\AdditionalQuestion\AdditionalQuestionEloquent;
use App\Domains\HumanResources\Vacancy\Contracts\Request\CreateVacancyRequest;
use App\Domains\HumanResources\Vacancy\Contracts\Request\EditVacancyRequest;
use App\Domains\HumanResources\Vacancy\Contracts\VacancyServiceInterface;
use App\Helpers\Common;
use App\Helpers\DateTimeRange;
use App\Helpers\NumericRange;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class VacancyController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_vacancyServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * VacancyController constructor.
     * @param VacancyServiceInterface $vacancyServiceInterface
     */
    public function __construct(VacancyServiceInterface $vacancyServiceInterface)
    {
        $this->_vacancyServiceInterface = $vacancyServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/vacancies",
     *     operationId="getVacancyList",
     *     summary="Get list of vacancy",
     *     tags={"Vacancy"},
     *     description="Get list of vacancy",
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
     *          name="vacancy_location_id",
     *          in="query",
     *          description="Vacation location id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="vacancy_category_id",
     *          in="query",
     *          description="Vacancy category id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_publish_date",
     *          in="query",
     *          description="Start publish date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_publish_date",
     *          in="query",
     *          description="End publish date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_expired_date",
     *          in="query",
     *          description="Start expired date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_expired_date",
     *          in="query",
     *          description="End expired date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="work_status",
     *          in="query",
     *          description="Work status parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"FULL_TIME", "PART_TIME"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="work_type",
     *          in="query",
     *          description="Work type parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"PERMANENT", "CONTRACT"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="query",
     *          description="Status parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"PUBLISH", "DRAFT", "PENDING"},
     *              default=""
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
    public function getVacancyList(Request $request)
    {
        $companyId = $request->get('company_id');
        $vacancyLocationId = $request->get('vacancy_location_id');
        $vacancyCategoryId = $request->get('vacancy_category_id');
        $rangePublishDate = new DateTimeRange($request->get('start_publish_date'), $request->get('end_publish_date'));
        $rangeExpiredDate = new DateTimeRange($request->get('start_expired_date'), $request->get('end_expired_date'));
        $workStatus = $request->get('work_status');
        $workType = $request->get('work_type');
        $status = $request->get('status');

        return $this->getListJson($companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status,
            [$this->_vacancyServiceInterface, 'vacancyList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'vacancyLocation' => Common::isDataExist($entity->vacancyLocation) ? $this->getVacancyLocationObject($entity->vacancyLocation) : null,
                        'vacancyCategory' => Common::isDataExist($entity->vacancyCategory) ? $this->getVacancyCategoryObject($entity->vacancyCategory) : null,
                        'degree' => Common::isDataExist($entity->degree) ? $this->getDegreeObject($entity->degree) : null,
                        'skill' => Common::isDataExist($entity->skill) ? $this->getSkillObject($entity->skill) : null,
                        'additionalQuestion' => Common::isDataExist($entity->additionalQuestion) ? $this->getAdditionalQuestionObject($entity->additionalQuestion) : null,
                        'title' => $entity->title,
                        'slug' => $entity->slug,
                        'publish_date' => $entity->publish_date,
                        'expired_date' => $entity->expired_date,
                        'min_salary' => $entity->min_salary,
                        'max_salary' => $entity->max_salary,
                        'reference_code' => $entity->reference_code,
                        'intro' => $entity->intro,
                        'description' => $entity->description,
                        'requirement' => $entity->requirement,
                        'needs' => $entity->needs,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'status' => $entity->status,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy/list-search",
     *     operationId="postVacancyListSearch",
     *     summary="Get list of vacancy with query search",
     *     tags={"Vacancy"},
     *     description="Get list of vacancy with query search",
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
     *                  @OA\Property(property="company_id", ref="#/components/schemas/VacancyEloquent/properties/company_id"),
     *                  @OA\Property(property="vacancy_location_id", ref="#/components/schemas/VacancyEloquent/properties/vacancy_location_id"),
     *                  @OA\Property(property="vacancy_category_id", ref="#/components/schemas/VacancyEloquent/properties/vacancy_category_id"),
     *                  @OA\Property(
     *                      property="start_publish_date",
     *                      description="Start publish date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_publish_date",
     *                      description="End publish date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_expired_date",
     *                      description="Start expired date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_expired_date",
     *                      description="End expired date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="work_status", ref="#/components/schemas/VacancyEloquent/properties/work_status"),
     *                  @OA\Property(property="work_type", ref="#/components/schemas/VacancyEloquent/properties/work_type"),
     *                  @OA\Property(property="status", ref="#/components/schemas/VacancyEloquent/properties/status"),
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
    public function postVacancyListSearch(Request $request)
    {
        $companyId = $request->get('company_id');
        $vacancyLocationId = $request->get('vacancy_location_id');
        $vacancyCategoryId = $request->get('vacancy_category_id');
        $rangePublishDate = new DateTimeRange($request->get('start_publish_date'), $request->get('end_publish_date'));
        $rangeExpiredDate = new DateTimeRange($request->get('start_expired_date'), $request->get('end_expired_date'));
        $workStatus = $request->get('work_status');
        $workType = $request->get('work_type');
        $status = $request->get('status');

        return $this->getListSearchJson($request, $companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status,
            [$this->_vacancyServiceInterface, 'vacancyListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'vacancyLocation' => Common::isDataExist($entity->vacancyLocation) ? $this->getVacancyLocationObject($entity->vacancyLocation) : null,
                        'vacancyCategory' => Common::isDataExist($entity->vacancyCategory) ? $this->getVacancyCategoryObject($entity->vacancyCategory) : null,
                        'degree' => Common::isDataExist($entity->degree) ? $this->getDegreeObject($entity->degree) : null,
                        'skill' => Common::isDataExist($entity->skill) ? $this->getSkillObject($entity->skill) : null,
                        'additionalQuestion' => Common::isDataExist($entity->additionalQuestion) ? $this->getAdditionalQuestionObject($entity->additionalQuestion) : null,
                        'title' => $entity->title,
                        'slug' => $entity->slug,
                        'publish_date' => $entity->publish_date,
                        'expired_date' => $entity->expired_date,
                        'min_salary' => $entity->min_salary,
                        'max_salary' => $entity->max_salary,
                        'reference_code' => $entity->reference_code,
                        'intro' => $entity->intro,
                        'description' => $entity->description,
                        'requirement' => $entity->requirement,
                        'needs' => $entity->needs,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'status' => $entity->status,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy/page-search",
     *     operationId="postVacancyPageSearch",
     *     summary="Get list of vacancy with query and page parameter search",
     *     tags={"Vacancy"},
     *     description="Get list of vacancy with query and page parameter search",
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
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="query",
     *                              description="Query property (Keyword would be filter note)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/VacancyEloquent/properties/company_id"),
     *                          @OA\Property(property="vacancy_location_id", ref="#/components/schemas/VacancyEloquent/properties/vacancy_location_id"),
     *                          @OA\Property(property="vacancy_category_id", ref="#/components/schemas/VacancyEloquent/properties/vacancy_category_id"),
     *                          @OA\Property(
     *                              property="start_publish_date",
     *                              description="Start publish date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_publish_date",
     *                              description="End publish date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_expired_date",
     *                              description="Start expired date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_expired_date",
     *                              description="End expired date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="work_status", ref="#/components/schemas/VacancyEloquent/properties/work_status"),
     *                          @OA\Property(property="work_type", ref="#/components/schemas/VacancyEloquent/properties/work_type"),
     *                          @OA\Property(property="status", ref="#/components/schemas/VacancyEloquent/properties/status")
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
    public function postVacancyPageSearch(Request $request)
    {
        $companyId = $request->get('company_id');
        $vacancyLocationId = $request->get('vacancy_location_id');
        $vacancyCategoryId = $request->get('vacancy_category_id');
        $rangePublishDate = new DateTimeRange($request->get('start_publish_date'), $request->get('end_publish_date'));
        $rangeExpiredDate = new DateTimeRange($request->get('start_expired_date'), $request->get('end_expired_date'));
        $workStatus = $request->get('work_status');
        $workType = $request->get('work_type');
        $status = $request->get('status');

        return $this->getPagedSearchJson($request, $companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status,
            [$this->_vacancyServiceInterface, 'vacancyPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'vacancyLocation' => Common::isDataExist($entity->vacancyLocation) ? $this->getVacancyLocationObject($entity->vacancyLocation) : null,
                        'vacancyCategory' => Common::isDataExist($entity->vacancyCategory) ? $this->getVacancyCategoryObject($entity->vacancyCategory) : null,
                        'degree' => Common::isDataExist($entity->degree) ? $this->getDegreeObject($entity->degree) : null,
                        'skill' => Common::isDataExist($entity->skill) ? $this->getSkillObject($entity->skill) : null,
                        'additionalQuestion' => Common::isDataExist($entity->additionalQuestion) ? $this->getAdditionalQuestionObject($entity->additionalQuestion) : null,
                        'title' => $entity->title,
                        'slug' => $entity->slug,
                        'publish_date' => $entity->publish_date,
                        'expired_date' => $entity->expired_date,
                        'min_salary' => $entity->min_salary,
                        'max_salary' => $entity->max_salary,
                        'reference_code' => $entity->reference_code,
                        'intro' => $entity->intro,
                        'description' => $entity->description,
                        'requirement' => $entity->requirement,
                        'needs' => $entity->needs,
                        'work_status' => $entity->work_status,
                        'work_type' => $entity->work_type,
                        'status' => $entity->status,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy",
     *     operationId="postVacancyCreate",
     *     summary="Create vacancy",
     *     tags={"Vacancy"},
     *     description="Create vacancy",
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
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/CreateVacancyEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="degree",
     *                              description="Degree",
     *                              type="array",
     *                              @OA\Items(
     *                                  type="integer",
     *                                  format="int64",
     *                                  example=1
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="skill",
     *                              description="Skill",
     *                              type="array",
     *                              @OA\Items(
     *                                  type="integer",
     *                                  format="int64",
     *                                  example=1
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="additional_question",
     *                              description="Additional Question",
     *                              type="array",
     *                              @OA\Items(
     *                                  type="integer",
     *                                  format="int64",
     *                                  example=1
     *                              )
     *                          )
     *                      ),
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
    public function postVacancyCreate(Request $request)
    {
        $createVacancyRequest = new CreateVacancyRequest();

        $createVacancyRequest->company_id = $request->input('company_id');
        $createVacancyRequest->vacancy_location_id = $request->input('vacancy_location_id');
        $createVacancyRequest->vacancy_category_id = $request->input('vacancy_category_id');
        $createVacancyRequest->title = $request->input('title');
        $createVacancyRequest->slug = $request->input('slug');
        $createVacancyRequest->publish_date = $request->input('publish_date');
        $createVacancyRequest->expired_date = $request->input('expired_date');
        $createVacancyRequest->min_salary = $request->input('min_salary');
        $createVacancyRequest->max_salary = $request->input('max_salary');
        $createVacancyRequest->reference_code = $request->input('reference_code');
        $createVacancyRequest->intro = $request->input('intro');
        $createVacancyRequest->description = $request->input('description');
        $createVacancyRequest->requirement = $request->input('requirement');
        $createVacancyRequest->needs = $request->input('needs');
        $createVacancyRequest->work_status = $request->input('work_status');
        $createVacancyRequest->work_type = $request->input('work_type');
        $createVacancyRequest->status = $request->input('status');

        // Has Many
        $createVacancyRequest->degree = $request->degree;
        $createVacancyRequest->skill = $request->skill;
        $createVacancyRequest->additional_question = $request->additional_question;

        $this->setRequestAuthor($createVacancyRequest);

        $vacancy = $this->_vacancyServiceInterface->create($createVacancyRequest);
        $vacancyCreated = $vacancy->getObject();

        if (!$vacancy->isSuccess()) {
            return $this->getBasicErrorJson($vacancy);
        }

        return $this->getBasicSuccessJson($vacancy, $vacancyCreated);
    }

    /**
     * @OA\Put(
     *     path="/vacancy",
     *     operationId="putVacancyUpdate",
     *     summary="Update vacancy",
     *     tags={"Vacancy"},
     *     description="Update vacancy",
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
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/UpdateVacancyEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="degree",
     *                              description="Degree",
     *                              type="array",
     *                              @OA\Items(
     *                                  type="integer",
     *                                  format="int64",
     *                                  example=1
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="skill",
     *                              description="Skill",
     *                              type="array",
     *                              @OA\Items(
     *                                  type="integer",
     *                                  format="int64",
     *                                  example=1
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="additional_question",
     *                              description="Additional Question",
     *                              type="array",
     *                              @OA\Items(
     *                                  type="integer",
     *                                  format="int64",
     *                                  example=1
     *                              )
     *                          )
     *                      ),
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
    public function putVacancyUpdate(Request $request)
    {
        $editVacancyRequest = new EditVacancyRequest();

        $editVacancyRequest->id = $request->input('id');
        $editVacancyRequest->company_id = $request->input('company_id');
        $editVacancyRequest->vacancy_location_id = $request->input('vacancy_location_id');
        $editVacancyRequest->vacancy_category_id = $request->input('vacancy_category_id');
        $editVacancyRequest->title = $request->input('title');
        $editVacancyRequest->slug = $request->input('slug');
        $editVacancyRequest->publish_date = $request->input('publish_date');
        $editVacancyRequest->expired_date = $request->input('expired_date');
        $editVacancyRequest->min_salary = $request->input('min_salary');
        $editVacancyRequest->max_salary = $request->input('max_salary');
        $editVacancyRequest->reference_code = $request->input('reference_code');
        $editVacancyRequest->intro = $request->input('intro');
        $editVacancyRequest->description = $request->input('description');
        $editVacancyRequest->requirement = $request->input('requirement');
        $editVacancyRequest->needs = $request->input('needs');
        $editVacancyRequest->work_status = $request->input('work_status');
        $editVacancyRequest->work_type = $request->input('work_type');
        $editVacancyRequest->status = $request->input('status');

        // Has Many
        $editVacancyRequest->degree = $request->degree;
        $editVacancyRequest->skill = $request->skill;
        $editVacancyRequest->additional_question = $request->additional_question;

        $this->setRequestAuthor($editVacancyRequest);

        $vacancy = $this->_vacancyServiceInterface->update($editVacancyRequest);
        
        $vacancyUpdated = $vacancy->getObject();

        if (!$vacancy->isSuccess()) {
            return $this->getBasicErrorJson($vacancy);
        }

        return $this->getBasicSuccessJson($vacancy, $vacancyUpdated);
    }

    /**
     * @OA\Delete(
     *     path="/vacancy/{id}",
     *     operationId="deleteVacancy",
     *     summary="Delete vacancy",
     *     tags={"Vacancy"},
     *     description="Delete vacancy",
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
    public function deleteVacancy(int $id)
    {
        $vacancy = $this->_vacancyServiceInterface->find($id);

        $result = $vacancy->getObject();

        $response = $this->_vacancyServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/vacancies",
     *     operationId="deleteBulkVacancy",
     *     summary="Delete bulk vacancy",
     *     tags={"Vacancy"},
     *     description="Delete bulk vacancy",
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
    public function deleteBulkVacancy(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_vacancyServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/vacancy/{id}/publish",
     *     operationId="putVacancyPublish",
     *     summary="Set publish vacancy",
     *     tags={"Vacancy"},
     *     description="Set publish vacancy",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putVacancyPublish(int $id){
        $vacancy = $this->_vacancyServiceInterface->find($id);

        $result = $vacancy->getObject();

        $result->status = "PUBLISH";

        $this->setRequestAuthor($result);

        $response = $this->_vacancyServiceInterface->vacancySetPublish($result);
        $vacancyPublished = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $vacancyPublished);
    }

    /**
     * @OA\Put(
     *     path="/vacancy/{id}/draft",
     *     operationId="putVacancyDraft",
     *     summary="Set draft vacancy",
     *     tags={"Vacancy"},
     *     description="Set draft vacancy",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putVacancyDraft(int $id){
        $vacancy = $this->_vacancyServiceInterface->find($id);

        $result = $vacancy->getObject();

        $result->status = "DRAFT";

        $this->setRequestAuthor($result);

        $response = $this->_vacancyServiceInterface->vacancySetDraft($result);
        $vacancyDrafted = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $vacancyDrafted);
    }

    /**
     * @OA\Put(
     *     path="/vacancy/{id}/pending",
     *     operationId="putVacancyPending",
     *     summary="Set pending vacancy",
     *     tags={"Vacancy"},
     *     description="Set pending vacancy",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putVacancyPending(int $id){
        $vacancy = $this->_vacancyServiceInterface->find($id);

        $result = $vacancy->getObject();

        $result->status = "PENDING";

        $this->setRequestAuthor($result);

        $response = $this->_vacancyServiceInterface->vacancySetPending($result);
        $vacancyPending = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $vacancyPending);
    }


    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson($companyId = null, $vacancyLocationId = null, $vacancyCategoryId = null, $rangePublishDate = null, $rangeExpiredDate = null, $workStatus = null, $workType = null, $status = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, $companyId = null, $vacancyLocationId = null, $vacancyCategoryId = null, $rangePublishDate = null, $rangeExpiredDate = null, $workStatus = null, $workType = null, $status = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status);
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
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @param callable $searchMethod
     * @param callable $dtoPageSearchToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, $companyId = null, $vacancyLocationId = null, $vacancyCategoryId = null, $rangePublishDate = null, $rangeExpiredDate = null, $workStatus = null, $workType = null, $status = null,
                                        callable $searchMethod,
                                        callable $dtoPageSearchToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $vacancyLocationId, $vacancyCategoryId, $rangePublishDate, $rangeExpiredDate, $workStatus, $workType, $status);
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
     * @param CompanyEloquent $entity
     * @return Collection
     */
    private function getCompanyObject(CompanyEloquent $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param VacancyLocationEloquent $entity
     * @return Collection
     */
    private function getVacancyLocationObject(VacancyLocationEloquent $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param VacancyCategoryEloquent $entity
     * @return Collection
     */
    private function getVacancyCategoryObject(VacancyCategoryEloquent $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param Collection $entities
     * @return Collection
     */
    private function getDegreeObject(Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $rowJsonData->push([
                'id' => $entity->id,
                'name' => $entity->name
            ]);
        }

        return $rowJsonData;
    }

    /**
     * @param Collection $entities
     * @return Collection
     */
    private function getSkillObject(Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $rowJsonData->push([
                'id' => $entity->id,
                'name' => $entity->name
            ]);
        }

        return $rowJsonData;
    }

    /**
     * @param Collection $entities
     * @return Collection
     */
    private function getAdditionalQuestionObject(Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $rowJsonData->push([
                'id' => $entity->id,
                'question' => $entity->question
            ]);
        }

        return $rowJsonData;
    }

    //</editor-fold>
}
