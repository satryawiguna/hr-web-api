<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal\Employee;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildServiceInterface;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\Commons\Gender\Contracts\GenderInterface;
use App\Exports\HumanResources\Personal\Employee\ChildExport;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ChildController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_childServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * ChildController constructor.
     * @param ChildServiceInterface $childServiceInterface
     */
    public function __construct(ChildServiceInterface $childServiceInterface)
    {
        $this->_childServiceInterface = $childServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/child/list",
     *     operationId="getChildList",
     *     summary="Get list of child",
     *     tags={"Child"},
     *     description="Get list of child",
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
     *          name="gender_id",
     *          in="query",
     *          description="Gender id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_birth_date",
     *          in="query",
     *          description="Start birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_birth_date",
     *          in="query",
     *          description="End birth date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_bpjs_kesehatan_date",
     *          in="query",
     *          description="Start bpjs kesehatan date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_bpjs_kesehatan_date",
     *          in="query",
     *          description="End bpjs kesehatan date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bpjs_kesehatan_class",
     *          in="query",
     *          description="BPJS kesehatan class parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"I","II","III"},
     *              default=""
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
    public function getChildList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $genderId = $request->get('gender_id');
        $rangeBirthDate = new DateTimeRange($request->get('start_birth_date'), $request->get('end_birth_date'));
        $rangeBPJSKesehatanDate = new DateTimeRange($request->get('start_bpjs_kesehatan_date'), $request->get('end_bpjs_kesehatan_date'));
        $bpjsKesehatanClass = $request->get('bpjs_kesehatan_class');

        return $this->getListJson($companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass,
            [$this->_childServiceInterface, 'childList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => $this->getGenderObject($entity->gender),
                        'order' => $entity->order,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/child/list-search",
     *     operationId="postChildListSearch",
     *     summary="Get list of child with query search",
     *     tags={"Child"},
     *     description="Get list of child with query search",
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
     *                      property="query",
     *                      description="Query property (Keyword would be filter full_name, nick_name, birth_place and bpjs_kesehatan_number)",
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
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/ChildEloquent/properties/employee_id"),
     *                  @OA\Property(property="gender_id", ref="#/components/schemas/ChildEloquent/properties/gender_id"),
     *                  @OA\Property(
     *                      property="start_birth_date",
     *                      description="Start birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_birth_date",
     *                      description="End birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_bpjs_kesehatan_date",
     *                      description="Start bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_bpjs_kesehatan_date",
     *                      description="End bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/ChildEloquent/properties/bpjs_kesehatan_class")
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
    public function postChildListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $genderId = $request->input('gender_id');
        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));
        $rangeBPJSKesehatanDate = new DateTimeRange($request->get('start_bpjs_kesehatan_date'), $request->get('end_bpjs_kesehatan_date'));
        $bpjsKesehatanClass = $request->input('bpjs_kesehatan_class');

        return $this->getListSearchJson($request, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass,
            [$this->_childServiceInterface, 'childListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => $this->getGenderObject($entity->gender),
                        'order' => $entity->order,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/child/page-search",
     *     operationId="postChildPageSearch",
     *     summary="Get list of child with query and page parameter search",
     *     tags={"Child"},
     *     description="Get list of child with query and page parameter search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="query",
     *                              description="Query property (Keyword would be filter full_name, nick_name, birth_place and bpjs_kesehatan_number)",
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
     *                          @OA\Property(property="employee_id", ref="#/components/schemas/ChildEloquent/properties/employee_id"),
     *                          @OA\Property(property="gender_id", ref="#/components/schemas/ChildEloquent/properties/gender_id"),
     *                          @OA\Property(
     *                              property="start_birth_date",
     *                              description="Start birth date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_birth_date",
     *                              description="End birth date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_bpjs_kesehatan_date",
     *                              description="Start bpjs kesehatan date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_bpjs_kesehatan_date",
     *                              description="End bpjs kesehatan date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/ChildEloquent/properties/bpjs_kesehatan_class")
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
    public function postChildPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $genderId = $request->input('gender_id');
        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));
        $rangeBPJSKesehatanDate = new DateTimeRange($request->get('start_bpjs_kesehatan_date'), $request->get('end_bpjs_kesehatan_date'));
        $bpjsKesehatanClass = $request->input('bpjs_kesehatan_class');

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass,
            [$this->_childServiceInterface, 'childPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => $this->getGenderObject($entity->gender),
                        'order' => $entity->order,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/child/detail/{id}",
     *     operationId="getChildDetail",
     *     summary="Get detail child",
     *     tags={"Child"},
     *     description="Get detail child",
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
    public function getChildDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_childServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'gender' => $this->getGenderObject($entity->gender),
                        'order' => $entity->order,
                        'birth_place' => $entity->birth_place,
                        'birth_date' => $entity->birth_date,
                        'has_bpjs_kesehatan' => $entity->has_bpjs_kesehatan,
                        'bpjs_kesehatan_date' => $entity->bpjs_kesehatan_date,
                        'bpjs_kesehatan_number' => $entity->bpjs_kesehatan_number,
                        'bpjs_kesehatan_class' => $entity->bpjs_kesehatan_class,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/child/create",
     *     operationId="postChildCreate",
     *     summary="Create child",
     *     tags={"Child"},
     *     description="Create child",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateChildEloquent")
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
    public function postChildCreate(Request $request)
    {
        $child = $this->_childServiceInterface->newInstance();

        $child->employee_id = $request->input('employee_id');
        $child->full_name = $request->input('full_name');
        $child->nick_name = $request->input('nick_name');
        $child->gender_id = $request->input('gender_id');
        $child->order = $request->input('order');
        $child->birth_place = $request->input('birth_place');
        $child->birth_date = ($request->input('birth_date')) ? new DateTime($request->input('birth_date')) : null;
        $child->has_bpjs_kesehatan = (boolean)$request->input('has_bpjs_kesehatan');
        $child->bpjs_kesehatan_date = ($request->input('bpjs_kesehatan_date')) ? new DateTime($request->input('bpjs_kesehatan_date')) : null;
        $child->bpjs_kesehatan_number = $request->input('bpjs_kesehatan_number');
        $child->bpjs_kesehatan_class = $request->input('bpjs_kesehatan_class');

        $this->setRequestAuthor($child);

        $response = $this->_childServiceInterface->create($child);
        $childCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $childCreated);
    }

    /**
     * @OA\Put(
     *     path="/child/update",
     *     operationId="putChildUpdate",
     *     summary="Update child",
     *     tags={"Child"},
     *     description="Update child",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateChildEloquent")
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
    public function putChildUpdate(Request $request)
    {
        $child = $this->_childServiceInterface->find($request->input('id'));

        $result = $child->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->full_name = $request->input('full_name');
        $result->nick_name = $request->input('nick_name');
        $result->gender_id = $request->input('gender_id');
        $result->order = $request->input('order');
        $result->birth_place = $request->input('birth_place');
        $result->birth_date = ($request->input('birth_date')) ? new DateTime($request->input('birth_date')) : null;
        $result->has_bpjs_kesehatan = (boolean)$request->input('has_bpjs_kesehatan');
        $result->bpjs_kesehatan_date = ($request->input('bpjs_kesehatan_date')) ? new DateTime($request->input('bpjs_kesehatan_date')) : null;
        $result->bpjs_kesehatan_number = $request->input('bpjs_kesehatan_number');
        $result->bpjs_kesehatan_class = $request->input('bpjs_kesehatan_class');

        $this->setRequestAuthor($result);

        $response = $this->_childServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/child/delete/{id}",
     *     operationId="deleteChild",
     *     summary="Delete child",
     *     tags={"Child"},
     *     description="Delete child",
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
    public function deleteChild(int $id)
    {
        $child = $this->_childServiceInterface->find($id);

        $result = $child->getObject();

        $response = $this->_childServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/child/deletes",
     *     operationId="deleteBulkChild",
     *     summary="Delete bulk child",
     *     tags={"Child"},
     *     description="Delete bulk child",
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
    public function deleteBulkChild(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_childServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/child/list-search/export",
     *     operationId="postChildListSearchExport",
     *     summary="Export list of child",
     *     tags={"Child"},
     *     description="Export list of child",
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
     *                  @OA\Property(property="employee_id", ref="#/components/schemas/ChildEloquent/properties/employee_id"),
     *                  @OA\Property(property="gender_id", ref="#/components/schemas/ChildEloquent/properties/gender_id"),
     *                  @OA\Property(
     *                      property="start_birth_date",
     *                      description="Start birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_birth_date",
     *                      description="End birth date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_bpjs_kesehatan_date",
     *                      description="Start bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_bpjs_kesehatan_date",
     *                      description="End bpjs kesehatan date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(property="bpjs_kesehatan_class", ref="#/components/schemas/ChildEloquent/properties/bpjs_kesehatan_class")
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
    public function postChildListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $genderId = $request->input('gender_id');
        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));
        $rangeBPJSKesehatanDate = new DateTimeRange($request->get('start_bpjs_kesehatan_date'), $request->get('end_bpjs_kesehatan_date'));
        $bpjsKesehatanClass = $request->input('bpjs_kesehatan_class');

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass,
            [$this->_childServiceInterface, 'childListSearch'],
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

        if (Excel::store(new ChildExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.employee.child', ['childs' => $entities])
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
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string $bpjsKesehatanClass
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass);
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
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass);
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
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null,
                                                   callable $searchMethod,
                                                   callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass);
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
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate, string $bpjsKesehatanClass = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass);
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
     * @param GenderInterface $entity
     * @return Collection
     */
    private function getGenderObject(GenderInterface $entity)
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
