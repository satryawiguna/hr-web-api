<?php

namespace App\Http\Controllers\API\v1\HumanResources\Payroll;

use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayrollBalanceFeedController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_payrollBalanceFeedServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    public function __construct(PayrollBalanceFeedServiceInterface $payrollBlanaceFeedServiceInterface)
    {
        $this->_payrollBalanceFeedServiceInterface = $payrollBlanaceFeedServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/payroll-balance-feed/list",
     *     operationId="getPayrollBalanceFeedList",
     *     summary="Get list of payroll balance feed",
     *     tags={"Payroll Balance Feed"},
     *     description="Return payroll balance feeds",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="formula_category_id",
     *          in="query",
     *          description="Filter formula_category_id of payroll balance feed category by formula_category_id parameter",
     *          required=false,
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
     * Return list of payroll balance feed
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollBalanceFeedList(Request $request)
    {
        $formulaCategoryId = $request->get('formula_category_id');

        return $this->getListJson($formulaCategoryId, [$this->_payrollBalanceFeedServiceInterface, 'formulaList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'formula_category' => $this->getFormulaCategoryObject($entity->formula_category),
                        'name' => $entity->name,
                        'type' => $entity->type,
                        'definition' => $entity->definition,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/payroll-balance-feed/list-search",
     *     operationId="postPayrollBalanceFeedListSearch",
     *     summary="Get list of payroll balance feed by query parameter",
     *     tags={"Payroll Balance Feed"},
     *     description="Return payroll balance feeds",
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
     *                      description="Filter (name, slug, description) of payroll balance feed by query parameter",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="formula_category_id",
     *                      description="Filter formula_category_id of payroll balance feed category by formula_category_id parameter",
     *                      type="integer",
     *                      format="int32"
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
     * Return list of payroll balance feed by query
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPayrollBalanceFeedListSearch(Request $request)
    {
        $formulaCategoryId = $request->input('formula_category_id');

        return $this->getListSearchJson($request, $formulaCategoryId,
            [$this->_payrollBalanceFeedServiceInterface, 'formulaListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'formula_category' => $this->getFormulaCategoryObject($entity->formula_category),
                        'name' => $entity->name,
                        'type' => $entity->type,
                        'definition' => $entity->definition,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/payroll-balance-feed/page-search",
     *     operationId="postPayrollBalanceFeedPageSearch",
     *     summary="Get list of payroll balance feed by search parameter",
     *     tags={"Payroll Balance Feed"},
     *     description="Return payroll balance feeds",
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
     *                      description="Filter (name, slug, description) of payroll balance feed by search parameter",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="formula_category_id",
     *                      description="Filter formula_category_id of payroll balance feed category by formula_category_id parameter",
     *                      type="integer",
     *                      format="int32"
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
     * Return page of payroll balance feed by search
     *
     * @param Request $request
     * @return mixed
     */
    public function postPayrollBalanceFeedPageSearch(Request $request)
    {
        $formulaCategoryId = $request->input('formula_category_id');

        return $this->getPagedSearchJson($request, $formulaCategoryId,
            [$this->_payrollBalanceFeedServiceInterface, 'formulaPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'formula_category' => $this->getFormulaCategoryObject($entity->formula_category),
                        'name' => $entity->name,
                        'type' => $entity->type,
                        'definition' => $entity->definition,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/payroll-balance-feed/detail/{id}",
     *     operationId="getPayrollBalanceFeedDetail",
     *     summary="Get detail formula by id",
     *     tags={"Payroll Balance Feed"},
     *     description="Return formula",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Filter id of payroll balance feed by id parameter",
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
     * Return detail of payroll balance feed
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayrollBalanceFeedDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_payrollBalanceFeedServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'formula_category' => $this->getFormulaCategoryObject($entity->formula_category),
                        'name' => $entity->name,
                        'type' => $entity->type,
                        'definition' => $entity->definition,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/payroll-balance-feed/create",
     *     operationId="postPayrollBalanceFeedCreate",
     *     summary="Create formula",
     *     tags={"Payroll Balance Feed"},
     *     description="Return id of payroll balance feed created",
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
     *                      property="formula_category_id",
     *                      description="Formula category id of payroll balance feed",
     *                      type="integer",
     *                      format="int32"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name of payroll balance feed",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="type",
     *                      description="Type of payroll balance feed",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="definition",
     *                      description="Definition of payroll balance feed",
     *                      type="string"
     *                  ),
     *                  required={
     *                      "formula_category_id",
     *                      "name",
     *                      "type",
     *                      "definition",
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
     * Return id of payroll balance feed created
     *
     * @param Request $request
     * @return mixed
     */
    public function postPayrollBalanceFeedCreate(Request $request)
    {
        $formula = $this->_payrollBalanceFeedServiceInterface->newInstance();

        $formula->formula_category_id = $request->input('formula_category_id');
        $formula->name = $request->input('name');
        $formula->type = $request->input('type');
        $formula->definition = $request->input('definition');

        $this->setRequestAuthor($formula);

        $response = $this->_payrollBalanceFeedServiceInterface->create($formula);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/payroll-balance-feed/update",
     *     operationId="putPayrollBalanceFeedUpdate",
     *     summary="Update formula",
     *     tags={"Payroll Balance Feed"},
     *     description="Return object of payroll balance feed updated",
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
     *                      description="ID of payroll balance feed",
     *                      type="integer",
     *                      format="int64"
     *                  ),
     *                  @OA\Property(
     *                      property="formula_category_id",
     *                      description="Formula category id of payroll balance feed",
     *                      type="integer",
     *                      format="int32"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name of payroll balance feed",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="type",
     *                      description="Type of payroll balance feed",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="definition",
     *                      description="Definition of payroll balance feed",
     *                      type="string"
     *                  ),
     *                  required={
     *                      "id",
     *                      "formula_category_id",
     *                      "name",
     *                      "type",
     *                      "definition"
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
     * Return object of payroll balance feed updated
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putPayrollBalanceFeedUpdate(Request $request)
    {
        $formula = $this->_payrollBalanceFeedServiceInterface->find($request->input('id'));

        $result = $formula->_dto;

        $result->formula_category_id = $request->input('formula_category_id');
        $result->name = $request->input('name');
        $result->type = $request->input('type');
        $result->definition = $request->input('definition');

        $this->setRequestAuthor($result);

        $response = $this->_payrollBalanceFeedServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/payroll-balance-feed/delete/{id}",
     *     operationId="deletePayrollBalanceFeed",
     *     summary="Delete formula",
     *     tags={"Payroll Balance Feed"},
     *     description="Return object of payroll balance feed deleted",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of payroll balance feed",
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
     * Return object of payroll balance feed deleted
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePayrollBalanceFeed(int $id)
    {
        $formula = $this->_payrollBalanceFeedServiceInterface->find($id);

        $result = $formula->_dto;

        $response = $this->_payrollBalanceFeedServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
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
        $formula = $this->_payrollBalanceFeedServiceInterface->newInstance();
        $formula->name = $name;

        $response = $searchMethod($formula);
        $itemJsonData = $dtoObjectToJsonMethod($response->_dto);

        $jsonData = response()->json($itemJsonData);

        return $jsonData;
    }

    /**
     * @param int|null $formulaCategoryId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $formulaCategoryId = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($formulaCategoryId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->_dtoCollection);

        $jsonData = response()->json([
            'rows' => $rowJsonData
        ]);

        return $jsonData;
    }

    /**
     * @param Request $request
     * @param int|null $formulaCategoryId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $formulaCategoryId = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $formulaCategoryId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->_dtoCollection);

        $jsonData = response()->json([
            'rows' => $rowJsonData,
            'rowCountTotal' => $response->_totalCount
        ]);

        return $jsonData;
    }

    /**
     * @param Request $request
     * @param int|null $formulaCategoryId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $formulaCategoryId = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $formulaCategoryId);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->_dtoCollection);

        if ($parameter->draw) {
            $jsonData = response()->json([
                'rows' => $rowJsonData,
                'rowCountPage' => $parameter->length,
                'rowCountTotal' => $response->_totalCount
            ]);
        } else {
            $jsonData = response()->json([
                'meta' => [
                    'page' => (integer)$parameter->pagination['page'],
                    'pages' => $response->_totalPage,
                    'perpage' => (integer)$parameter->pagination['perpage'],
                    'total' => $response->_totalCount,
                    'sort' => $parameter->sort['sort'],
                    'field' => $parameter->sort['field']
                ],
                'rows' => $rowJsonData
            ]);
        }

        return $jsonData;
    }

    /**
     * @param FormulaCategoryEloquent $entity
     * @return Collection
     */
    private function getFormulaCategoryObject(FormulaCategoryEloquent $entity)
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
