<?php
namespace App\Http\Controllers\API\v1\HumanResources\Personal\Employee;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\Commons\Degree\Contracts\DegreeInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryServiceInterface;
use App\Domains\Commons\Major\Contracts\MajorInterface;
use App\Exports\HumanResources\Personal\Employee\FormalEducationExport;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class FormalEducationHistoryController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_formalEducationHistoryServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * FormalEducationHistoryController constructor.
     * @param FormalEducationHistoryServiceInterface $formalEducationHistoryServiceInterface
     */
    public function __construct(FormalEducationHistoryServiceInterface $formalEducationHistoryServiceInterface)
    {
        $this->_formalEducationHistoryServiceInterface = $formalEducationHistoryServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/formal-education-history/list",
     *     operationId="getFormalEducationHistoryList",
     *     summary="Get list of formal education history",
     *     tags={"Formal Education History"},
     *     description="Get list of formal education history",
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
     *          name="degree_id",
     *          in="query",
     *          description="Degree id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="major_id",
     *          in="query",
     *          description="Major id parameter",
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
     * @throws Exception
     */
    public function getFormalEducationHistoryList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $degreeId = $request->get('degree_id');
        $majorId = $request->get('major_id');
        $date = ($request->get('date')) ? new DateTime($request->get('date')) : null;

        return $this->getListJson($companyId, $employeeId, $degreeId, $majorId, $date,
            [$this->_formalEducationHistoryServiceInterface, 'formalEducationHistoryList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'degree' => $this->getDegreeObject($entity->degree),
                        'major' => $this->getMajorObject($entity->major),
                        'name' => $entity->name,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/formal-education-history/list-search",
     *     operationId="postFormalEducationHistoryListSearch",
     *     summary="Get list of formal education history with query search",
     *     tags={"Formal Education History"},
     *     description="Get list of formal education history with query search",
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
     *                      description="Query property (Keyword would be filter name)",
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
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/employee_id"),
     *                  @OA\Property(property="major_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/major_id"),
     *                  @OA\Property(property="degree_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/degree_id"),
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
     * @throws Exception
     */
    public function postFormalEducationHistoryListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $degreeId = $request->input('degree_id');
        $majorId = $request->input('major_id');
        $date = ($request->input('date')) ? new DateTime($request->input('date')) : null;

        return $this->getListSearchJson($request, $companyId, $employeeId, $degreeId, $majorId, $date,
            [$this->_formalEducationHistoryServiceInterface, 'formalEducationHistoryListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'degree' => $this->getDegreeObject($entity->degree),
                        'major' => $this->getMajorObject($entity->major),
                        'name' => $entity->name,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/formal-education-history/page-search",
     *     operationId="postFormalEducationHistoryPageSearch",
     *     summary="Get list of formal education history with query and page parameter search",
     *     tags={"Formal Education History"},
     *     description="Get list of formal education history with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter name)",
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
     *                          @OA\Property(property="employee_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/employee_id"),
     *                          @OA\Property(property="major_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/major_id"),
     *                          @OA\Property(property="degree_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/degree_id"),
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
     * @throws Exception
     */
    public function postFormalEducationHistoryPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $degreeId = $request->input('degree_id');
        $majorId = $request->input('major_id');
        $date = ($request->input('date')) ? new DateTime($request->input('date')) : null;

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $degreeId, $majorId, $date,
            [$this->_formalEducationHistoryServiceInterface, 'formalEducationHistoryPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'degree' => $this->getDegreeObject($entity->degree),
                        'major' => $this->getMajorObject($entity->major),
                        'name' => $entity->name,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/formal-education-history/detail/{id}",
     *     operationId="getFormalEducationHistoryDetail",
     *     summary="Get detail formal education history",
     *     tags={"Formal Education History"},
     *     description="Get detail formal education history",
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
    public function getFormalEducationHistoryDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_formalEducationHistoryServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'degree' => $this->getDegreeObject($entity->degree),
                        'major' => $this->getMajorObject($entity->major),
                        'name' => $entity->name,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/formal-education-history/create",
     *     operationId="postFormalEducationHistoryCreate",
     *     summary="Create formal education history",
     *     tags={"Formal Education History"},
     *     description="Create formal education history",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateFormalEducationHistoryEloquent")
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
     * @throws Exception
     */
    public function postFormalEducationHistoryCreate(Request $request)
    {
        $formalEducationHistory = $this->_formalEducationHistoryServiceInterface->newInstance();

        $formalEducationHistory->employee_id = $request->input('employee_id');
        $formalEducationHistory->degree_id = $request->input('degree_id');
        $formalEducationHistory->major_id = $request->input('major_id');
        $formalEducationHistory->name = $request->input('name');
        $formalEducationHistory->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $formalEducationHistory->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;

        $this->setRequestAuthor($formalEducationHistory);

        $response = $this->_formalEducationHistoryServiceInterface->create($formalEducationHistory);
        $formalEducationHistoryCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $formalEducationHistoryCreated);
    }

    /**
     * @OA\Put(
     *     path="/formal-education-history/update",
     *     operationId="putFormalEducationHistoryUpdate",
     *     summary="Update formal education history",
     *     tags={"Formal Education History"},
     *     description="Update formal education history",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateFormalEducationHistoryEloquent")
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
     * @throws Exception
     */
    public function putFormalEducationHistoryUpdate(Request $request)
    {
        $formalEducationHistory = $this->_formalEducationHistoryServiceInterface->find($request->input('id'));

        $result = $formalEducationHistory->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->degree_id = $request->input('degree_id');
        $result->major_id = $request->input('major_id');
        $result->name = $request->input('name');
        $result->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $result->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;

        $this->setRequestAuthor($result);

        $response = $this->_formalEducationHistoryServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/formal-education-history/delete/{id}",
     *     operationId="deleteFormalEducationHistory",
     *     summary="Delete formal education history",
     *     tags={"Formal Education History"},
     *     description="Delete formal education history",
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
    public function deleteFormalEducationHistory(int $id)
    {
        $formalEducationHistory = $this->_formalEducationHistoryServiceInterface->find($id);

        $result = $formalEducationHistory->getObject();

        $response = $this->_formalEducationHistoryServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/formal-education-history/deletes",
     *     operationId="deleteBulkFormalEducationHistory",
     *     summary="Delete bulk formal education history",
     *     tags={"Formal Education History"},
     *     description="Delete bulk formal education history",
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
    public function deleteBulkFormalEducationHistory(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_formalEducationHistoryServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/formal-education-history/list-search/export",
     *     operationId="postFormalEducationHistoryListSearchExport",
     *     summary="Export list of formal education history",
     *     tags={"Formal Education History"},
     *     description="Export list of formal education history",
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
     *                      description="Type of formal education history export format",
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
     *                  @OA\Property(property="major_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/major_id"),
     *                  @OA\Property(property="degree_id", ref="#/components/schemas/FormalEducationHistoryEloquent/properties/degree_id"),
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
     * @throws Exception
     */
    public function postFormalEducationHistoryListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $degreeId = $request->input('degree_id');
        $majorId = $request->input('major_id');
        $date = ($request->input('date') ? new DateTime($request->input('date')) : null);

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $degreeId, $majorId, $date,
            [$this->_formalEducationHistoryServiceInterface, 'formalEducationHistoryListSearch'],
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

        if (Excel::store(new FormalEducationExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.employee.formal-education-history', ['formalEducationHistories' => $entities])
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $degreeId, $majorId, $date);
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $degreeId, $majorId, $date);
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param object|null $date
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, object $date = null,
                                                   callable $searchMethod,
                                                   callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $degreeId, $majorId, $date);
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $degreeId, $majorId, $date);
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
     * @param DegreeInterface $entity
     * @return Collection
     */
    private function getDegreeObject(DegreeInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param MajorInterface $entity
     * @return Collection
     */
    private function getMajorObject(MajorInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
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
