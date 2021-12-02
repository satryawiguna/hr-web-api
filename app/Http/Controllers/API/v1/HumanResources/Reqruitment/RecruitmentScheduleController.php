<?php

namespace App\Http\Controllers\API\v1\HumanResources\Reqruitment;

use App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts\RecruitmentScheduleServiceInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\VacancyApplicantEloquent;
use App\Helpers\Common;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RecruitmentScheduleController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_recruitmentScheduleServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * RecruitmentScheduleController constructor.
     * @param RecruitmentScheduleServiceInterface $recruitmentScheduleServiceInterface
     */
    public function __construct(RecruitmentScheduleServiceInterface $recruitmentScheduleServiceInterface)
    {
        $this->_recruitmentScheduleServiceInterface = $recruitmentScheduleServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/recruitment-schedules",
     *     operationId="getRecruitmentScheduleList",
     *     summary="Get list of recruitment schedule",
     *     tags={"Recruitment Schedule"},
     *     description="Get list of recruitment schedule",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="vacancy_application_id",
     *          in="query",
     *          description="Vacancy applicant id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_schedule_date",
     *          in="query",
     *          description="Start schedule date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_schedule_date",
     *          in="query",
     *          description="End schedule date parameter",
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
    public function getRecruitmentScheduleList(Request $request)
    {
        $vacancyApplicationId = $request->get('vacancy_application_id');
        $rangeScheduleDate = new DateTimeRange($request->get('start_schedule_date'), $request->get('end_schedule_date'));

        return $this->getListJson($vacancyApplicationId, $rangeScheduleDate,
            [$this->_recruitmentScheduleServiceInterface, 'recruitmentScheduleList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'applicant' => Common::isDataExist($entity->vacancyApplication) ? $this->getVacancyApplicantObject($entity->vacancyApplication) : null,
                        'schedule_date' => $entity->schedule_date,
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/recruitment-schedules/list-search",
     *     operationId="postRecruitmentScheduleListSearch",
     *     summary="Get list of recruitment schedule with query search",
     *     tags={"Recruitment Schedule"},
     *     description="Get list of recruitment schedule with query search",
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
     *                      description="Query property (Keyword would be filter note)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="vacancy_application_id", ref="#/components/schemas/RecruitmentScheduleEloquent/properties/vacancy_application_id"),
     *                  @OA\Property(
     *                      property="start_schedule_date",
     *                      description="Start schedule date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_schedule_date date_date",
     *                      description="End schedule date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRecruitmentScheduleListSearch(Request $request)
    {
        $vacancyApplicationId = $request->get('vacancy_application_id');
        $rangeScheduleDate = new DateTimeRange($request->get('start_schedule_date'), $request->get('end_schedule_date'));

        return $this->getListSearchJson($request, $vacancyApplicationId, $rangeScheduleDate,
            [$this->_recruitmentScheduleServiceInterface, 'recruitmentScheduleListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'applicant' => Common::isDataExist($entity->vacancyApplication) ? $this->getVacancyApplicantObject($entity->vacancyApplication) : null,
                        'schedule_date' => $entity->schedule_date,
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/recruitment-schedules/page-search",
     *     operationId="postRecruitmentSchedulePageSearch",
     *     summary="Get list of recruitment schedule with query and page parameter search",
     *     tags={"Recruitment Schedule"},
     *     description="Get list of recruitment schedule with query and page parameter search",
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
     *                          @OA\Property(property="vacancy_application_id", ref="#/components/schemas/RecruitmentScheduleEloquent/properties/vacancy_application_id"),
     *                          @OA\Property(
     *                              property="start_schedule_date",
     *                              description="Start schedule date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_schedule_date",
     *                              description="End schedule date parameter",
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
    public function postRecruitmentSchedulePageSearch(Request $request)
    {
        $vacancyApplicationId = $request->get('vacancy_application_id');
        $rangeScheduleDate = new DateTimeRange($request->get('start_schedule_date'), $request->get('end_schedule_date'));

        return $this->getPagedSearchJson($request, $vacancyApplicationId, $rangeScheduleDate,
            [$this->_recruitmentScheduleServiceInterface, 'recruitmentSchedulePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'applicant' => Common::isDataExist($entity->vacancyApplication) ? $this->getVacancyApplicantObject($entity->vacancyApplication) : null,
                        'schedule_date' => $entity->schedule_date,
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/recruitment-schedule",
     *     operationId="postTerminatpostRecruitmentScheduleCreateionCreate",
     *     summary="Create recruitment schedule",
     *     tags={"Recruitment Schedule"},
     *     description="Create recruitment schedule",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateRecruitmentScheduleEloquent")
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
     * @throws \Exception
     */
    public function postRecruitmentScheduleCreate(Request $request)
    {
        $recruitmentSchedule = $this->_recruitmentScheduleServiceInterface->newInstance();

        $recruitmentSchedule->vacancy_application_id = $request->input('vacancy_application_id');
        $recruitmentSchedule->schedule_date = $request->input('schedule_date');

        $response = $this->_recruitmentScheduleServiceInterface->create($recruitmentSchedule);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/recruitment-schedule",
     *     operationId="putRecruitmentScheduleUpdate",
     *     summary="Update recruitment schedule",
     *     tags={"Recruitment Schedule"},
     *     description="Update recruitment schedule",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateRecruitmentScheduleEloquent")
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
     * @throws \Exception
     */
    public function putRecruitmentScheduleUpdate(Request $request)
    {
        $recruitmentSchedule = $this->_recruitmentScheduleServiceInterface->find($request->input('id'));

        $result = $recruitmentSchedule->getObject();

        $result->vacancy_application_id = $request->input('vacancy_application_id');
        $result->schedule_date = $request->input('schedule_date');

        $response = $this->_recruitmentScheduleServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/recruitment-schedule/{id}",
     *     operationId="deleteRecruitmentSchedule",
     *     summary="Delete recuitment schedule",
     *     tags={"Recruitment Schedule"},
     *     description="Delete recuitment schedule",
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
    public function deleteRecruitmentSchedule(Request $request, $id)
    {
        $recruitmentSchedule = $this->_recruitmentScheduleServiceInterface->find($id);

        $result = $recruitmentSchedule->getObject();

        $response = $this->_recruitmentScheduleServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $vacancyApplicationId = null, object $rangeScheduleDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($vacancyApplicationId, $rangeScheduleDate);
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
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $vacancyApplicationId = null, object $rangeScheduleDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $vacancyApplicationId, $rangeScheduleDate);
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
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $vacancyApplicationId = null, object $rangeScheduleDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $vacancyApplicationId, $rangeScheduleDate);
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
     * @param VacancyApplicantEloquent $entity
     * @return Collection
     */
    private function getVacancyApplicantObject(VacancyApplicantEloquent $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'cover_letter' => $entity->cover_letter
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
