<?php

namespace App\Http\Controllers\API\v1\HumanResources\MasterData;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageServiceInterface;
use App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts\RecruitmentStageInterface;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class RecruitmentStageController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_recruitmentStageServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * RecruitmentStageController constructor.
     * @param RecruitmentStageServiceInterface $recruitmentStageServiceInterface
     */
    public function __construct(RecruitmentStageServiceInterface $recruitmentStageServiceInterface)
    {
        $this->_recruitmentStageServiceInterface = $recruitmentStageServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/recruitment-stages",
     *     operationId="getRecruitmentStageList",
     *     summary="Get list of recruitment stage",
     *     tags={"Recruitment Stage"},
     *     description="Get list of recruitment stage",
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
    public function getRecruitmentStageList(Request $request)
    {
        $companyId = $request->get('company_id');

        return $this->getListJson($companyId,
            [$this->_recruitmentStageServiceInterface, 'recruitmentStageList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'color' => $entity->color,
                        'sort_order' => $entity->sort_order,
                        'is_scheduled' => $entity->is_scheduled,
                        'is_init' => $entity->is_init,
                        'is_hired' => $entity->is_hired,
                        'is_reject' => $entity->is_reject
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/recruitment-stages/list-search",
     *     operationId="postRecruitmentStageListSearch",
     *     summary="Get list of recruitment stage with query search",
     *     tags={"Recruitment Stage"},
     *     description="Get list of recruitment stage with query search",
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
     *                  @OA\Property(property="company_id", ref="#/components/schemas/RecruitmentStageEloquent/properties/company_id")
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
    public function postRecruitmentStageListSearch(Request $request)
    {
        $companyId = $request->input('company_id');

        return $this->getListSearchJson($request, $companyId,
            [$this->_recruitmentStageServiceInterface, 'recruitmentStageListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'color' => $entity->color,
                        'sort_order' => $entity->sort_order,
                        'is_scheduled' => $entity->is_scheduled,
                        'is_init' => $entity->is_init,
                        'is_hired' => $entity->is_hired,
                        'is_reject' => $entity->is_reject
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/recruitment-stages/page-search",
     *     operationId="postRecruitmentStagePageSearch",
     *     summary="Get list of recruitment stage with query and page parameter search",
     *     tags={"Recruitment Stage"},
     *     description="Get list of recruitment stage with query and page parameter search",
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
     *                          @OA\Property(property="company_id", ref="#/components/schemas/RecruitmentStageEloquent/properties/company_id")
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
    public function postRecruitmentStagePageSearch(Request $request)
    {
        $companyId = $request->input('company_id');

        return $this->getPagedSearchJson($request, $companyId,
            [$this->_recruitmentStageServiceInterface, 'recruitmentStagePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'color' => $entity->color,
                        'sort_order' => $entity->sort_order,
                        'is_scheduled' => $entity->is_scheduled,
                        'is_init' => $entity->is_init,
                        'is_hired' => $entity->is_hired,
                        'is_reject' => $entity->is_reject
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/recruitment-stage",
     *     operationId="postRecruitmentStageCreate",
     *     summary="Create recruitment stage",
     *     tags={"Recruitment Stage"},
     *     description="Create recruitment stage",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateRecruitmentStageEloquent")
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
    public function postRecruitmentStageCreate(Request $request)
    {
        $recruitmentStage = $this->_recruitmentStageServiceInterface->newInstance();

        $recruitmentStage->company_id = $request->input('company_id');
        $recruitmentStage->name = $request->input('name');
        $recruitmentStage->slug = $request->input('slug');
        $recruitmentStage->color = $request->input('color');
        $recruitmentStage->sort_order = $request->input('sort_order');
        $recruitmentStage->is_scheduled = $request->input('is_scheduled');
        $recruitmentStage->is_init = $request->input('is_init');
        $recruitmentStage->is_hired = $request->input('is_hired');
        $recruitmentStage->is_reject = $request->input('is_reject');

        $this->setRequestAuthor($recruitmentStage);

        $response = $this->_recruitmentStageServiceInterface->create($recruitmentStage);
        $recruitmentStageCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $recruitmentStageCreated);
    }

    /**
     * @OA\Put(
     *     path="/recruitment-stage",
     *     operationId="putRecruitmentStageUpdate",
     *     summary="Update recruitment stage",
     *     tags={"Recruitment Stage"},
     *     description="Update recruitment stage",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateRecruitmentStageEloquent")
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
    public function putRecruitmentStageUpdate(Request $request)
    {
        $recruitmentStage = $this->_recruitmentStageServiceInterface->find($request->input('id'));

        $result = $recruitmentStage->getObject();

        $result->company_id = $request->input('company_id');
        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->color = $request->input('color');
        $result->sort_order = $request->input('sort_order');
        $result->is_scheduled = $request->input('is_scheduled');
        $result->is_init = $request->input('is_init');
        $result->is_hired = $request->input('is_hired');
        $result->is_reject = $request->input('is_reject');

        $this->setRequestAuthor($result);

        $response = $this->_recruitmentStageServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/recruitment-stage/{id}",
     *     operationId="deleteRecruitmentStage",
     *     summary="Delete recruitment stage",
     *     tags={"Recruitment Stage"},
     *     description="Delete recruitment stage",
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
    public function deleteRecruitmentStage(int $id)
    {
        $recruitmentStage = $this->_recruitmentStageServiceInterface->find($id);

        $result = $recruitmentStage->getObject();

        $response = $this->_recruitmentStageServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/recruitment-stages",
     *     operationId="deleteBulkRecruitmentStage",
     *     summary="Delete bulk recruitment stage",
     *     tags={"Recruitment Stage"},
     *     description="Delete bulk recruitment stage",
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
    public function deleteBulkRecruitmentStage(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_recruitmentStageServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/recruitment-stage/slug/{company_id}/{name}",
     *     operationId="getRecruitmentStageSlug",
     *     summary="Get slug of recruitment stage",
     *     tags={"Recruitment Stage"},
     *     description="Return slug of recruitment stage",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="company_id",
     *          in="path",
     *          description="Company id of recruitment stage",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name of recruitment stage",
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
     * Return slug of recruitment stage
     *
     * @param int $company_id
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecruitmentStageSlug(int $company_id, string $name)
    {
        return $this->getSlugObjectJson($company_id, $name,
            [$this->_recruitmentStageServiceInterface, 'recruitmentStageSlug'],
            function ($entity) {
                $rowJsonData = new Collection();

                $rowJsonData->push([
                    'slug' => $entity->slug
                ]);

                return $rowJsonData->first();
            });
    }

    /**
     * @param int $companyId
     * @param string $name
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getSlugObjectJson(int $companyId, string $name,
                                       callable $searchMethod,
                                       callable $dtoObjectToJsonMethod)
    {
        $recruitmentStage = $this->_recruitmentStageServiceInterface->newInstance();
        $recruitmentStage->company_id = $companyId;
        $recruitmentStage->name = $name;

        $response = $searchMethod($recruitmentStage);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $companyId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId);
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
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId);
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
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId);
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
