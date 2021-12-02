<?php

namespace App\Http\Controllers\API\v1\Commons;

use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class PayrollProcessTypeController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_payrollProcessTypeServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    public function __construct(PayrollProcessTypeServiceInterface $payrollProcessTypeServiceInterface)
    {
        $this->_payrollProcessTypeServiceInterface = $payrollProcessTypeServiceInterface;
    }

    //</editor-fold>

    
    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/payroll-process-type/list",
     *     operationId="getPayrollProcessTypeList",
     *     summary="Get list of payroll process type",
     *     tags={"Payroll Process Type"},
     *     description="Return payroll process types",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
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
     * Return list of payroll process type
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollProcessTypeList()
    {
        return $this->getListJson([$this->_payrollProcessTypeServiceInterface, 'payrollProcessTypeList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/payroll-process-type/list-search",
     *     operationId="postPayrollProcessTypeListSearch",
     *     summary="Get list of payroll process type by query parameter",
     *     tags={"Payroll Process Type"},
     *     description="Return payroll process types",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Filter (name, slug, description) of payroll process type by query parameter",
     *                      type="string"
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
     * Return list of payroll process type by query
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPayrollProcessTypeListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            [$this->_payrollProcessTypeServiceInterface, 'payrollProcessTypeListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/payroll-process-type/page-search",
     *     operationId="postPayrollProcessTypePageSearch",
     *     summary="Get list of payroll process type by search parameter",
     *     tags={"Payroll Process Type"},
     *     description="Return payroll process types",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="search",
     *                      description="Filter (name, slug, description) of payroll process type by search parameter",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="pagination[page]",
     *                      description="Position of page",
     *                      type="integer",
     *                      format="int32"
     *                  ),
     *                  @OA\Property(
     *                      property="pagination[perpage]",
     *                      description="Total of row per page",
     *                      type="integer",
     *                      format="int32"
     *                  ),
     *                  @OA\Property(
     *                      property="sort[sort]",
     *                      description="Type of sort. ASC or DESC",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="sort[field]",
     *                      description="Field name to be filter",
     *                      type="string"
     *                  ),
     *                  required={
     *                      "pagination[page]",
     *                      "pagination[perpage]",
     *                      "sort[sort]",
     *                      "sort[field]"
     *                  },
     *                  example={
     *                      "pagination[page]": 10,
     *                      "pagination[perpage]": 10,
     *                      "sort[sort]": "DESC",
     *                      "sort[field]": "name"
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
     * Return page of payroll process type by search
     *
     * @param Request $request
     * @return mixed
     */
    public function postPayrollProcessTypePageSearch(Request $request)
    {
        return $this->getPagedSearchJson($request,
            [$this->_payrollProcessTypeServiceInterface, 'payrollProcessTypePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/payroll-process-type/detail/{id}",
     *     operationId="getPayrollProcessTypeDetail",
     *     summary="Get detail payroll process type by id",
     *     tags={"Payroll Process Type"},
     *     description="Return payroll process type",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Filter id of payroll process type by id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
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
     * Return detail of payroll process type
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollProcessTypeDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_payrollProcessTypeServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/payroll-process-type/create",
     *     operationId="postPayrollProcessTypeCreate",
     *     summary="Create payroll process type",
     *     tags={"Payroll Process Type"},
     *     description="Return id of payroll process type created",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name of payroll process type",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="slug",
     *                      description="Slug of payroll process type",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Description of payroll process type",
     *                      type="string"
     *                  ),
     *                  required={
     *                      "name",
     *                      "slug"
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
     * Return id of payroll process type created
     *
     * @param Request $request
     * @return mixed
     */
    public function postPayrollProcessTypeCreate(Request $request)
    {
        $payrollProcessType = $this->_payrollProcessTypeServiceInterface->newInstance();

        $payrollProcessType->name = $request->input('name');
        $payrollProcessType->slug = $request->input('slug');
        $payrollProcessType->description = $request->input('description');

        $this->setRequestAuthor($payrollProcessType);

        $response = $this->_payrollProcessTypeServiceInterface->create($payrollProcessType);
        $payrollProcessTypeCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $payrollProcessTypeCreated);
    }

    /**
     * @OA\Put(
     *     path="/payroll-process-type/update",
     *     operationId="putPayrollProcessTypeUpdate",
     *     summary="Update payroll process type",
     *     tags={"Payroll Process Type"},
     *     description="Return object of payroll process type updated",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      description="ID of payroll process type",
     *                      type="integer",
     *                      format="int64"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name of payroll process type",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="slug",
     *                      description="Slug of payroll process type",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Description of payroll process type",
     *                      type="string"
     *                  ),
     *                  required={
     *                      "id",
     *                      "name",
     *                      "slug"
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
     * Return object of payroll process type updated
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putPayrollProcessTypeUpdate(Request $request)
    {
        $payrollProcessType = $this->_payrollProcessTypeServiceInterface->find($request->input('id'));

        $result = $payrollProcessType->_dto;

        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->description = $request->input('description');

        $this->setRequestAuthor($result);

        $response = $this->_payrollProcessTypeServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/payroll-process-type/delete/{id}",
     *     operationId="deletePayrollProcessType",
     *     summary="Delete payroll process type",
     *     tags={"Payroll Process Type"},
     *     description="Return object of payroll process type deleted",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of payroll process type",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32"
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
     * Return object of payroll process type deleted
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPayrollProcessTypeDelete(int $id)
    {
        $payrollProcessType = $this->_payrollProcessTypeServiceInterface->find($id);

        $result = $payrollProcessType->_dto;

        $response = $this->_payrollProcessTypeServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/payroll-process-type/slug/{name}",
     *     operationId="getPayrollProcessTypeSlug",
     *     summary="Get slug of payroll process type",
     *     tags={"Payroll Process Type"},
     *     description="Return slug of payroll process type",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name of payroll process type",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
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
     * Return slug of payroll process type
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollProcessTypeSlug(string $name)
    {
        return $this->getSlugObjectJson($name,
            [$this->_payrollProcessTypeServiceInterface, 'payrollProcessTypeSlug'],
            function ($entity) {
                $rowJsonData = new Collection();

                $rowJsonData->push([
                    'slug' => $entity->slug
                ]);

                return $rowJsonData->first();
            });
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

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
        $itemJsonData = $dtoObjectToJsonMethod($response->_dto);

        $jsonData = response()->json($itemJsonData);

        return $jsonData;
    }

    /**
     * @param string $name
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getSlugObjectJson(string $name,
                                       callable $searchMethod,
                                       callable $dtoObjectToJsonMethod)
    {
        $payrollProcessType = $this->_payrollProcessTypeServiceInterface->newInstance();
        $payrollProcessType->name = $name;

        $response = $searchMethod($payrollProcessType);
        $itemJsonData = $dtoObjectToJsonMethod($response->_dto);

        $jsonData = response()->json($itemJsonData);

        return $jsonData;
    }

    //</editor-fold>
}
