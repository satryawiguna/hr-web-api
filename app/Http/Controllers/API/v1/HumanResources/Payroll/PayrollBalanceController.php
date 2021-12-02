<?php

namespace App\Http\Controllers\API\v1\HumanResources\Payroll;

use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class PayrollBalanceController extends Controller
{
    use BaseController;

    
    //<editor-fold desc="#field">

    private $_payrollBalanceServiceInterface;

    //</editor-fold>
    

    //<editor-fold desc="#constructor">

    public function __construct(PayrollBalanceServiceInterface $payrollBalanceServiceInterface)
    {
        $this->_payrollBalanceServiceInterface = $payrollBalanceServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/payroll-balance/list",
     *     operationId="getPayrollBalanceList",
     *     summary="Get list of payroll balance",
     *     tags={"Payroll Balance"},
     *     description="Return payroll balances",
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
     * Return list of payroll balance
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollBalanceList()
    {
        return $this->getListJson([$this->_payrollBalanceServiceInterface, 'payrollBalanceList'],
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
     *     path="/payroll-balance/list-search",
     *     operationId="postPayrollBalanceListSearch",
     *     summary="Get list of payroll balance by query parameter",
     *     tags={"Payroll Balance"},
     *     description="Return payroll balances",
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
     *                      description="Filter (name, slug, description) of payroll balance by query parameter",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPayrollBalanceListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            [$this->_payrollBalanceServiceInterface, 'payrollBalanceListSearch'],
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
     *     path="/payroll-balance/page-search",
     *     operationId="postPayrollBalancePageSearch",
     *     summary="Get list of payroll balance by search parameter",
     *     tags={"Payroll Balance"},
     *     description="Return payroll balances",
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
     *                      description="Filter (name, slug, description) of payroll balance by search parameter",
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
     * Return page of payroll balance by search
     *
     * @param Request $request
     * @return mixed
     */
    public function postPayrollBalancePageSearch(Request $request)
    {
        return $this->getPagedSearchJson($request,
            [$this->_payrollBalanceServiceInterface, 'payrollBalancePageSearch'],
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
     *     path="/payroll-balance/detail/{id}",
     *     operationId="getPayrollBalanceDetail",
     *     summary="Get detail payroll balance by id",
     *     tags={"Payroll Balance"},
     *     description="Return payroll balance",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Filter id of payroll balance by id parameter",
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
     * Return detail of payroll balance
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollBalanceDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_payrollBalanceServiceInterface, 'find'],
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
     *     path="/payroll-balance/create",
     *     operationId="postPayrollBalanceCreate",
     *     summary="Create payroll balance",
     *     tags={"Payroll Balance"},
     *     description="Return id of payroll balance created",
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
     *                      description="Name of payroll balance",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="slug",
     *                      description="Slug of payroll balance",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Description of payroll balance",
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
     * Return id of payroll balance created
     *
     * @param Request $request
     * @return mixed
     */
    public function postPayrollBalanceCreate(Request $request)
    {
        $payrollBalance = $this->_payrollBalanceServiceInterface->newInstance();

        $payrollBalance->name = $request->input('name');
        $payrollBalance->slug = $request->input('slug');
        $payrollBalance->description = $request->input('description');

        $this->setRequestAuthor($payrollBalance);

        $response = $this->_payrollBalanceServiceInterface->create($payrollBalance);
        $payrollBalanceCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $payrollBalanceCreated);
    }

    /**
     * @OA\Put(
     *     path="/payroll-balance/update",
     *     operationId="putPayrollBalanceUpdate",
     *     summary="Update payroll balance",
     *     tags={"Payroll Balance"},
     *     description="Return object of payroll balance updated",
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
     *                      description="ID of payroll balance",
     *                      type="integer",
     *                      format="int64"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name of payroll balance",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="slug",
     *                      description="Slug of payroll balance",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Description of payroll balance",
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
     * Return object of payroll balance updated
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putPayrollBalanceUpdate(Request $request)
    {
        $payrollBalance = $this->_payrollBalanceServiceInterface->find($request->input('id'));

        $result = $payrollBalance->_dto;

        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->description = $request->input('description');

        $this->setRequestAuthor($result);

        $response = $this->_payrollBalanceServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/payroll-balance/delete/{id}",
     *     operationId="deletePayrollBalance",
     *     summary="Delete payroll balance",
     *     tags={"Payroll Balance"},
     *     description="Return object of payroll balance deleted",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of payroll balance",
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
     * Return object of payroll balance deleted
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePayrollBalance(int $id)
    {
        $payrollBalance = $this->_payrollBalanceServiceInterface->find($id);

        $result = $payrollBalance->_dto;

        $response = $this->_payrollBalanceServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/payroll-balance/slug/{name}",
     *     operationId="getPayrollBalanceSlug",
     *     summary="Get slug of payroll balance",
     *     tags={"Payroll Balance"},
     *     description="Return slug of payroll balance",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name of payroll balance",
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
     * Return slug of payroll balance
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollBalanceSlug(string $name)
    {
        return $this->getSlugObjectJson($name,
            [$this->_payrollBalanceServiceInterface, 'payrollBalanceSlug'],
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
        $payrollBalance = $this->_payrollBalanceServiceInterface->newInstance();
        $payrollBalance->name = $name;

        $response = $searchMethod($payrollBalance);
        $rowJsonData = $dtoObjectToJsonMethod($response->_dto);

        $jsonData = response()->json($rowJsonData);

        return $jsonData;
    }

    //</editor-fold>
}
