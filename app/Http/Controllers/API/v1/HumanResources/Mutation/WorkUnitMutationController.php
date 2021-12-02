<?php

namespace App\Http\Controllers\API\v1\HumanResources\Mutation;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationServiceInterface;
use App\Exports\HumanResources\Mutation\WorkUnitMutationExport;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use File;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class WorkUnitMutationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_workUnitMutationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * WorkUnitMutationController constructor.
     * @param WorkUnitMutationServiceInterface $workUnitMutationServiceInterface
     */
    public function __construct(WorkUnitMutationServiceInterface $workUnitMutationServiceInterface)
    {
        $this->_workUnitMutationServiceInterface = $workUnitMutationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/employee/{employeeId}/work-unit-mutations",
     *     operationId="getWorkUnitMutationList",
     *     summary="Get list of work unit mutation",
     *     tags={"Work Unit Mutation"},
     *     description="Get list of work unit mutation",
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
     *          name="work_unit_id",
     *          in="query",
     *          description="Work unit id parameter",
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
    public function getWorkUnitMutationList(Request $request, int $employeeId)
    {
        $workUnitId = $request->get('work_unit_id');
        $rangeMutationDate = new DateTimeRange($request->get('start_mutation_date'), $request->get('end_mutation_date'));

        return $this->getListJson($employeeId, $workUnitId, $rangeMutationDate,
            [$this->_workUnitMutationServiceInterface, 'workUnitMutationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'work_unit' => $this->getWorkUnitObject($entity->workUnit),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/{employeeId}/work-unit-mutation/list-search",
     *     operationId="postWorkUnitMutationListSearch",
     *     summary="Get list of work unit mutation with query search",
     *     tags={"Work Unit Mutation"},
     *     description="Get list of work unit mutation with query search",
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
     *                  @OA\Property(property="work_unit_id", ref="#/components/schemas/WorkUnitMutationEloquent/properties/work_unit_id"),
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
    public function postWorkUnitMutationListSearch(Request $request, int $employeeId)
    {
        $workUnitId = $request->input('work_unit_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchJson($request, $employeeId, $workUnitId, $rangeMutationDate,
            [$this->_workUnitMutationServiceInterface, 'workUnitMutationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'work_unit' => $this->getWorkUnitObject($entity->workUnit),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/{employeeId}/work-unit-mutation/page-search",
     *     operationId="postWorkUnitMutationPageSearch",
     *     summary="Get list of work unit mutation with query and page parameter search",
     *     tags={"Work Unit Mutation"},
     *     description="Get list of work unit mutation with query and page parameter search",
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
     *                          @OA\Property(property="work_unit_id", ref="#/components/schemas/WorkUnitMutationEloquent/properties/work_unit_id"),
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
    public function postWorkUnitMutationPageSearch(Request $request, int $employeeId)
    {
        $workUnitId = $request->input('work_unit_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getPagedSearchJson($request, $employeeId, $workUnitId, $rangeMutationDate,
            [$this->_workUnitMutationServiceInterface, 'workUnitMutationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'work_unit' => $this->getWorkUnitObject($entity->workUnit),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/employee/{employeeId}/work-unit-mutation/{id}",
     *     operationId="getWorkUnitMutationDetail",
     *     summary="Get detail work unit mutation",
     *     tags={"Work Unit Mutation"},
     *     description="Get detail work unit mutation",
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
     *          description="Work unit mutation parameter",
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
    public function getWorkUnitMutationDetail(int $employeeId, int $id)
    {
        return $this->getDetailObjectJson($employeeId, $id,
            [$this->_workUnitMutationServiceInterface, 'showWorkUnitMutation'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'work_unit' => $this->getWorkUnitObject($entity->workUnit),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/employee/{id}/work-unit-mutation",
     *     operationId="postWorkUnitMutationCreate",
     *     summary="Create work unit mutation",
     *     tags={"Work Unit Mutation"},
     *     description="Create work unit mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
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
     *              @OA\Schema(ref="#/components/schemas/CreateWorkUnitMutationEloquent")
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
     * @return mixed
     * @throws Exception
     */
    public function postWorkUnitMutationCreate(Request $request, int $id)
    {
        $workUnitMutation = $this->_workUnitMutationServiceInterface->newInstance();

        $workUnitMutation->employee_id = $id;
        $workUnitMutation->work_unit_id = $request->input('work_unit_id');
        $workUnitMutation->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;
        $workUnitMutation->note = $request->input('note');

        $this->setRequestAuthor($workUnitMutation);

        $response = $this->_workUnitMutationServiceInterface->create($workUnitMutation);
        $workUnitMutationCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $workUnitMutationCreated);
    }

    /**
     * @OA\Put(
     *     path="/employee/{id}/work-unit-mutation",
     *     operationId="putWorkUnitMutationUpdate",
     *     summary="Update work unit mutation",
     *     tags={"Work Unit Mutation"},
     *     description="Update work unit mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateWorkUnitMutationEloquent")
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
    public function putWorkUnitMutationUpdate(Request $request, int $id)
    {
        $workUnitMutation = $this->_workUnitMutationServiceInterface->find($request->input('id'));

        $result = $workUnitMutation->getObject();

        $result->employee_id = $id;
        $result->work_unit_id = $request->input('work_unit_id');
        $result->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;
        $result->note = $request->input('note');

        $this->setRequestAuthor($result);

        $response = $this->_workUnitMutationServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/employee/{id}/work-unit-mutation/delete/{workUnitMutationId}",
     *     operationId="deleteWorkUnitMutation",
     *     summary="Delete work unit mutation",
     *     tags={"Work Unit Mutation"},
     *     description="Delete work unit mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
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
     *          name="workUnitMutationId",
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
    public function deleteWorkUnitMutation(int $id, int $workUnitMutationId)
    {
        $workUnitMutation = $this->_workUnitMutationServiceInterface->find($workUnitMutationId);

        $result = $workUnitMutation->getObject();

        $response = $this->_workUnitMutationServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/employee/{id}/work-unit-mutations",
     *     operationId="deleteBulkWorkUnitMutation",
     *     summary="Delete bulk work unit mutation",
     *     tags={"Work Unit Mutation"},
     *     description="Delete bulk work unit mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
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
     * @return ObjectResponse|\Illuminate\Http\JsonResponse|mixed
     */
    public function deleteBulkWorkUnitMutation(Request $request, int $id)
    {
        $ids = $request->input('ids');

        $response = $this->_workUnitMutationServiceInterface->deleteBulk($id, $ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/employee/{id}/work-unit-mutations/export",
     *     operationId="postWorkUnitMutationListSearchExport",
     *     summary="Export list of work unit mutation",
     *     tags={"Work Unit Mutation"},
     *     description="Export list of work unit mutation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
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
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter note)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="work_unit_id", ref="#/components/schemas/WorkUnitMutationEloquent/properties/work_unit_id"),
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postWorkUnitMutationListSearchExport(Request $request, int $id)
    {
        $export = $request->input('export');
        $employeeId = $id;
        $workUnitId = $request->input('work_unit_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchExportJson($request, $export, $employeeId, $workUnitId, $rangeMutationDate,
            [$this->_workUnitMutationServiceInterface, 'workUnitMutationListSearch'],
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

        $path = 'human-resources/mutation/work-unit-mutation/excel/';
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (Excel::store(new WorkUnitMutationExport($entities), $path . $file)) {
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

        $path = storage_path('app/human-resources/mutation/work-unit-mutation/pdf/');
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (PDF::loadView('exports.human-resources.mutation.work-unit-mutation', ['workUnitMutations' => $entities])
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
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($employeeId, $workUnitId, $rangeMutationDate);
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
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $workUnitId, $rangeMutationDate);
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
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $workUnitId, $rangeMutationDate);
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
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $workUnitId, $rangeMutationDate);
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
            'name' => $entity->full_name
        ]);

        return $rowJsonData;
    }

    /**
     * @param WorkUnitInterface $entity
     * @return Collection
     */
    private function getWorkUnitObject(WorkUnitInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'title' => $entity->title
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
