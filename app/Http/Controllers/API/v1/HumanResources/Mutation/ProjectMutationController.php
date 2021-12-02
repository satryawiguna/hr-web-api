<?php

namespace App\Http\Controllers\API\v1\HumanResources\Mutation;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationServiceInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Project\Contracts\ProjectInterface;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Exception;
use File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProjectMutationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_projectMutationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * ProjectMutationController constructor.
     * @param ProjectMutationServiceInterface $projectMutationServiceInterface
     */
    public function __construct(ProjectMutationServiceInterface $projectMutationServiceInterface)
    {
        $this->_projectMutationServiceInterface = $projectMutationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/employee/{employeeId}/project-mutations",
     *     operationId="getProjectMutationList",
     *     summary="Get list of project mutation",
     *     tags={"Project Mutation"},
     *     description="Get list of project mutation",
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
     *          name="project_id",
     *          in="query",
     *          description="Project id parameter",
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
    public function getProjectMutationList(Request $request, int $employeeId)
    {
        $projectId = $request->get('project_id');
        $rangeMutationDate = new DateTimeRange($request->get('start_mutation_date'), $request->get('end_mutation_date'));

        return $this->getListJson($employeeId, $projectId, $rangeMutationDate,
            [$this->_projectMutationServiceInterface, 'projectMutationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'project' => $this->getProjectObject($entity->project),
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
     *     path="/employee/{employeeId}/project-mutation/list-search",
     *     operationId="postProjectMutationListSearch",
     *     summary="Get list of project mutation with query search",
     *     tags={"Project Mutation"},
     *     description="Get list of project mutation with query search",
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
     *                  @OA\Property(property="project_id", ref="#/components/schemas/ProjectMutationEloquent/properties/project_id"),
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
    public function postProjectMutationListSearch(Request $request, int $employeeId)
    {
        $projectId = $request->input('project_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchJson($request, $employeeId, $projectId, $rangeMutationDate,
            [$this->_projectMutationServiceInterface, 'projectMutationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'project' => $this->getProjectObject($entity->project),
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
     *     path="/employee/{employeeId}/project-mutation/page-search",
     *     operationId="postProjectMutationPageSearch",
     *     summary="Get list of project mutation with query and page parameter search",
     *     tags={"Project Mutation"},
     *     description="Get list of project mutation with query and page parameter search",
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
     *                          @OA\Property(property="project_id", ref="#/components/schemas/ProjectMutationEloquent/properties/project_id"),
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
     * @param int $id
     * @return mixed
     */
    public function postProjectMutationPageSearch(Request $request, int $employeeId)
    {
        $projectId = $request->input('project_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getPagedSearchJson($request, $employeeId, $projectId, $rangeMutationDate,
            [$this->_projectMutationServiceInterface, 'projectMutationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'project' => $this->getProjectObject($entity->project),
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
     *     path="/employee/{employeeId}/project-mutation/{id}",
     *     operationId="getProjectMutationDetail",
     *     summary="Get detail project mutation",
     *     tags={"Project Mutation"},
     *     description="Get detail project mutation",
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
     *          description="Project mutation parameter",
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
    public function getProjectMutationDetail(int $employeeId, int $id)
    {
        return $this->getDetailObjectJson($employeeId, $id,
            [$this->_projectMutationServiceInterface, 'showProjectMutation'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'project' => $this->getProjectObject($entity->project),
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
     *     path="/employee/{employeeId}/project-mutation",
     *     operationId="postProjectMutationCreate",
     *     summary="Create project mutation",
     *     tags={"Project Mutation"},
     *     description="Create project mutation",
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
     *              @OA\Schema(ref="#/components/schemas/CreateProjectMutationEloquent")
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
     * @throws Exception
     */
    public function postProjectMutationCreate(Request $request, int $employeeId)
    {
        $projectMutation = $this->_projectMutationServiceInterface->newInstance();

        $projectMutation->employee_id = $employeeId;
        $projectMutation->project_id = $request->input('project_id');
        $projectMutation->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;

        $this->setRequestAuthor($projectMutation);

        $response = $this->_projectMutationServiceInterface->create($projectMutation);
        $projectMutationCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $projectMutationCreated);
    }

    /**
     * @OA\Put(
     *     path="/employee/{employeeId}/project-mutation",
     *     operationId="putProjectMutationUpdate",
     *     summary="Update project mutation",
     *     tags={"Project Mutation"},
     *     description="Update project mutation",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateProjectMutationEloquent")
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
     * @throws Exception
     */
    public function putProjectMutationUpdate(Request $request, int $employeeId)
    {
        $projectMutation = $this->_projectMutationServiceInterface->find($request->input('id'));

        $result = $projectMutation->getObject();

        $result->employee_id = $employeeId;
        $result->project_id = $request->input('project_id');
        $result->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;

        $this->setRequestAuthor($result);

        $response = $this->_projectMutationServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/employee/{employeeId}/project-mutation/{id}",
     *     operationId="deleteProjectMutation",
     *     summary="Delete project mutation",
     *     tags={"Project Mutation"},
     *     description="Delete project mutation",
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
    public function deleteProjectMutation(int $employeeId, int $id)
    {
        $response = $this->_projectMutationServiceInterface->delete($employeeId, $id);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/employee/{employeeId}/project-mutations",
     *     operationId="deleteBulkProjectMutation",
     *     summary="Delete bulk project mutation",
     *     tags={"Project Mutation"},
     *     description="Delete bulk project mutation",
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
    public function deleteBulkProjectMutation(Request $request, int $employeeId)
    {
        $ids = $request->input('ids');

        $response = $this->_projectMutationServiceInterface->deleteBulk($employeeId, $ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/employee/{employeeId}/project-mutations/export",
     *     operationId="postProjectMutationListSearchExport",
     *     summary="Get list export of project mutation",
     *     tags={"Project Mutation"},
     *     description="Return project mutation exported",
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
     *                  @OA\Property(property="project_id", ref="#/components/schemas/ProjectMutationEloquent/properties/project_id"),
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
     * @param int $employeeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function postProjectMutationListSearchExport(Request $request, int $employeeId)
    {
        $export = $request->input('export');
        $projectId = $request->input('project_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchExportJson($request, $export, $employeeId, $projectId, $rangeMutationDate,
            [$this->_projectMutationServiceInterface, 'projectMutationListSearch'],
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

        $path = 'human-resources/mutation/excel/';
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (Excel::store(new ProjectMutationExport($entities), $path . $file)) {
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

        $path = storage_path('app/human-resources/mutation/pdf/');
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (PDF::loadView('exports.human-resources.mutation.project-mutation', ['projectMutations' => $entities])
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
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $employeeId = null, int $projectId = null, object $rangeMutationDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($employeeId, $projectId, $rangeMutationDate);
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
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $projectId, $rangeMutationDate);
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
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null,
                                                   callable $searchMethod,
                                                   callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $projectId, $rangeMutationDate);
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
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $projectId, $rangeMutationDate);
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
     * @param ProjectInterface $entity
     * @return Collection
     */
    private function getProjectObject(ProjectInterface $entity)
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
