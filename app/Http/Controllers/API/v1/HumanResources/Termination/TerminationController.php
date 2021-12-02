<?php
namespace App\Http\Controllers\API\v1\HumanResources\Termination;


use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Termination\Contracts\TerminationServiceInterface;
use App\Exports\HumanResources\Termination\TerminationExport;
use App\Helpers\DateTimeRange;
use App\Helpers\NumericRange;
use App\Http\Controllers\BaseController;
use DateTime;
use File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class TerminationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_terminationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * TerminationController constructor.
     * @param TerminationServiceInterface $terminationServiceInterface
     */
    public function __construct(TerminationServiceInterface $terminationServiceInterface)
    {
        $this->_terminationServiceInterface = $terminationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/terminations",
     *     operationId="getTerminationList",
     *     summary="Get list of termination",
     *     tags={"Termination"},
     *     description="Get list of termination",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="employee_id",
     *          in="query",
     *          description="Employee id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="type",
     *          in="query",
     *          description="Type parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"RESIGN", "PHK"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_termination_date",
     *          in="query",
     *          description="Start termination date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_termination_date",
     *          in="query",
     *          description="End termination date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_severance",
     *          in="query",
     *          description="Start severance parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="float",
     *              example="0"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_severance",
     *          in="query",
     *          description="End severance parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="float",
     *              example="100"
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
    public function getTerminationList(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $type = $request->get('type');
        $rangeTerminationDate = new DateTimeRange($request->get('start_termination_date'), $request->get('end_termination_date'));
        $rangeSeverance = new NumericRange($request->get('start_severance'), $request->get('end_severance'));

        return $this->getListJson($employeeId, $type, $rangeTerminationDate, $rangeSeverance,
            [$this->_terminationServiceInterface, 'terminationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'termination_date' => $entity->termination_date,
                        'note' => $entity->note,
                        'severance' => $entity->severance,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/terminations/list-search",
     *     operationId="postTerminationListSearch",
     *     summary="Get list of termination with query search",
     *     tags={"Termination"},
     *     description="Get list of termination with query search",
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
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/TerminationEloquent/properties/employee_id"),
     *                  @OA\Property(property="type", ref="#/components/schemas/TerminationEloquent/properties/type"),
     *                  @OA\Property(
     *                      property="start_termination_date",
     *                      description="Start termination date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_termination_date",
     *                      description="End termination date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_severance",
     *                      description="Start severance parameter",
     *                      type="float",
     *                      example="0"
     *                  ),
     *                  @OA\Property(
     *                      property="end_severance",
     *                      description="End severance parameter",
     *                      type="float",
     *                      example="100"
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
    public function postTerminationListSearch(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $type = $request->get('type');
        $rangeTerminationDate = new DateTimeRange($request->input('start_termination_date'), $request->input('end_termination_date'));
        $rangeSeverance = new NumericRange($request->input('start_severance'), $request->input('end_severance'));

        return $this->getListSearchJson($request, $employeeId, $type, $rangeTerminationDate, $rangeSeverance,
            [$this->_terminationServiceInterface, 'terminationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'termination_date' => $entity->termination_date,
                        'note' => $entity->note,
                        'severance' => $entity->severance,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/terminations/page-search",
     *     operationId="postTerminationPageSearch",
     *     summary="Get list of termination with query and page parameter search",
     *     tags={"Termination"},
     *     description="Get list of termination with query and page parameter search",
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
     *                          @OA\Property(property="employee_id", ref="#/components/schemas/TerminationEloquent/properties/employee_id"),
     *                          @OA\Property(property="type", ref="#/components/schemas/TerminationEloquent/properties/type"),
     *                          @OA\Property(
     *                              property="start_termination_date",
     *                              description="Start termination date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_termination_date",
     *                              description="End termination date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_severance",
     *                              description="Start severance parameter",
     *                              type="float",
     *                              example="0"
     *                          ),
     *                          @OA\Property(
     *                              property="end_severance",
     *                              description="End severance parameter",
     *                              type="float",
     *                              example="100"
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
    public function postTerminationPageSearch(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $type = $request->get('type');
        $rangeTerminationDate = new DateTimeRange($request->input('start_termination_date'), $request->input('end_termination_date'));
        $rangeSeverance = new NumericRange($request->input('start_severance'), $request->input('end_severance'));

        return $this->getPagedSearchJson($request, $employeeId, $type, $rangeTerminationDate, $rangeSeverance,
            [$this->_terminationServiceInterface, 'terminationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'termination_date' => $entity->termination_date,
                        'note' => $entity->note,
                        'severance' => $entity->severance,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/termination",
     *     operationId="postTerminationCreate",
     *     summary="Create termination",
     *     tags={"Termination"},
     *     description="Create termination",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateTerminationEloquent")
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
    public function postTerminationCreate(Request $request)
    {
        $termination = $this->_terminationServiceInterface->newInstance();

        $termination->employee_id = $request->input('employee_id');
        $termination->type = $request->input('type');
        $termination->termination_date = ($request->input('termination_date')) ? new DateTime($request->input('termination_date')) : null;
        $termination->note = $request->input('note');
        $termination->severance = $request->input('severance');

        $this->setRequestAuthor($termination);

        $response = $this->_terminationServiceInterface->create($termination);
        $terminationCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $terminationCreated);
    }

    /**
     * @OA\Put(
     *     path="/termination",
     *     operationId="putTerminationUpdate",
     *     summary="Update termination",
     *     tags={"Termination"},
     *     description="Update termination",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateTerminationEloquent")
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
    public function putTerminationUpdate(Request $request)
    {
        $termination = $this->_terminationServiceInterface->find($request->input('id'));

        $result = $termination->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->type = $request->input('type');
        $result->termination_date = ($request->input('termination_date')) ? new DateTime($request->input('termination_date')) : null;
        $result->note = $request->input('note');
        $result->severance = $request->input('severance');
        $this->setRequestAuthor($result);

        $response = $this->_terminationServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/termination/{id}",
     *     operationId="deleteTermination",
     *     summary="Delete termination",
     *     tags={"Termination"},
     *     description="Delete termination",
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
    public function deleteTermination(int $id)
    {
        $termination = $this->_terminationServiceInterface->find($id);

        $result = $termination->getObject();

        $response = $this->_terminationServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/terminations",
     *     operationId="deleteBulkTermination",
     *     summary="Delete bulk termination",
     *     tags={"Termination"},
     *     description="Delete bulk termination",
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
    public function deleteBulkTermination(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_terminationServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/terminations/export",
     *     operationId="postTerminationListSearchExport",
     *     summary="Export list of termination",
     *     tags={"Termination"},
     *     description="Export list of termination",
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
     *                      property="export",
     *                      description="Export property",
     *                      type="string",
     *                      enum={"excel", "pdf"},
     *                      default="",
     *                      example="excel"
     *                  ),
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/TerminationEloquent/properties/employee_id"),
     *                  @OA\Property(property="type", ref="#/components/schemas/TerminationEloquent/properties/type"),
     *                  @OA\Property(
     *                      property="start_termination_date",
     *                      description="Start termination date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_termination_date",
     *                      description="End termination date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_severance",
     *                      description="Start severance parameter",
     *                      type="float",
     *                      example="0"
     *                  ),
     *                  @OA\Property(
     *                      property="end_severance",
     *                      description="End severance parameter",
     *                      type="float",
     *                      example="100"
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
    public function postTerminationListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $employeeId = $request->get('employee_id');
        $type = $request->get('type');
        $rangeTerminationDate = new DateTimeRange($request->input('start_termination_date'), $request->input('end_termination_date'));
        $rangeSeverance = new NumericRange($request->input('start_severance'), $request->input('end_severance'));

        return $this->getListSearchExportJson($request, $export, $employeeId, $type, $rangeTerminationDate, $rangeSeverance,
            [$this->_terminationServiceInterface, 'terminationListSearch'],
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

        $path = 'human-resources/termination/excel/';
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (Excel::store(new TerminationExport($entities), $path . $file)) {
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

        $path = storage_path('app/human-resources/termination/pdf/');
        $file = uniqid() . $ext;

        if (PDF::loadView('exports.human-resources.termination.termination', ['terminations' => $entities])
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

    /**
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($employeeId, $type, $rangeTerminationDate, $rangeSeverance);
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
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
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
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
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
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
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
     * @param EmployeeEloquent $entity
     * @return Collection
     */
    private function getEmployeeObject(EmployeeInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'full_name' => $entity->full_name
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
