<?php

namespace App\Http\Controllers\API\v1\HumanResources\MasterData;


use App\Core\Services\Response\BooleanResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts\AdditionalQuestionServiceInterface;
use App\Exports\HumanResources\MasterData\AdditionalQuestionExport;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class AdditionalQuestionController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_additionalQuestionServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * AdditionalQuestionController constructor.
     * @param AdditionalQuestionServiceInterface $additionalQuestionServiceInterface
     */
    public function __construct(AdditionalQuestionServiceInterface $additionalQuestionServiceInterface)
    {
        $this->_additionalQuestionServiceInterface = $additionalQuestionServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/additional-questions",
     *     operationId="getAdditionalQuestionList",
     *     summary="Get list of additional question",
     *     tags={"Additional Question"},
     *     description="Get list of additional question",
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
     *          name="is_required",
     *          in="query",
     *          description="Is required parameter (required = 1; not required = 0)",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="query",
     *          description="Status parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"DRAFT", "PUBLISH", "PENDING"},
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
    public function getAdditionalQuestionList(Request $request)
    {
        $companyId = $request->get('company_id');
        $isRequired = $request->get('is_required');
        $status = $request->get('status');

        return $this->getListJson($companyId, $isRequired, $status,
            [$this->_additionalQuestionServiceInterface, 'additionalQuestionList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'question' => $entity->question,
                        'is_required' => $entity->is_required,
                        'status' => $entity->status
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/additional-questions/list-search",
     *     operationId="postAdditionalQuestionListSearch",
     *     summary="Get list of additional question with query search",
     *     tags={"Additional Question"},
     *     description="Get list of additional question with query search",
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
     *                      description="Query property (Keyword would be filter name, slug and description)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/AdditionalQuestionEloquent/properties/company_id"),
     *                  @OA\Property(property="is_required", ref="#/components/schemas/AdditionalQuestionEloquent/properties/is_required"),
     *                  @OA\Property(property="status", ref="#/components/schemas/AdditionalQuestionEloquent/properties/status")
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
    public function postAdditionalQuestionListSearch(Request $request)
    {
        $companyId = $request->get('company_id');
        $isRequired = $request->get('is_required');
        $status = $request->get('status');

        return $this->getListSearchJson($request, $companyId, $isRequired, $status,
            [$this->_additionalQuestionServiceInterface, 'additionalQuestionListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'question' => $entity->question,
                        'is_required' => $entity->is_required,
                        'status' => $entity->status
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/additional-questions/page-search",
     *     operationId="postAdditionalQuestionPageSearch",
     *     summary="Get list of additional question with query and page parameter search",
     *     tags={"Additional Question"},
     *     description="Get list of additional question with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter name, slug and description)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/AdditionalQuestionEloquent/properties/company_id"),
     *                          @OA\Property(property="is_required", ref="#/components/schemas/AdditionalQuestionEloquent/properties/is_required"),
     *                          @OA\Property(property="status", ref="#/components/schemas/AdditionalQuestionEloquent/properties/status")
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
    public function postAdditionalQuestionPageSearch(Request $request)
    {
        $companyId = $request->get('company_id');
        $isRequired = $request->get('is_required');
        $status = $request->get('status');

        return $this->getPagedSearchJson($request, $companyId, $isRequired, $status,
            [$this->_additionalQuestionServiceInterface, 'additionalQuestionPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'question' => $entity->question,
                        'is_required' => $entity->is_required,
                        'status' => $entity->status
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/additional-question",
     *     operationId="postAdditionalQuestionCreate",
     *     summary="Create additional question",
     *     tags={"Additional Question"},
     *     description="Create additional question",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateAdditionalQuestionEloquent")
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
    public function postAdditionalQuestionCreate(Request $request)
    {
        $additionalQuestion = $this->_additionalQuestionServiceInterface->newInstance();

        $additionalQuestion->company_id = $request->input('company_id');
        $additionalQuestion->question = $request->input('question');
        $additionalQuestion->is_required = $request->input('is_required');
        $additionalQuestion->status = $request->input('status');

        $response = $this->_additionalQuestionServiceInterface->create($additionalQuestion);
        $additionalQuestionCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $additionalQuestionCreated);
    }

    /**
     * @OA\Put(
     *     path="/additional-question",
     *     operationId="putAdditionalQuestionUpdate",
     *     summary="Update additional question",
     *     tags={"Additional Question"},
     *     description="Update additional question",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateAdditionalQuestionEloquent")
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
    public function putAdditionalQuestionUpdate(Request $request)
    {
        $additionalQuestion = $this->_additionalQuestionServiceInterface->find($request->input('id'));

        $result = $additionalQuestion->getObject();

        $result->company_id = $request->input('company_id');
        $result->question = $request->input('question');
        $result->is_required = $request->input('is_required');
        $result->status = $request->input('status');

        $response = $this->_additionalQuestionServiceInterface->update($result);
        $additionalQuestionUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $additionalQuestionUpdated);
    }

    /**
     * @OA\Delete(
     *     path="/additional-question/{id}",
     *     operationId="deleteAdditionalQuestion",
     *     summary="Delete additional question",
     *     tags={"Additional Question"},
     *     description="Delete additional question",
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
    public function deleteAdditionalQuestion(int $id)
    {
        $additionalQuestion = $this->_additionalQuestionServiceInterface->find($id);

        $result = $additionalQuestion->getObject();

        $response = $this->_additionalQuestionServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/additional-questions",
     *     operationId="deleteBulkAdditionalQuestion",
     *     summary="Delete bulk additional question",
     *     tags={"Additional Question"},
     *     description="Delete bulk additional question",
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
    public function deleteBulkAdditionalQuestion(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_additionalQuestionServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $isRequired = null, string $status = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $isRequired, $status);
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
     * @param int|null $isRequired
     * @param string|null $status
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $isRequired = null, string $status = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $isRequired, $status);
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
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $isRequired = null, string $status = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $isRequired, $status);
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
