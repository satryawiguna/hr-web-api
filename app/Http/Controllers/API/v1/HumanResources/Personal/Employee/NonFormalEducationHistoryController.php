<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal\Employee;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryServiceInterface;
use App\Exports\HumanResources\Personal\Employee\NonFormalEducationExport;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade as PDF;

class NonFormalEducationHistoryController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_nonFormalEducationHistoryServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * NonFormalEducationHistoryController constructor.
     * @param NonFormalEducationHistoryServiceInterface $nonFormalEducationHistoryServiceInterface
     */
    public function __construct(NonFormalEducationHistoryServiceInterface $nonFormalEducationHistoryServiceInterface)
    {
        $this->_nonFormalEducationHistoryServiceInterface = $nonFormalEducationHistoryServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/non-formal-education-history/list",
     *     operationId="getNonFormalEducationHistoryList",
     *     summary="Get list of non formal education history",
     *     tags={"Non Formal Education History"},
     *     description="Get list of non formal education history",
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
     *          name="date",
     *          in="query",
     *          description="Date parameter",
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
    public function getNonFormalEducationHistoryList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $date = ($request->get('date')) ? new DateTime($request->get('date')) : null;

        return $this->getListJson($companyId, $employeeId, $date,
            [$this->_nonFormalEducationHistoryServiceInterface, 'nonFormalEducationHistoryList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'name' => $entity->name,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'institution' => $entity->institution,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/non-formal-education-history/list-search",
     *     operationId="postNonFormalEducationHistoryListSearch",
     *     summary="Get list of non formal education history with query search",
     *     tags={"Non Formal Education History"},
     *     description="Get list of non formal education history with query search",
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
     *                      description="Query property (Keyword would be filter type, name)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(
     *                      property="company_id",
     *                      description="Company id property",
     *                      type="integer",
     *                      format="int64",
     *                      example=1
     *                  ),
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/NonFormalEducationHistoryEloquent/properties/employee_id"),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date parameter",
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
    public function postNonFormalEducationHistoryListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $date = ($request->input('date')) ? new DateTime($request->input('date')) : null;

        return $this->getListSearchJson($request, $companyId, $employeeId, $date,
            [$this->_nonFormalEducationHistoryServiceInterface, 'nonFormalEducationHistoryListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'name' => $entity->name,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'institution' => $entity->institution,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/non-formal-education-history/page-search",
     *     operationId="postNonFormalEducationHistoryPageSearch",
     *     summary="Get list of non formal education history with query and page parameter search",
     *     tags={"Non Formal Education History"},
     *     description="Get list of non formal education history with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter type, name)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(
     *                              property="company_id",
     *                              description="Company id property",
     *                              type="integer",
     *                              format="int64",
     *                              example=1
     *                          ),
     *                          @OA\Property(property="employee_id", ref="#/components/schemas/NonFormalEducationHistoryEloquent/properties/employee_id"),
     *                          @OA\Property(
     *                              property="date",
     *                              description="Date parameter",
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
     * @return mixed
     */
    public function postNonFormalEducationHistoryPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $date = ($request->input('date')) ? new DateTime($request->input('date')) : null;

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $date,
            [$this->_nonFormalEducationHistoryServiceInterface, 'nonFormalEducationHistoryPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'name' => $entity->name,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'institution' => $entity->institution,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/non-formal-education-history/detail/{id}",
     *     operationId="getNonFormalEducationHistoryDetail",
     *     summary="Get detail non formal education history",
     *     tags={"Non Formal Education History"},
     *     description="Get detail non formal education history",
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNonFormalEducationHistoryDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_nonFormalEducationHistoryServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'name' => $entity->name,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'institution' => $entity->institution,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/non-formal-education-history/create",
     *     operationId="postNonFormalEducationHistoryCreate",
     *     summary="Create non formal education history",
     *     tags={"Non Formal Education History"},
     *     description="Create non formal education history",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateNonFormalEducationHistoryEloquent")
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
    public function postNonFormalEducationHistoryCreate(Request $request)
    {
        $nonFormalEducationHistory = $this->_nonFormalEducationHistoryServiceInterface->newInstance();

        $nonFormalEducationHistory->employee_id = $request->input('employee_id');
        $nonFormalEducationHistory->type = $request->input('type');
        $nonFormalEducationHistory->name = $request->input('name');
        $nonFormalEducationHistory->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $nonFormalEducationHistory->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;
        $nonFormalEducationHistory->institution = $request->input('institution');

        $this->setRequestAuthor($nonFormalEducationHistory);

        $response = $this->_nonFormalEducationHistoryServiceInterface->create($nonFormalEducationHistory);
        $nonFormalEducationHistoryCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $nonFormalEducationHistoryCreated);
    }

    /**
     * @OA\Put(
     *     path="/non-formal-education-history/update",
     *     operationId="putNonFormalEducationHistoryUpdate",
     *     summary="Update non formal education history",
     *     tags={"Non Formal Education History"},
     *     description="Update non formal education history",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateNonFormalEducationHistoryEloquent")
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
    public function putNonFormalEducationHistoryUpdate(Request $request)
    {
        $nonFormalEducationHistory = $this->_nonFormalEducationHistoryServiceInterface->find($request->input('id'));

        $result = $nonFormalEducationHistory->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->type = $request->input('type');
        $result->name = $request->input('name');
        $result->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $result->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;
        $result->institution = $request->input('institution');

        $this->setRequestAuthor($result);

        $response = $this->_nonFormalEducationHistoryServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/non-formal-education-history/delete/{id}",
     *     operationId="deleteNonFormalEducationHistory",
     *     summary="Delete non formal education history",
     *     tags={"Non Formal Education History"},
     *     description="Delete non formal education history",
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
    public function deleteNonFormalEducationHistory(int $id)
    {
        $nonFormalEducationHistory = $this->_nonFormalEducationHistoryServiceInterface->find($id);

        $result = $nonFormalEducationHistory->getObject();

        $response = $this->_nonFormalEducationHistoryServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/non-formal-education-history/deletes",
     *     operationId="deleteBulkNonFormalEducationHistory",
     *     summary="Delete bulk non formal education history",
     *     tags={"Non Formal Education History"},
     *     description="Delete bulk non formal education history",
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
    public function deleteBulkNonFormalEducationHistory(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_nonFormalEducationHistoryServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/non-formal-education-history/list-search/export",
     *     operationId="postNonFormalEducationHistoryListSearchExport",
     *     summary="Export list of non formal education history",
     *     tags={"Non Formal Education History"},
     *     description="Export list of non formal education history",
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
     *                      property="type",
     *                      description="Type of non formal education history export format",
     *                      type="string",
     *                      enum={"excel", "pdf"},
     *                      default=""
     *                  ),
     *                  @OA\Property(
     *                      property="company_id",
     *                      description="Company id property",
     *                      type="integer",
     *                      format="int64",
     *                      example=1
     *                  ),
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/employee_id"),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date parameter",
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
    public function postNonFormalEducationHistoryListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $date = ($request->input('date') ? new DateTime($request->input('date')) : null);

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $date,
            [$this->_nonFormalEducationHistoryServiceInterface, 'nonFormalEducationHistoryListSearch'],
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

        $path = 'public/';
        $file = uniqid() . $ext;

        if (Excel::store(new NonFormalEducationExport($entities), $path . $file)) {
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

        $path = 'storage/';
        $file = uniqid() . $ext;

        if (PDF::loadView('exports.human-resources.personal.employee.non-formal-education-history', ['nonFormalEducationHistories' => $entities])
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, DateTime $date = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $date);
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, DateTime $date = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $date);
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param object|null $date
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, int $employeeId = null, object $date = null,
                                                   callable $searchMethod,
                                                   callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $date);
        $rowJsonData = $dtoObjectToJsonMethod($response->getDtoCollection(), $export);

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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, DateTime $date = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $date);
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

    //</editor-fold>
}
