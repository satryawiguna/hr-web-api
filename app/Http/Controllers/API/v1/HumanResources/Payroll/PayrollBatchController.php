<?php

namespace App\Http\Controllers\API\v1\Commons;

use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class PayrollBatchController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_payrollBatchServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    public function __construct(PayrollBatchServiceInterface $payrollBatchServiceInterface)
    {
        $this->_payrollBatchServiceInterface = $payrollBatchServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/payroll-batch/list",
     *     operationId="getPayrollBatchList",
     *     summary="Get list of payroll batch",
     *     tags={"Payroll Batch"},
     *     description="Return payroll batches",
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
     * Return list of payroll batch
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollBatchList()
    {
        return $this->getListJson([$this->_payrollBatchServiceInterface, 'payrollBatchList'],
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
     *     path="/payroll-batch/list-search",
     *     operationId="postPayrollBatchListSearch",
     *     summary="Get list of payroll batch by query parameter",
     *     tags={"Payroll Batch"},
     *     description="Return payroll batches",
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
     *                      description="Filter (name, slug, description) of payroll batch by query parameter",
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
     * Return list of payroll batch by query
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPayrollBatchListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            [$this->_payrollBatchServiceInterface, 'payrollBatchListSearch'],
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
     *     path="/payroll-batch/page-search",
     *     operationId="postPayrollBatchPageSearch",
     *     summary="Get list of payroll batch by search parameter",
     *     tags={"Payroll Batch"},
     *     description="Return payroll batches",
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
     *                      description="Filter (name, slug, description) of payroll batch by search parameter",
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
     * Return page of payroll batch by search
     *
     * @param Request $request
     * @return mixed
     */
    public function postPayrollBatchPageSearch(Request $request)
    {
        return $this->getPagedSearchJson($request,
            [$this->_payrollBatchServiceInterface, 'payrollBatchPageSearch'],
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
     *     path="/payroll-batch/detail/{id}",
     *     operationId="getPayrollBatchDetail",
     *     summary="Get detail payroll batch by id",
     *     tags={"Payroll Batch"},
     *     description="Return payroll batch",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Filter id of payroll batch by id parameter",
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
     * Return detail of payroll batch
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollBatchDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_payrollBatchServiceInterface, 'find'],
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
     *     path="/payroll-batch/create",
     *     operationId="postPayrollBatchCreate",
     *     summary="Create payroll batch",
     *     tags={"Payroll Batch"},
     *     description="Return id of payroll batch created",
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
     *                      description="Name of payroll batch",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="slug",
     *                      description="Slug of payroll batch",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Description of payroll batch",
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
     * Return id of payroll batch created
     *
     * @param Request $request
     * @return mixed
     */
    public function postPayrollBatchCreate(Request $request)
    {
        $payrollBatch = $this->_payrollBatchServiceInterface->newInstance();

        $payrollBatch->name = $request->input('name');
        $payrollBatch->slug = $request->input('slug');
        $payrollBatch->description = $request->input('description');

        $this->setRequestAuthor($payrollBatch);

        $response = $this->_payrollBatchServiceInterface->create($payrollBatch);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/payroll-batch/update",
     *     operationId="putPayrollBatchUpdate",
     *     summary="Update payroll batch",
     *     tags={"Payroll Batch"},
     *     description="Return object of payroll batch updated",
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
     *                      description="ID of payroll batch",
     *                      type="integer",
     *                      format="int64"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name of payroll batch",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="slug",
     *                      description="Slug of payroll batch",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Description of payroll batch",
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
     * Return object of payroll batch updated
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putPayrollBatchUpdate(Request $request)
    {
        $payrollBatch = $this->_payrollBatchServiceInterface->find($request->input('id'));

        $result = $payrollBatch->_dto;

        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->description = $request->input('description');

        $this->setRequestAuthor($result);

        $response = $this->_payrollBatchServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/payroll-batch/delete/{id}",
     *     operationId="deletePayrollBatch",
     *     summary="Delete payroll batch",
     *     tags={"Payroll Batch"},
     *     description="Return object of payroll batch deleted",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of payroll batch",
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
     * Return object of payroll batch deleted
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePayrollBatch(int $id)
    {
        $payrollBatch = $this->_payrollBatchServiceInterface->find($id);

        $result = $payrollBatch->_dto;

        $response = $this->_payrollBatchServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/payroll-batch/slug/{name}",
     *     operationId="getPayrollBatchSlug",
     *     summary="Get slug of payroll batch",
     *     tags={"Payroll Batch"},
     *     description="Return slug of payroll batch",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name of payroll batch",
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
     * Return slug of payroll batch
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollBatchSlug(string $name)
    {
        return $this->getSlugObjectJson($name,
            [$this->_payrollBatchServiceInterface, 'payrollBatchSlug'],
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
        $payrollBatch = $this->_payrollBatchServiceInterface->newInstance();
        $payrollBatch->name = $name;

        $response = $searchMethod($payrollBatch);
        $itemJsonData = $dtoObjectToJsonMethod($response->_dto);

        $jsonData = response()->json($itemJsonData);

        return $jsonData;
    }

    //</editor-fold>
}
