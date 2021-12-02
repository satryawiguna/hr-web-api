<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal;

use App\Core\Services\Response\BooleanResponse;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeInterface;
use App\Domains\HumanResources\Personal\WorkAgreementLetter\Contracts\Request\CreateWorkAgreementLetterRequest;
use App\Domains\HumanResources\Personal\WorkAgreementLetter\Contracts\Request\EditWorkAgreementLetterRequest;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterServiceInterface;
use App\Exports\HumanResources\Personal\WorkAgreementLetterExport;
use App\Http\Controllers\BaseController;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class WorkAgreementLetterController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_workAgreementLetterServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * WorkAgreementLetterController constructor.
     * @param WorkAgreementLetterServiceInterface $workAgreementLetterServiceInterface
     */
    public function __construct(WorkAgreementLetterServiceInterface $workAgreementLetterServiceInterface)
    {
        $this->_workAgreementLetterServiceInterface = $workAgreementLetterServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/work-agreement-letter/list",
     *     operationId="getWorkAgreementLetterList",
     *     summary="Get list of work agreement letter",
     *     tags={"Work Agreement Letter"},
     *     description="Get list of work agreement letter",
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
     *          name="letter_type_id",
     *          in="query",
     *          description="Letter type id parameter",
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
     * @throws \Exception
     */
    public function getWorkAgreementLetterList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $letterTypeId = $request->get('letter_type_id');
        $date = new DateTime($request->get('date'));

        return $this->getListJson($companyId, $employeeId, $letterTypeId, $date,
            [$this->_workAgreementLetterServiceInterface, 'workAgreementLetterList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'letter_type' => $this->getLetterTypeObject($entity->letter_type),
                        'reference_number' => $entity->reference_number,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/work-agreement-letter/list-search",
     *     operationId="postWorkAgreementLetterListSearch",
     *     summary="Get list of work agreement letter with query search",
     *     tags={"Work Agreement Letter"},
     *     description="Get list of work agreement letter with query search",
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
     *                      description="Query property (Keyword would be filter reference_number and description)",
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
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/employee_id"),
     *                  @OA\Property(property="letter_type_id", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/letter_type_id"),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date parameter",
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
     * @throws \Exception
     */
    public function postWorkAgreementLetterListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $letterTypeId = $request->input('letter_type_id');
        $date = new DateTime($request->input('date'));

        return $this->getListSearchJson($request, $companyId, $employeeId, $letterTypeId, $date,
            [$this->_workAgreementLetterServiceInterface, 'workAgreementLetterListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'letter_type' => $this->getLetterTypeObject($entity->letter_type),
                        'reference_number' => $entity->reference_number,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/work-agreement-letter/page-search",
     *     operationId="postWorkAgreementLetterPageSearch",
     *     summary="Get list of work agreement letter with query and page parameter search",
     *     tags={"Work Agreement Letter"},
     *     description="Get list of work agreement letter with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter reference_number and description)",
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
     *                          @OA\Property(property="employee_id", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/employee_id"),
     *                          @OA\Property(property="letter_type_id", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/letter_type_id"),
     *                          @OA\Property(
     *                              property="date",
     *                              description="Date property",
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
     * @throws \Exception
     */
    public function postWorkAgreementLetterPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $letterTypeId = $request->input('letter_type_id');
        $date = new DateTime($request->input('date'));

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $letterTypeId, $date,
            [$this->_workAgreementLetterServiceInterface, 'workAgreementLetterPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'letter_type' => $this->getLetterTypeObject($entity->letter_type),
                        'reference_number' => $entity->reference_number,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/work-agreement-letter/detail/{id}",
     *     operationId="getWorkAgreementLetterDetail",
     *     summary="Get detail work agreement letter",
     *     tags={"Work Agreement Letter"},
     *     description="Get detail work agreement letter",
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
    public function getWorkAgreementLetterDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_workAgreementLetterServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'letter_type' => $this->getLetterTypeObject($entity->letter_type),
                        'reference_number' => $entity->reference_number,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,

                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/work-agreement-letter/create",
     *     operationId="postWorkAgreementLetterCreate",
     *     summary="Create work agreement letter",
     *     tags={"Work Agreement Letter"},
     *     description="Create work agreement letter",
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
     *                      @OA\Schema(ref="#/components/schemas/CreateWorkAgreementLetterEloquent"),
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
     *                                      example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="pivot",
     *                                      description="Pivot property",
     *                                      @OA\Property(
     *                                          property="attribute",
     *                                          type="string",
     *                                          example="document"
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                      )
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
     * @throws \Exception
     */
    public function postWorkAgreementLetterCreate(Request $request)
    {
        $createWorkAgreementLetterRequest = new CreateWorkAgreementLetterRequest();

        $createWorkAgreementLetterRequest->employee_id      = $request->input('employee_id');
        $createWorkAgreementLetterRequest->letter_type_id   = $request->input('letter_type_id');
        $createWorkAgreementLetterRequest->reference_number = $request->input('reference_number');
        $createWorkAgreementLetterRequest->start_date       = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $createWorkAgreementLetterRequest->end_date         = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;

        //Many to many
        $createWorkAgreementLetterRequest->media_libraries  = $request->input('media_libraries');

        $this->setRequestAuthor($createWorkAgreementLetterRequest);

        $response = $this->_workAgreementLetterServiceInterface->create($createWorkAgreementLetterRequest);
        $workAgreementLetterCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $workAgreementLetterCreated);
    }

    /**
     * @OA\Put(
     *     path="/work-agreement-letter/update",
     *     operationId="putWorkAgreementLetterUpdate",
     *     summary="Update work agreement letter",
     *     tags={"Work Agreement Letter"},
     *     description="Update work agreement letter",
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
     *                      @OA\Schema(ref="#/components/schemas/UpdateWorkAgreementLetterEloquent"),
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
     *                                      example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="pivot",
     *                                      description="Pivot property",
     *                                      @OA\Property(
     *                                          property="attribute",
     *                                          type="string",
     *                                          example="document"
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                      )
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
     * @throws \Exception
     */
    public function putWorkAgreementLetterUpdate(Request $request)
    {
        $editWorkAgreementLetterRequest = new EditWorkAgreementLetterRequest();

        $editWorkAgreementLetterRequest->employee_id = $request->input('employee_id');
        $editWorkAgreementLetterRequest->letter_type_id = $request->input('letter_type_id');
        $editWorkAgreementLetterRequest->reference_number = $request->input('reference_number');
        $editWorkAgreementLetterRequest->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $editWorkAgreementLetterRequest->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;

        //Many to many
        $editWorkAgreementLetterRequest->media_libraries = $request->input('media_libraries');

        $this->setRequestAuthor($editWorkAgreementLetterRequest);

        $response = $this->_workAgreementLetterServiceInterface->update($editWorkAgreementLetterRequest);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/work-agreement-letter/delete/{id}",
     *     operationId="deleteWorkAgreementLetter",
     *     summary="Delete work agreement letter",
     *     tags={"Work Agreement Letter"},
     *     description="Delete work agreement letter",
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
    public function deleteWorkAgreementLetter(int $id)
    {
        $response = $this->_workAgreementLetterServiceInterface->delete($id);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/work-agreement-letter/deletes",
     *     operationId="deleteBulkWorkAgreementLetter",
     *     summary="Delete bulk work agreement letter",
     *     tags={"Work Agreement Letter"},
     *     description="Delete bulk work agreement letter",
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
    public function deleteBulkWorkAgreementLetter(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_workAgreementLetterServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/work-agreement-letter/list-search/export",
     *     operationId="postWorkAgreementLetterListSearchExport",
     *     summary="Export list of work agreement letter",
     *     tags={"Work Agreement Letter"},
     *     description="Export list of work agreement letter",
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
     *                      property="query",
     *                      description="Query property (Keyword would be filter reference_number and description)",
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
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/employee_id"),
     *                  @OA\Property(property="letter_type_id", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/letter_type_id"),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date parameter",
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
     * @throws \Exception
     */
    public function postWorkAgreementLetterListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $letterTypeId = $request->input('letter_type_id');
        $date = new DateTime($request->input('date'));

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $letterTypeId, $date,
            [$this->_workAgreementLetterServiceInterface, 'workAgreementLetterListSearch'],
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

        if (Excel::store(new WorkAgreementLetterExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.work-agreement-letter', ['workAgreementLetters' => $entities])
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
     * @param int|null $competenceId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, int $competenceId = null, DateTime $date = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $competenceId, $date);
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
     * @param int|null $competenceId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $competenceId = null, DateTime $date = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $competenceId, $date);
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
     * @param int|null $letterTypeId
     * @param object|null $registrationLetterRangeDate
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, int $employeeId = null, int $letterTypeId = null, object $registrationLetterRangeDate = null,
                                             callable $searchMethod,
                                             callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $letterTypeId, $registrationLetterRangeDate);
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
     * @param int|null $competenceId
     * @param DateTime|null $date
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $competenceId = null, DateTime $date = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $competenceId, $date);
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
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param LetterTypeInterface $entity
     * @return Collection
     */
    private function getLetterTypeObject(LetterTypeInterface $entity)
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
