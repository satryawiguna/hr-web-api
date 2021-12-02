<?php

namespace App\Http\Controllers\API\v1\HumanResources\Reqruitment;

use App\Core\Services\Response\BooleanResponse;
use App\Domains\HumanResources\Recruitment\Applicant\Contracts\ApplicantInterface;
use App\Domains\HumanResources\Vacancy\Contracts\VacancyInterface;
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts\VacancyApplicantServiceInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeServiceInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts\VacancyApplicationNoteServiceInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\Request\CreateEmployeeRequest;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use DateTime;

class VacancyApplicantController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_vacancyApplicantServiceInterface;

    private $_employeeServiceInterface;

    private $_vacancyApplicationNoteServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * VacancyApplicantController constructor.
     * @param VacancyApplicantServiceInterface $vacancyApplicantServiceInterface
     * @param EmployeeServiceInterface $employeeServiceInterface
     */
    public function __construct(VacancyApplicantServiceInterface $vacancyApplicantServiceInterface, EmployeeServiceInterface $employeeServiceInterface, VacancyApplicationNoteServiceInterface $vacancyApplicationNoteServiceInterface)
    {
        $this->_vacancyApplicantServiceInterface = $vacancyApplicantServiceInterface;

        $this->_employeeServiceInterface = $employeeServiceInterface;

        $this->_vacancyApplicationNoteServiceInterface = $vacancyApplicationNoteServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/vacancy-applicants",
     *     operationId="getVacancyApplicantList",
     *     summary="Get list of vacancy applicant",
     *     tags={"Vacancy Applicant"},
     *     description="Get list of vacancy applicant",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="applicant_id",
     *          in="query",
     *          description="Applicant id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="vacancy_id",
     *          in="query",
     *          description="Vacancy id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="recruitment_stage_id",
     *          in="query",
     *          description="Recruitment stage id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="rating",
     *          in="query",
     *          description="Rating parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"1", "2", "3", "4", "5"},
     *              default="1"
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
    public function getVacancyApplicantList(Request $request)
    {
        $applicant_id = $request->get('applicant_id');
        $vacancy_id = $request->get('vacancy_id');
        $recruitment_stage_id = $request->get('recruitment_stage_id');
        $rating = $request->get('rating');

        return $this->getListJson($applicant_id, $vacancy_id, $recruitment_stage_id, $rating,
            [$this->_vacancyApplicantServiceInterface, 'vacancyApplicantList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'applicant' => Common::isDataExist($entity->applicant) ? $this->getApplicantObject($entity->applicant) : null,
                        'vacancy' => Common::isDataExist($entity->vacancy) ? $this->getVacancyObject($entity->vacancy) : null,
                        'recruitment_stage' => Common::isDataExist($entity->recruitment_stage) ? $this->getRecruitmentStageObject($entity->recruitment_stage) : null,
                        'cover_letter' => $entity->cover_letter,
                        'rating' => $entity->rating
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy-applicants/list-search",
     *     operationId="postVacancyApplicantListSearch",
     *     summary="Get list of vacancy applicant with query search",
     *     tags={"Vacancy Applicant"},
     *     description="Get list of vacancy applicant with query search",
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
     *                      description="Query property (Keyword would be filter cover letter)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="applicant_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/applicant_id"),
     *                  @OA\Property(property="vacancy_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/vacancy_id"),
     *                  @OA\Property(property="recruitment_stage_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/recruitment_stage_id"),
     *                  @OA\Property(property="rating", ref="#/components/schemas/VacancyApplicantEloquent/properties/rating")
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
    public function postVacancyApplicantListSearch(Request $request)
    {
        $applicant_id = $request->get('applicant_id');
        $vacancy_id = $request->get('vacancy_id');
        $recruitment_stage_id = $request->get('recruitment_stage_id');
        $rating = $request->get('rating');

        return $this->getListSearchJson($request, $applicant_id, $vacancy_id, $recruitment_stage_id, $rating,
            [$this->_vacancyApplicantServiceInterface, 'vacancyApplicantListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'applicant' => Common::isDataExist($entity->applicant) ? $this->getApplicantObject($entity->applicant) : null,
                        'vacancy' => Common::isDataExist($entity->vacancy) ? $this->getVacancyObject($entity->vacancy) : null,
                        'recruitment_stage' => Common::isDataExist($entity->recruitment_stage) ? $this->getRecruitmentStageObject($entity->recruitment_stage) : null,
                        'cover_letter' => $entity->cover_letter,
                        'rating' => $entity->rating
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy-applicants/page-search",
     *     operationId="postVacancyApplicantPageSearch",
     *     summary="Get list of vacancy applicant with query and page parameter search",
     *     tags={"Vacancy Applicant"},
     *     description="Get list of vacancy applicant with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter cover letter)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="applicant_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/applicant_id"),
     *                          @OA\Property(property="vacancy_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/vacancy_id"),
     *                          @OA\Property(property="recruitment_stage_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/recruitment_stage_id"),
     *                          @OA\Property(property="rating", ref="#/components/schemas/VacancyApplicantEloquent/properties/rating"),
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
    public function postVacancyApplicantPageSearch(Request $request)
    {
        $applicant_id = $request->get('applicant_id');
        $vacancy_id = $request->get('vacancy_id');
        $recruitment_stage_id = $request->get('recruitment_stage_id');
        $rating = $request->get('rating');

        return $this->getPagedSearchJson($request, $applicant_id, $vacancy_id, $recruitment_stage_id, $rating,
            [$this->_vacancyApplicantServiceInterface, 'vacancyApplicantPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'applicant' => Common::isDataExist($entity->applicant) ? $this->getApplicantObject($entity->applicant) : null,
                        'vacancy' => Common::isDataExist($entity->vacancy) ? $this->getVacancyObject($entity->vacancy) : null,
                        'recruitment_stage' => Common::isDataExist($entity->recruitment_stage) ? $this->getRecruitmentStageObject($entity->recruitment_stage) : null,
                        'cover_letter' => $entity->cover_letter,
                        'rating' => $entity->rating
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy-applicant",
     *     operationId="postVacancyApplicantCreate",
     *     summary="Create vacancy applicant",
     *     tags={"Vacancy Applicant"},
     *     description="Create vacancy applicant",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateVacancyApplicantEloquent")
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
    public function postVacancyApplicantCreate(Request $request)
    {
        $vacancyApplicant = $this->_vacancyApplicantServiceInterface->newInstance();

        $vacancyApplicant->applicant_id = $request->input('applicant_id');
        $vacancyApplicant->vacancy_id = $request->input('vacancy_id');
        $vacancyApplicant->recruitment_stage_id = $request->input('recruitment_stage_id');
        $vacancyApplicant->cover_letter = $request->input('cover_letter');
        $vacancyApplicant->rating = $request->input('rating');

        $response = $this->_vacancyApplicantServiceInterface->create($vacancyApplicant);
        $vacancyApplicantCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $vacancyApplicantCreated);
    }

    /**
     * @OA\Put(
     *     path="/vacancy-applicant/{id}/status",
     *     operationId="putVacancyApplicantUpdateStatus",
     *     summary="Update status vacancy applicant",
     *     tags={"Vacancy Applicant"},
     *     description="Update status vacancy applicant",
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
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                       property="recruitment_stage_id",
     *                       type="integer",
     *                       format="int64",
     *                       description="Recruitment stage id property",
     *                       example=1
     *                  )
     *              ),
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
    public function putVacancyApplicantUpdateStatus(Request $request, int $id)
    {
        $vacancyApplicant = $this->_vacancyApplicantServiceInterface->find($id);

        $result = $vacancyApplicant->getObject();

        $result->recruitment_stage_id = $request->input('recruitment_stage_id');

        $this->setRequestAuthor($result);

        $response = $this->_vacancyApplicantServiceInterface->updateStatus($result);
        $vacancyApplicantUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $vacancyApplicantUpdated);
    }

    /**
     * @OA\Put(
     *     path="/vacancy-applicant/{id}/on-board",
     *     operationId="jobOnBoardVacancyApplicant",
     *     summary="Update job on board vacancy applicant",
     *     tags={"Vacancy Applicant"},
     *     description="Update job on board vacancy applicant",
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
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(property="nip", ref="#/components/schemas/EmployeeEloquent/properties/nip"),
     *                          @OA\Property(property="has_drive_license_a", ref="#/components/schemas/EmployeeEloquent/properties/has_drive_license_a"),
     *                          @OA\Property(property="drive_license_a_number", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_a_number"),
     *                          @OA\Property(property="drive_license_a_date", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_a_date"),
     *                          @OA\Property(property="has_drive_license_b", ref="#/components/schemas/EmployeeEloquent/properties/has_drive_license_b"),
     *                          @OA\Property(property="drive_license_b_number", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_b_number"),
     *                          @OA\Property(property="drive_license_b_date", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_b_date"),
     *                          @OA\Property(property="has_drive_license_c", ref="#/components/schemas/EmployeeEloquent/properties/has_drive_license_c"),
     *                          @OA\Property(property="drive_license_c_number", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_c_number"),
     *                          @OA\Property(property="drive_license_c_date", ref="#/components/schemas/EmployeeEloquent/properties/drive_license_c_date"),
     *                          @OA\Property(property="marital_status_id", ref="#/components/schemas/EmployeeEloquent/properties/marital_status_id"),
     *                          @OA\Property(property="mate_full_name", ref="#/components/schemas/EmployeeEloquent/properties/mate_full_name"),
     *                          @OA\Property(property="mate_nick_name", ref="#/components/schemas/EmployeeEloquent/properties/mate_nick_name"),
     *                          @OA\Property(property="mate_birth_place", ref="#/components/schemas/EmployeeEloquent/properties/mate_birth_place"),
     *                          @OA\Property(property="mate_birth_date", ref="#/components/schemas/EmployeeEloquent/properties/mate_birth_date"),
     *                          @OA\Property(property="mate_occupation", ref="#/components/schemas/EmployeeEloquent/properties/mate_occupation"),
     *                          @OA\Property(property="office_id", ref="#/components/schemas/EmployeeEloquent/properties/office_id"),
     *                          @OA\Property(property="work_area_id", ref="#/components/schemas/EmployeeEloquent/properties/work_area_id"),
     *                          @OA\Property(property="has_npwp", ref="#/components/schemas/EmployeeEloquent/properties/has_npwp"),
     *                          @OA\Property(property="npwp_number", ref="#/components/schemas/EmployeeEloquent/properties/npwp_number"),
     *                          @OA\Property(property="npwp_date", ref="#/components/schemas/EmployeeEloquent/properties/npwp_date"),
     *                          @OA\Property(property="npwp_status", ref="#/components/schemas/EmployeeEloquent/properties/npwp_status"),
     *                          @OA\Property(property="has_bpjs_tenaga_kerja", ref="#/components/schemas/EmployeeEloquent/properties/has_bpjs_tenaga_kerja"),
     *                          @OA\Property(property="bpjs_tenaga_kerja_number", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_number"),
     *                          @OA\Property(property="bpjs_tenaga_kerja_date", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_date"),
     *                          @OA\Property(property="bpjs_tenaga_kerja_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_tenaga_kerja_class"),
     *                          @OA\Property(property="has_bpjs_kesehatan", ref="#/components/schemas/EmployeeEloquent/properties/has_bpjs_kesehatan"),
     *                          @OA\Property(property="bpjs_kesehatan_number", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_number"),
     *                          @OA\Property(property="bpjs_kesehatan_date", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_date"),
     *                          @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/bpjs_kesehatan_class"),
     *                          @OA\Property(property="has_mate_bpjs_kesehatan", ref="#/components/schemas/EmployeeEloquent/properties/has_mate_bpjs_kesehatan"),
     *                          @OA\Property(property="mate_bpjs_kesehatan_number", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_number"),
     *                          @OA\Property(property="mate_bpjs_kesehatan_date", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_date"),
     *                          @OA\Property(property="mate_bpjs_kesehatan_class", ref="#/components/schemas/EmployeeEloquent/properties/mate_bpjs_kesehatan_class"),
     *                          @OA\Property(property="dplk_number", ref="#/components/schemas/EmployeeEloquent/properties/dplk_number"),
     *                          @OA\Property(property="collective_number", ref="#/components/schemas/EmployeeEloquent/properties/collective_number"),
     *                          @OA\Property(property="english_ability", ref="#/components/schemas/EmployeeEloquent/properties/english_ability"),
     *                          @OA\Property(property="computer_ability", ref="#/components/schemas/EmployeeEloquent/properties/computer_ability"),
     *                          @OA\Property(property="other_ability", ref="#/components/schemas/EmployeeEloquent/properties/other_ability"),
     *                          @OA\Property(property="bank_id", ref="#/components/schemas/EmployeeEloquent/properties/bank_id"),
     *                          @OA\Property(property="account_number", ref="#/components/schemas/EmployeeEloquent/properties/account_number"),
     *                          @OA\Property(property="join_date", ref="#/components/schemas/EmployeeEloquent/properties/join_date"),
     *                      ),
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
     *                                      example="49e75589-f230-44eb-b209-521a78718cd5"
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
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="childs",
     *                              description="Childs of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateChildEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="formal_education_histories",
     *                              description="Formal education histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateFormalEducationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="non_formal_education_histories",
     *                              description="Non formal education histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateNonFormalEducationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="organization_histories",
     *                              description="Organization histories of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateOrganizationHistoryEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="work_competences",
     *                              description="Work competences of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateWorkCompetenceEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="work_experiences",
     *                              description="Work experiences of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateWorkExperienceEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="other_equipments",
     *                              description="Other equipments of employee",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateOtherEquipmentEloquent")
     *                          )
     *                      )
     *                  }
     *              ),
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
    public function jobOnBoardVacancyApplicant(Request $request, int $id)
    {
        $vacancyApplicant = $this->_vacancyApplicantServiceInterface->find($id);
        $result = $vacancyApplicant->getObject();

        $createEmployeeRequest = new CreateEmployeeRequest();

        $createEmployeeRequest->company_id = $result->vacancy->company_id;
        $createEmployeeRequest->nip = $request->input('nip');
        $createEmployeeRequest->full_name = $result->applicant->profile->full_name;
        $createEmployeeRequest->nick_name = $result->applicant->profile->nick_name;
        $createEmployeeRequest->gender_id = $result->applicant->gender_id;
        $createEmployeeRequest->religion_id = $result->applicant->religion_id;
        $createEmployeeRequest->birth_place = $result->applicant->birth_place;
        $createEmployeeRequest->birth_date = new DateTime($result->applicant->birth_date);
        $createEmployeeRequest->address = $result->applicant->profile->address;
        $createEmployeeRequest->phone = $result->applicant->profile->phone;;
        $createEmployeeRequest->mobile = $result->applicant->profile->mobile;
        $createEmployeeRequest->email = $result->applicant->profile->email;
        $createEmployeeRequest->identity_number = $result->applicant->identity_number;
        $createEmployeeRequest->identity_expired_date = new DateTime($result->applicant->identity_expired_date);
        $createEmployeeRequest->identity_address = $result->applicant->identity_address;
        $createEmployeeRequest->has_drive_license_a = $request->input('has_drive_license_a');
        $createEmployeeRequest->drive_license_a_number = $request->input('drive_license_a_number');
        $createEmployeeRequest->drive_license_a_date = ($request->input('drive_license_a_date')) ? new DateTime($request->input('drive_license_a_date')) : null;
        $createEmployeeRequest->has_drive_license_b = $request->input('has_drive_license_b');
        $createEmployeeRequest->drive_license_b_number = $request->input('drive_license_b_number');
        $createEmployeeRequest->drive_license_b_date = ($request->input('drive_license_b_date')) ? new DateTime($request->input('drive_license_b_date')) : null;
        $createEmployeeRequest->has_drive_license_c = $request->input('has_drive_license_c');
        $createEmployeeRequest->drive_license_c_number = $request->input('drive_license_c_number');
        $createEmployeeRequest->drive_license_c_date = ($request->input('drive_license_c_date')) ? new DateTime($request->input('drive_license_c_date')) : null;
        $createEmployeeRequest->marital_status_id = $result->applicant->marital_status_id;
        $createEmployeeRequest->mate_as = $request->input('mate_as');
        $createEmployeeRequest->mate_full_name = $request->input('mate_full_name');
        $createEmployeeRequest->mate_nick_name = $request->input('mate_nick_name');
        $createEmployeeRequest->mate_birth_place = $request->input('mate_birth_place');
        $createEmployeeRequest->mate_birth_date = ($request->input('mate_birth_date')) ? new DateTime($request->input('mate_birth_date')) : null;
        $createEmployeeRequest->mate_occupation = $request->input('mate_occupation');
        $createEmployeeRequest->office_id = $request->input('office_id');
        $createEmployeeRequest->work_area_id = $request->input('work_area_id');
        $createEmployeeRequest->has_npwp = $request->input('has_npwp');
        $createEmployeeRequest->npwp_number = $request->input('npwp_number');
        $createEmployeeRequest->npwp_date = ($request->input('npwp_date')) ? new DateTime($request->input('npwp_date')) : null;
        $createEmployeeRequest->npwp_status = $request->input('npwp_status');
        $createEmployeeRequest->has_bpjs_tenaga_kerja = $request->input('has_bpjs_tenaga_kerja');
        $createEmployeeRequest->bpjs_tenaga_kerja_number = $request->input('bpjs_tenaga_kerja_number');
        $createEmployeeRequest->bpjs_tenaga_kerja_date = ($request->input('bpjs_tenaga_kerja_date')) ? new DateTime($request->input('bpjs_tenaga_kerja_date')) : null;
        $createEmployeeRequest->bpjs_tenaga_kerja_class = $request->input('bpjs_tenaga_kerja_class');
        $createEmployeeRequest->has_bpjs_kesehatan = $request->input('has_bpjs_kesehatan');
        $createEmployeeRequest->bpjs_kesehatan_number = $request->input('bpjs_kesehatan_number');
        $createEmployeeRequest->bpjs_kesehatan_date = ($request->input('bpjs_kesehatan_date')) ? new DateTime($request->input('bpjs_kesehatan_date')) : null;
        $createEmployeeRequest->bpjs_kesehatan_class = $request->input('bpjs_kesehatan_class');
        $createEmployeeRequest->has_mate_bpjs_kesehatan = $request->input('has_mate_bpjs_kesehatan');
        $createEmployeeRequest->mate_bpjs_kesehatan_number = $request->input('mate_bpjs_kesehatan_number');
        $createEmployeeRequest->mate_bpjs_kesehatan_date = ($request->input('mate_bpjs_kesehatan_date')) ? new DateTime($request->input('mate_bpjs_kesehatan_date')) : null;
        $createEmployeeRequest->mate_bpjs_kesehatan_class = $request->input('mate_bpjs_kesehatan_class');
        $createEmployeeRequest->dplk_number = $request->input('dplk_number');
        $createEmployeeRequest->collective_number = $request->input('collective_number');
        $createEmployeeRequest->english_ability = $request->input('english_ability');
        $createEmployeeRequest->computer_ability = $request->input('computer_ability');
        $createEmployeeRequest->other_ability = $request->input('other_ability');
        $createEmployeeRequest->bank_id = $request->input('bank_id');
        $createEmployeeRequest->account_number = $request->input('account_number');
        $createEmployeeRequest->join_date = ($request->input('join_date')) ? new DateTime($request->input('join_date')) : null;
        $createEmployeeRequest->work_status = $result->vacancy->work_status;
        $createEmployeeRequest->work_type = $result->vacancy->work_type;

        //Many to many
        $createEmployeeRequest->media_libraries = $request->input('media_libraries');

        //Has many
        $createEmployeeRequest->childs = $request->input('childs');
        $createEmployeeRequest->formal_educations = $request->input('formal_educations');
        $createEmployeeRequest->non_formal_educations = $request->input('non_formal_educations');
        $createEmployeeRequest->organizations = $request->input('organizations');
        $createEmployeeRequest->other_equipments = $request->input('other_equipments');
        $createEmployeeRequest->work_competences = $request->input('work_competences');
        $createEmployeeRequest->work_experiences = $request->input('work_experiences');

        $this->setRequestAuthor($createEmployeeRequest);

        $responseEmployee = $this->_employeeServiceInterface->create($createEmployeeRequest);


        if ($responseEmployee->isSuccess()) {
            $response = $this->_vacancyApplicantServiceInterface->jobOnBoard($result);
        }
        else {
            return $this->getBasicErrorJson($responseEmployee);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/vacancy-applicant/{id}/note",
     *     operationId="noteVacancyApplicant",
     *     summary="Update note vacancy applicant",
     *     tags={"Vacancy Applicant"},
     *     description="Update note vacancy applicant",
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
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                       property="note",
     *                       type="string",
     *                       description="Note property"
     *                  )
     *              ),
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
    public function noteVacancyApplicant(Request $request, int $id)
    {
        $vacancyApplicant = $this->_vacancyApplicantServiceInterface->find($id);
        $result = $vacancyApplicant->getObject();

        $vacancyApplicationNote = $this->_vacancyApplicationNoteServiceInterface->newInstance();

        $vacancyApplicationNote->vacancy_application_id = $id;
        $vacancyApplicationNote->note = $request->input('note');

        $responseVacancyApplicationNote = $this->_vacancyApplicationNoteServiceInterface->create($vacancyApplicationNote);

        if ($responseVacancyApplicationNote->isSuccess()) {
            $response = $this->_vacancyApplicantServiceInterface->note($result);
        }
        else {
            return $this->getBasicErrorJson($responseVacancyApplicationNote);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson($applicantId = null, $vacancyId = null, $recruitmentStageId = null, $rating = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($applicantId, $vacancyId, $recruitmentStageId, $rating);
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
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, $applicantId = null, $vacancyId = null, $recruitmentStageId = null, $rating = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $applicantId, $vacancyId, $recruitmentStageId, $rating);
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
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, $applicantId = null, $vacancyId = null, $recruitmentStageId = null, $rating = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $applicantId, $vacancyId, $recruitmentStageId, $rating);
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

    /**
     * @param ApplicantInterface $entity
     * @return Collection
     */
    private function getApplicantObject(ApplicantInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id
        ]);

        return $rowJsonData;
    }

    /**
     * @param VacancyInterface $entity
     * @return Collection
     */
    private function getVacancyObject(VacancyInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'title' => $entity->title
        ]);

        return $rowJsonData;
    }

    /**
     * @param RecruitmentStageInterface $entity
     * @return Collection
     */
    private function getRecruitmentStageObject(RecruitmentStageInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name,
            'is_scheduled' => $entity->is_scheduled,
            'is_init' => $entity->is_init,
            'is_hired' => $entity->is_hired,
            'is_reject' => $entity->is_reject
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
