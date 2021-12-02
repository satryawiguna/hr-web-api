<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal\Employee;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceServiceInterface;
use App\Exports\HumanResources\Personal\Employee\WorkExperienceExport;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class WorkExperienceController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_workExperienceServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * WorkExperienceController constructor.
     * @param WorkExperienceServiceInterface $workExperienceServiceInterface
     */
    public function __construct(WorkExperienceServiceInterface $workExperienceServiceInterface)
    {
        $this->_workExperienceServiceInterface = $workExperienceServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/work-experience/list",
     *     operationId="getWorkExperienceList",
     *     summary="Get list of work experience",
     *     tags={"Work Experience"},
     *     description="Get list of work experience",
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
    public function getWorkExperienceList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $date = ($request->get('date')) ? new DateTime($request->get('date')) : null;

        return $this->getListJson($companyId, $employeeId, $date,
            [$this->_workExperienceServiceInterface, 'workExperienceList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'company' => $entity->company,
                        'business_type' => $entity->business_type,
                        'position' => $entity->position,
                        'start_date' => $entity->issue_date,
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
     *     path="/work-experience/list-search",
     *     operationId="postWorkExperienceListSearch",
     *     summary="Get list of work experience with query search",
     *     tags={"Work Experience"},
     *     description="Get list of work experience with query search",
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
     *                      description="Query property (Keyword would be filter reference number and validity)",
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
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/WorkExperienceEloquent/properties/employee_id"),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date property",
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
    public function postWorkExperienceListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $date = ($request->input('date')) ? new DateTime($request->input('date')) : null;

        return $this->getListSearchJson($request, $companyId, $employeeId, $date,
            [$this->_workExperienceServiceInterface, 'workExperienceListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'company' => $entity->company,
                        'business_type' => $entity->business_type,
                        'position' => $entity->position,
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
     *     path="/work-experience/page-search",
     *     operationId="postWorkExperiencePageSearch",
     *     summary="Get list of work experience with query and page parameter search",
     *     tags={"Work Experience"},
     *     description="Get list of work experience with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter company, business_type and position)",
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
     *                          @OA\Property(property="employee_id", ref="#/components/schemas/WorkCompetenceEloquent/properties/employee_id"),
     *                          @OA\Property(
     *                              property="date",
     *                              description="Date property",
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
    public function postWorkExperiencePageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $date = ($request->input('date')) ? new DateTime($request->input('date')) : null;

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $date,
            [$this->_workExperienceServiceInterface, 'workExperiencePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'company' => $entity->company,
                        'business_type' => $entity->business_type,
                        'position' => $entity->position,
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
     *     path="/work-experience/detail/{id}",
     *     operationId="getWorkExperienceDetail",
     *     summary="Get detail work experience",
     *     tags={"Work Experience"},
     *     description="Get detail work experience",
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
    public function getWorkExperienceDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_workExperienceServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'company' => $entity->company,
                        'business_type' => $entity->business_type,
                        'position' => $entity->position,
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
     *     path="/work-experience/create",
     *     operationId="postWorkExperienceCreate",
     *     summary="Create work experience",
     *     tags={"Work Experience"},
     *     description="Create work experience",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateWorkExperienceEloquent")
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
    public function postWorkExperienceCreate(Request $request)
    {
        $workExperience = $this->_workExperienceServiceInterface->newInstance();

        $workExperience->employee_id = $request->input('employee_id');
        $workExperience->company = $request->input('company');
        $workExperience->business_type = $request->input('business_type');
        $workExperience->position = $request->input('position');
        $workExperience->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $workExperience->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;

        $this->setRequestAuthor($workExperience);

        $response = $this->_workExperienceServiceInterface->create($workExperience);
        $workExperienceCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $workExperienceCreated);
    }

    /**
     * @OA\Put(
     *     path="/work-experience/update",
     *     operationId="putWorkExperienceUpdate",
     *     summary="Update work experience",
     *     tags={"Work Experience"},
     *     description="Update work experience",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateWorkExperienceEloquent")
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
    public function putWorkExperienceUpdate(Request $request)
    {
        $workExperience = $this->_workExperienceServiceInterface->find($request->input('id'));

        $result = $workExperience->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->company = $request->input('company');
        $result->business_type = $request->input('business_type');
        $result->position = $request->input('position');
        $result->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $result->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;

        $this->setRequestAuthor($result);

        $response = $this->_workExperienceServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/work-experience/delete/{id}",
     *     operationId="deleteWorkExperience",
     *     summary="Delete work experience",
     *     tags={"Work Experience"},
     *     description="Delete work experience",
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
    public function deleteWorkExperience(int $id)
    {
        $workExperience = $this->_workExperienceServiceInterface->find($id);

        $result = $workExperience->getObject();

        $response = $this->_workExperienceServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/work-experience/deletes",
     *     operationId="deleteBulkWorkExperience",
     *     summary="Delete bulk work experience",
     *     tags={"Work Experience"},
     *     description="Delete bulk work experience",
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
    public function deleteBulkWorkExperience(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_workExperienceServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/work-experience/list-search/export",
     *     operationId="postWorkExperienceListSearchExport",
     *     summary="Export list of work experience",
     *     tags={"Work Experience"},
     *     description="Export list of work experience",
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
     *                  @OA\Property(
     *                      property="company_id",
     *                      description="Company id property",
     *                      type="integer",
     *                      format="int64",
     *                      example=1
     *                  ),
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/WorkExperienceEloquent/properties/employee_id"),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date property",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postWorkExperienceListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $date = ($request->input('date') ? new DateTime($request->input('date')) : null);

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $date,
            [$this->_workExperienceServiceInterface, 'workExperienceListSearch'],
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

        if (Excel::store(new WorkExperienceExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.employee.work-experience', ['workExperiences' => $entities])
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
