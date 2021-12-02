<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\MasterData\LetterType\Contracts\LetterTypeInterface;
use App\Domains\HumanResources\Personal\RegistrationLetter\Contracts\Request\CreateRegistrationLetterRequest;
use App\Domains\HumanResources\Personal\RegistrationLetter\Contracts\Request\EditRegistrationLetterRequest;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterServiceInterface;
use App\Exports\HumanResources\Personal\RegistrationLetterExport;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class RegistrationLetterController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_registrationLetterServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * RegistrationLetterController constructor.
     * @param RegistrationLetterServiceInterface $registrationLetterServiceInterface
     */
    public function __construct(RegistrationLetterServiceInterface $registrationLetterServiceInterface)
    {
        $this->_registrationLetterServiceInterface = $registrationLetterServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/registration-letter/list",
     *     operationId="getRegistrationLetterList",
     *     summary="Get list of registration letter",
     *     tags={"Registration Letter"},
     *     description="Get list of registration letter",
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
     * @throws Exception
     */
    public function getRegistrationLetterList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $letterTypeId = $request->get('letter_type_id');
        $date = new DateTime($request->get('date'));

        return $this->getListJson($companyId, $employeeId, $letterTypeId, $date,
            [$this->_registrationLetterServiceInterface, 'registrationLetterList'],
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
     *     path="/registration-letter/list-search",
     *     operationId="postRegistrationLetterListSearch",
     *     summary="Get list of registration letter with query search",
     *     tags={"Registration Letter"},
     *     description="Get list of registration letter with query search",
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
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/RegistrationLetterEloquent/properties/employee_id"),
     *                  @OA\Property(property="letter_type_id", ref="#/components/schemas/RegistrationLetterEloquent/properties/letter_type_id"),
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
     * @throws Exception
     */
    public function postRegistrationLetterListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $letterTypeId = $request->input('letter_type_id');
        $date = new DateTime($request->input('date'));

        return $this->getListSearchJson($request, $companyId, $employeeId, $letterTypeId, $date,
            [$this->_registrationLetterServiceInterface, 'registrationLetterListSearch'],
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
     *     path="/registration-letter/page-search",
     *     operationId="postRegistrationLetterPageSearch",
     *     summary="Get list of registration letter with query and page parameter search",
     *     tags={"Registration Letter"},
     *     description="Get list of registration letter with query and page parameter search",
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
     *                          @OA\Property(property="employee_id", ref="#/components/schemas/RegistrationLetterEloquent/properties/employee_id"),
     *                          @OA\Property(property="letter_type_id", ref="#/components/schemas/RegistrationLetterEloquent/properties/letter_type_id"),
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
     * @throws Exception
     */
    public function postRegistrationLetterPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $letterTypeId = $request->input('letter_type_id');
        $date = new DateTime($request->input('date'));

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $letterTypeId, $date,
            [$this->_registrationLetterServiceInterface, 'registrationLetterPageSearch'],
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
     *     path="/registration-letter/detail/{id}",
     *     operationId="getRegistrationLetterDetail",
     *     summary="Get detail registration letter",
     *     tags={"Registration Letter"},
     *     description="Get detail registration letter",
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
    public function getRegistrationLetterDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_registrationLetterServiceInterface, 'find'],
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
     *     path="/registration-letter/create",
     *     operationId="postRegistrationLetterCreate",
     *     summary="Create registration letter",
     *     tags={"Registration Letter"},
     *     description="Create registration letter",
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
     *                      @OA\Schema(ref="#/components/schemas/CreateRegistrationLetterEloquent"),
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
*    *                  }
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
    public function postRegistrationLetterCreate(Request $request)
    {
        $createRegistrationLetterRequest = new CreateRegistrationLetterRequest();

        $createRegistrationLetterRequest->employee_id        = $request->input('employee_id');
        $createRegistrationLetterRequest->letter_type_id     = $request->input('letter_type_id');
        $createRegistrationLetterRequest->reference_number   = $request->input('reference_number');
        $createRegistrationLetterRequest->start_date         = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $createRegistrationLetterRequest->end_date           = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;
        $createRegistrationLetterRequest->description        = $request->input('description');

        //Many to many
        $createRegistrationLetterRequest->media_libraries  = $request->input('media_libraries');

        $this->setRequestAuthor($createRegistrationLetterRequest);

        $response = $this->_registrationLetterServiceInterface->create($createRegistrationLetterRequest);
        $registrationLetterCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $registrationLetterCreated);
    }

    /**
     * @OA\Put(
     *     path="/registration-letter/update",
     *     operationId="putRegistrationLetterUpdate",
     *     summary="Update registration letter",
     *     tags={"Registration Letter"},
     *     description="Update registration letter",
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
     *                      @OA\Schema(ref="#/components/schemas/UpdateRegistrationLetterEloquent"),
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
     * @throws Exception
     */
    public function putRegistrationLetterUpdate(Request $request)
    {
        $editRegistrationLetterRequest = new EditRegistrationLetterRequest();

        $editRegistrationLetterRequest->employee_id = $request->input('employee_id');
        $editRegistrationLetterRequest->letter_type_id = $request->input('letter_type_id');
        $editRegistrationLetterRequest->reference_number = $request->input('reference_number');
        $editRegistrationLetterRequest->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $editRegistrationLetterRequest->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;
        $editRegistrationLetterRequest->description = $request->input('description');

        //Many to many
        $editRegistrationLetterRequest->media_libraries = $request->input('media_libraries');

        $this->setRequestAuthor($editRegistrationLetterRequest);

        $response = $this->_registrationLetterServiceInterface->update($editRegistrationLetterRequest);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/registration-letter/delete/{id}",
     *     operationId="deleteRegistrationLetter",
     *     summary="Delete registration letter",
     *     tags={"Registration Letter"},
     *     description="Delete registration letter",
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
    public function deleteRegistrationLetter(int $id)
    {
        $response = $this->_registrationLetterServiceInterface->delete($id);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/registration-letter/deletes",
     *     operationId="deleteBulkRegistrationLetter",
     *     summary="Delete bulk registration letter",
     *     tags={"Registration Letter"},
     *     description="Delete bulk registration letter",
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
    public function deleteBulkRegistrationLetter(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_registrationLetterServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/registration-letter/list-search/export",
     *     operationId="postRegistrationLetterListSearchExport",
     *     summary="Export list of registration letter",
     *     tags={"Registration Letter"},
     *     description="Export list of registration letter",
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
     *                 @OA\Property(
     *                      property="company_id",
     *                      description="Company id property",
     *                      type="integer",
     *                      format="int64",
     *                      example=1
     *                  ),
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/RegistrationLetterEloquent/properties/employee_id"),
     *                  @OA\Property(property="letter_type_id", ref="#/components/schemas/RegistrationLetterEloquent/properties/letter_type_id"),
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
     * @throws Exception
     */
    public function postRegistrationLetterListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $letterTypeId = $request->input('letter_type_id');
        $date = new DateTime($request->input('date'));

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $letterTypeId, $date,
            [$this->_registrationLetterServiceInterface, 'registrationLetterListSearch'],
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

        if (Excel::store(new RegistrationLetterExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.registration-letter', ['registrationLetters' => $entities])
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
     * @param int|null $letterTypeId
     * @param object|null $registrationLetterRangeDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, int $letterTypeId = null, object $registrationLetterRangeDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $letterTypeId, $registrationLetterRangeDate);
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
     * @param int|null $letterTypeId
     * @param object|null $registrationLetterRangeDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $letterTypeId = null, object $registrationLetterRangeDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $letterTypeId, $registrationLetterRangeDate);
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
     * @param int|null $letterTypeId
     * @param object|null $registrationLetterRangeDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $letterTypeId = null, object $registrationLetterRangeDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $letterTypeId, $registrationLetterRangeDate);
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
