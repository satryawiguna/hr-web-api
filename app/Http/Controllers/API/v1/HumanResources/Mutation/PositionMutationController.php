<?php

namespace App\Http\Controllers\API\v1\HumanResources\Mutation;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationServiceInterface;
use App\Exports\HumanResources\Mutation\PositionMutationExport;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use DateTime;
use File;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class PositionMutationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_positionMutationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * PositionMutationController constructor.
     * @param PositionMutationServiceInterface $positionMutationServiceInterface
     */
    public function __construct(PositionMutationServiceInterface $positionMutationServiceInterface)
    {
        $this->_positionMutationServiceInterface = $positionMutationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/employee/{employeeId}/position-mutations",
     *     operationId="getPositionMutationList",
     *     summary="Get list of position mutation",
     *     tags={"Position Mutation"},
     *     description="Get list of position mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Employee id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="position_id",
     *          in="query",
     *          description="Position id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="grade_id",
     *          in="query",
     *          description="Grade id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_mutation_date",
     *          in="query",
     *          description="Start mutation date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_mutation_date",
     *          in="query",
     *          description="End mutation date parameter",
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
     * @param int $employeeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPositionMutationList(Request $request, int $employeeId)
    {
        $positionId = $request->get('position_id');
        $gradeId = $request->get('grade_id');
        $rangeMutationDate = new DateTimeRange($request->get('start_mutation_date'), $request->get('end_mutation_date'));

        return $this->getListJson($employeeId, $positionId, $gradeId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/{employeeId}/position-mutation/list-search",
     *     operationId="postPositionMutationListSearch",
     *     summary="Get list of position mutation with query search",
     *     tags={"Position Mutation"},
     *     description="Get list of position mutation with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Employee id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
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
     *                  @OA\Property(property="position_id", ref="#/components/schemas/PositionMutationEloquent/properties/position_id"),
     *                  @OA\Property(property="grade_id", ref="#/components/schemas/PositionMutationEloquent/properties/grade_id"),
     *                  @OA\Property(
     *                      property="start_mutation_date",
     *                      description="Start mutation date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_mutation_date",
     *                      description="End mutation date parameter",
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
     * @param int $employeeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPositionMutationListSearch(Request $request, int $employeeId)
    {
        $positionId = $request->input('position_id');
        $gradeId = $request->input('grade_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchJson($request, $employeeId, $positionId, $gradeId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/{employeeId}/position-mutation/page-search",
     *     operationId="postPositionMutationPageSearch",
     *     summary="Get list of position mutation with query and page parameter search",
     *     tags={"Position Mutation"},
     *     description="Get list of position mutation with query and page parameter search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Employee id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
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
     *                          @OA\Property(property="position_id", ref="#/components/schemas/PositionMutationEloquent/properties/position_id"),
     *                          @OA\Property(property="grade_id", ref="#/components/schemas/PositionMutationEloquent/properties/grade_id"),
     *                          @OA\Property(
     *                              property="start_mutation_date",
     *                              description="Start mutation date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_mutation_date",
     *                              description="End mutation date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          )
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
     * @param int $employeeId
     * @return mixed
     */
    public function postPositionMutationPageSearch(Request $request, int $employeeId)
    {
        $positionId = $request->input('position_id');
        $gradeId = $request->input('grade_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getPagedSearchJson($request, $employeeId, $positionId, $gradeId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postPositionMutationPageSearchCompany(Request $request)
    {
        $companyId = $request->input('company_id');
        $positionId = $request->input('position_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getPagedSearchCompanyJson($request, $companyId, $positionId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationPageSearchCompany'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/employee/{employeeId}/position-mutation/{id}",
     *     operationId="getProjectMutationDetail",
     *     summary="Get detail position mutation",
     *     tags={"Position Mutation"},
     *     description="Get detail position mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Position mutation parameter",
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
     * @param int $employeeId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPositionMutationDetail(int $employeeId, int $id)
    {
        return $this->getDetailObjectJson($employeeId, $id,
            [$this->_positionMutationServiceInterface, 'showPositionMutation'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/{employeeId}/position-mutation",
     *     operationId="postPositionMutationCreate",
     *     summary="Create position mutation",
     *     tags={"Position Mutation"},
     *     description="Create position mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Employee id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreatePositionMutationEloquent")
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
     * @param int $employeeId
     * @return mixed
     * @throws \Exception
     */
    public function postPositionMutationCreate(Request $request, int $employeeId)
    {
        $positionMutation = $this->_positionMutationServiceInterface->newInstance();

        $positionMutation->employee_id = $employeeId;
        $positionMutation->position_id = $request->input('position_id');
        $positionMutation->grade_id = $request->input('grade_id');
        $positionMutation->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;
        $positionMutation->note = $request->input('note');

        $this->setRequestAuthor($positionMutation);

        $response = $this->_positionMutationServiceInterface->create($positionMutation);
        $positionMutationCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $positionMutationCreated);
    }

    /**
     * @OA\Put(
     *     path="/employee/{employeeId}/position-mutation",
     *     operationId="putPositionMutationUpdate",
     *     summary="Update position mutation",
     *     tags={"Position Mutation"},
     *     description="Update position mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Employee id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdatePositionMutationEloquent")
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
     * @param int $employeeId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function putPositionMutationUpdate(Request $request, int $employeeId)
    {
        $positionMutation = $this->_positionMutationServiceInterface->find($request->input('id'));

        $result = $positionMutation->getObject();

        $result->employee_id = $employeeId;
        $result->position_id = $request->input('position_id');
        $result->grade_id = $request->input('grade_id');
        $result->mutation_date = new DateTime($request->input('mutation_date'));
        $result->note = $request->input('note');

        $this->setRequestAuthor($result);

        $response = $this->_positionMutationServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/employee/{employeeId}/position-mutation/delete/{id}",
     *     operationId="deletePositionMutation",
     *     summary="Delete position mutation",
     *     tags={"Position Mutation"},
     *     description="Delete position mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Employee id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
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
     * @param int $employeeId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePositionMutation(int $employeeId, int $id)
    {
        $response = $this->_positionMutationServiceInterface->delete($employeeId, $id);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/employee/{employeeId}/position-mutations",
     *     operationId="deleteBulkPositionMutation",
     *     summary="Delete bulk position mutation",
     *     tags={"Position Mutation"},
     *     description="Delete bulk position mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Employee id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
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
     * @param int $employeeId
     * @return ObjectResponse|\Illuminate\Http\JsonResponse|mixed
     */
    public function deleteBulkPositionMutation(Request $request, int $employeeId)
    {
        $ids = $request->input('ids');

        $response = $this->_positionMutationServiceInterface->deleteBulk($employeeId, $ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/employee/{employeeId}/position-mutations/export",
     *     operationId="postPositionMutationListSearchExport",
     *     summary="Export list of position mutation",
     *     tags={"Position Mutation"},
     *     description="Export list of position mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employeeId",
     *          in="path",
     *          description="Employee id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="export",
     *                      description="Export property",
     *                      type="string",
     *                      enum={"excel", "pdf"},
     *                      default="",
     *                      example="excel"
     *                  ),
     *                  @OA\Property(property="position_id", ref="#/components/schemas/PositionMutationEloquent/properties/position_id"),
     *                  @OA\Property(
     *                      property="start_mutation_date",
     *                      description="Start mutation date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_mutation_date",
     *                      description="End mutation date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
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
     *     )
     * )
     * @param Request $request
     * @param int $employeeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPositionMutationListSearchExport(Request $request, int $employeeId)
    {
        $export = $request->input('export');
        $positionId = $request->input('position_id');
        $gradeId = $request->input('grade_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchExportJson($request, $export, $employeeId, $positionId, $gradeId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationListSearch'],
            function (Collection $entities, string $export) {
                switch ($export) {
                    case 'excel':
                        $ext = '.xlsx';

                        return self::generateExcel($entities, $ext);

                        break;

                    case 'pdf':
                        $ext = '.pdf';

                        return self::generatePDF($entities, $ext);

                        break;

                    default:
                        //Do nothing
                        break;
                }
            });

    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param Collection $entities
     * @param string|null $ext
     * @return mixed
     */
    private function generateExcel(Collection $entities, string $ext = null) {
        $response = new BooleanResponse();

        $path = 'human-resources/mutation/position-mutation/excel/';
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (Excel::store(new PositionMutationExport($entities), $path . $file)) {
            $response->setResult(true);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Success file generate', 200);
        } else {
            $response->setResult(false);
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Invalid file generate', 400);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, [
            'result' => $response->getBoolean(),
            'file' => $file
        ])->getData();
    }

    /**
     * @param Collection $entities
     * @param string|null $ext
     * @return mixed
     */
    private function generatePDF(Collection $entities, string $ext = null) {
        $response = new BooleanResponse();

        $path = storage_path('app/human-resources/mutation/position-mutation/pdf/');
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (PDF::loadView('exports.human-resources.mutation.position-mutation', ['positionMutations' => $entities])
            ->setPaper('a4', 'landscape')
            ->save($path . $file)) {
            $response->setResult(true);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Success file generate', 200);
        } else {
            $response->setResult(false);
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Invalid file generate', 400);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, [
            'result' => $response->getBoolean(),
            'file' =>  $file
        ])->getData();
    }

    /**
     * @param int $employeeId
     * @param int $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getDetailObjectJson(int $employeeId,
                                         int $id,
                                         callable $searchMethod,
                                         callable $dtoObjectToJsonMethod)
    {
        $response = $searchMethod($employeeId, $id);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($employeeId, $positionId, $gradeId, $rangeMutationDate);
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
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $positionId, $gradeId, $rangeMutationDate);
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
     * @param string|null $export
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null,
                                                   callable $searchMethod,
                                                   callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $positionId, $gradeId, $rangeMutationDate);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection(), $export);

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
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $positionId, $gradeId, $rangeMutationDate);
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
     * @param Request $request
     * @param int|null $companyId
     * @param int|null $positionId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchCompanyJson(Request $request, int $companyId = null, int $positionId = null, object $rangeMutationDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $positionId, $rangeMutationDate);
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
     * @param EmployeeInterface $entity
     * @return Collection
     */
    private function getEmployeeObject(EmployeeInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'company' => $this->getCompanyObject($entity->company),
            'nip' => $entity->nip,
            'full_name' => $entity->full_name,
            'nick_name' => $entity->nick_name
        ]);

        return $rowJsonData;
    }

    /**
     * @param CompanyInterface $entity
     * @return Collection
     */
    private function getCompanyObject(CompanyInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param PositionInterface $entity
     * @return Collection
     */
    private function getPositionObject(PositionInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param GradeInterface $entity
     * @return Collection
     */
    private function getGradeObject(GradeInterface $entity)
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
