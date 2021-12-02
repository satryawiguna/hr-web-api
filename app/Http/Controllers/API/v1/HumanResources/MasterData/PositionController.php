<?php

namespace App\Http\Controllers\API\v1\HumanResources\MasterData;


use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionInterface;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionServiceInterface;
use App\Exports\HumanResources\MasterData\PositionExport;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class PositionController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_positionServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * PositionController constructor.
     * @param PositionServiceInterface $positionServiceInterface
     */
    public function __construct(PositionServiceInterface $positionServiceInterface)
    {
        $this->_positionServiceInterface = $positionServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/position/list",
     *     operationId="getPositionList",
     *     summary="Get list of position",
     *     tags={"Position"},
     *     description="Get list of position",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="parent_id",
     *          in="query",
     *          description="Parent id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
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
     *          name="is_active",
     *          in="query",
     *          description="Is active parameter (active = 1; not active = 0)",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
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
    public function getPositionList(Request $request)
    {
        $parentId = $request->has('parent_id') && $request->parent_id != 0 ? $request->get('parent_id') : null;
        $companyId = $request->get('company_id');
        $isActive = $request->get('is_active');

        return $this->getListJson($parentId, $companyId, $isActive,
            [$this->_positionServiceInterface, 'positionList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/position/list-hierarchical",
     *     operationId="getPositionListHierarchical",
     *     summary="Get list hierarchical of position",
     *     tags={"Position"},
     *     description="Get list hierarchical of position",
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
     *          name="is_active",
     *          in="query",
     *          description="Is active parameter (active = 1; not active = 0)",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
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
    public function getPositionListHierarchical(Request $request)
    {
        $companyId = $request->get('company_id');
        $isActive = $request->get('is_active');

        return $this->getListHierarchicalJson($companyId, $isActive,
            [$this->_positionServiceInterface, 'positionListHierarchical'],
            function (Collection $entities) use ($companyId, $isActive) {
                $rowJsonRootData = new Collection();
                $rowJsonChildData = new Collection();

                $rootItem = [
                    'id' => 0,
                    'name' => 'Root'
                ];

                foreach ($entities as $entity) {
                    $childItem = [
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ];

                    if ($entity->positionChilds->count() > 0) {
                        Arr::set($childItem, 'children', $this->getListPositionChildJson($companyId, $isActive, $entity->positionChilds));
                    }

                    $rowJsonChildData->push($childItem);
                }

                Arr::set($rootItem, 'children', $rowJsonChildData);
                $rowJsonRootData->push($rootItem);

                return $rowJsonRootData;
            });
    }

    /**
     * @OA\Post(
     *     path="/position/list-search",
     *     operationId="postPositionListSearch",
     *     summary="Get list of position with query search",
     *     tags={"Position"},
     *     description="Get list of position with query search",
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
     *                      description="Query property (Keyword would be filter code, name, slug and description)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="parent_id", ref="#/components/schemas/PositionEloquent/properties/parent_id"),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/PositionEloquent/properties/company_id"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/PositionEloquent/properties/is_active")
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
    public function postPositionListSearch(Request $request)
    {
        $parentId = $request->has('parent_id') && $request->parent_id != 0 ? $request->get('parent_id') : null;
        $companyId = $request->input('company_id');
        $isActive = $request->input('is_active');

        return $this->getListSearchJson($request, $parentId, $companyId, $isActive,
            [$this->_positionServiceInterface, 'positionListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/position/page-search",
     *     operationId="postPositionPageSearch",
     *     summary="Get list of position with query and page parameter search",
     *     tags={"Position"},
     *     description="Get list of position with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter code, name, slug and description)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="parent_id", ref="#/components/schemas/PositionEloquent/properties/parent_id"),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/PositionEloquent/properties/company_id"),
     *                          @OA\Property(property="is_active", ref="#/components/schemas/PositionEloquent/properties/is_active")
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
    public function postPositionPageSearch(Request $request)
    {
        $parentId = $request->has('parent_id') && $request->parent_id != 0 ? $request->get('parent_id') : null;
        $companyId = $request->input('company_id');
        $isActive = $request->input('is_active');

        return $this->getPagedSearchJson($request, $parentId, $companyId, $isActive,
            [$this->_positionServiceInterface, 'positionPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'parent_id' => Common::isDataExist($entity->positionParent) ? $this->getPositionParentObject($entity->positionParent) : null,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/position/detail/{id}",
     *     operationId="getPositionDetail",
     *     summary="Get detail position",
     *     tags={"Position"},
     *     description="Get detail position",
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
    public function getPositionDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_positionServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'parent_id' => $entity->parent_id,
                        'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/position/create",
     *     operationId="postPositionCreate",
     *     summary="Create position",
     *     tags={"Position"},
     *     description="Create position",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreatePositionEloquent")
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
    public function postPositionCreate(Request $request)
    {
        $position = $this->_positionServiceInterface->newInstance();

        $position->parent_id = $request->has('parent_id') && $request->parent_id != 0 ? $request->get('parent_id') : null;
        $position->company_id = $request->input('company_id');
        $position->code = $request->input('code');
        $position->name = $request->input('name');
        $position->slug = $request->input('slug');
        $position->description = $request->input('description');

        $this->setRequestAuthor($position);

        $response = $this->_positionServiceInterface->create($position);
        $positionCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $positionCreated);
    }

    /**
     * @OA\Put(
     *     path="/position/update",
     *     operationId="putPositionUpdate",
     *     summary="Update position",
     *     tags={"Position"},
     *     description="Update position",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdatePositionEloquent")
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
    public function putPositionUpdate(Request $request)
    {
        $position = $this->_positionServiceInterface->find($request->input('id'));

        $result = $position->getObject();

        $result->parent_id = $request->has('parent_id') && $request->parent_id != 0 ? $request->get('parent_id') : null;
        $result->company_id = $request->input('company_id');
        $result->code = $request->input('code');
        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->description = $request->input('description');

        $this->setRequestAuthor($result);

        $response = $this->_positionServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/position/delete/{id}",
     *     operationId="deletePosition",
     *     summary="Delete position",
     *     tags={"Position"},
     *     description="Delete position",
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
    public function deletePosition(int $id)
    {
        $position = $this->_positionServiceInterface->find($id);

        $result = $position->getObject();

        $response = $this->_positionServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/position/deletes",
     *     operationId="deleteBulkPosition",
     *     summary="Delete bulk position",
     *     tags={"Position"},
     *     description="Delete bulk position",
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
     *                          @OA\Property(
     *                              property="id",
     *                              description="ID of position",
     *                              type="integer",
     *                              format="int64"
     *                          )
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
    public function deleteBulkPosition(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_positionServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/position/active",
     *     operationId="putPositionActive",
     *     summary="Set active position",
     *     tags={"Position"},
     *     description="Set active position",
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
     *                       property="id",
     *                       type="integer",
     *                       format="int64",
     *                       description="Id property",
     *                       example=1
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/PositionEloquent/properties/is_active"),
     *                  required={
     *                      "id",
     *                      "is_active"
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
     */
    public function putPositionActive(Request $request)
    {
        $position = $this->_positionServiceInterface->find($request->input('id'));

        $result = $position->getObject();

        $result->is_active = $request->input('is_active');

        $this->setRequestAuthor($result);

        $response = $this->_positionServiceInterface->positionSetActive($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/position/slug/{company_id}/{name}",
     *     operationId="getPositionSlug",
     *     summary="Get slug of position",
     *     tags={"Position"},
     *     description="Get slug of position",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="company_id",
     *          in="path",
     *          description="Company id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
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
     * @param int $company_id
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPositionSlug(int $company_id, string $name)
    {
        return $this->getSlugObjectJson($company_id, $name,
            [$this->_positionServiceInterface, 'positionSlug'],
            function ($entity) {
                $rowJsonData = new Collection();

                $rowJsonData->push([
                    'slug' => $entity->slug
                ]);

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/position/list-search/export",
     *     operationId="postPositionListSearchExport",
     *     summary="Export list of position",
     *     tags={"Position"},
     *     description="Export list of position",
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
     *                  @OA\Property(property="parent_id", ref="#/components/schemas/PositionEloquent/properties/parent_id"),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/PositionEloquent/properties/company_id"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/PositionEloquent/properties/is_active")
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
    public function postPositionListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $parentId = $request->input('parent_id');
        $companyId = $request->input('company_id');
        $isActive = $request->input('is_active');

        return $this->getListSearchExportJson($request, $export, $parentId, $companyId, $isActive,
            [$this->_positionServiceInterface, 'positionListSearch'],
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

        if (Excel::store(new PositionExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.master-data.position', ['positions' => $entities])
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
        $position = $this->_positionServiceInterface->newInstance();
        $position->company_id = $companyId;
        $position->name = $name;

        $response = $searchMethod($position);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $parentId = null, int $companyId = null, int $isActive = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($parentId, $companyId, $isActive);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int $companyId
     * @param int $isActive
     * @param Collection $entities
     * @return Collection
     */
    private function getListPositionChildJson(int $companyId = null, int $isActive = null, Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $item = [
                'id' => $entity->id,
                'company' => Common::isDataExist($entity->company) ? $this->getCompanyObject($entity->company) : null,
                'code' => $entity->code,
                'name' => $entity->name,
                'slug' => $entity->slug,
                'description' => $entity->description,
                'is_active' => $entity->is_active,
                'created_by' => $entity->created_by,
                'modified_by' => $entity->modified_by
            ];

            $positionChild = $entity->positionChilds;

            if (!is_null($companyId)) {
                $positionChild = $positionChild->where('company_id', $companyId);
            }

            if (!is_null($isActive)) {
                $positionChild = $positionChild->where('is_active', $isActive);
            }

            if ($positionChild->count() > 0) {
                Arr::set($item, 'children', $this->getListPositionChildJson($companyId, $isActive, $positionChild));
            }

            $rowJsonData->push($item);
        }

        return $rowJsonData;
    }

    /**
     * @param int|null $companyId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListHierarchicalJson(int $companyId = null, int $isActive = null,
                                             callable $searchMethod,
                                             callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $isActive);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            $datas = response()->json($rowJsonData)->getData();

            Common::levelUp($datas);

            return response()->json([
                "rows" => $datas
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $parentId = null, int $companyId = null, int $isActive = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $parentId, $companyId, $isActive);
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
     * @param int|null $id
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $parentId = null, int $companyId = null, int $isActive = null,
                                             callable $searchMethod,
                                             callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $parentId, $companyId, $isActive);
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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $parentId = null, int $companyId = null, int $isActive = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $parentId, $companyId, $isActive);
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

    /**
     * @param PositionInterface $entity
     * @return Collection
     */
    private function getPositionParentObject(PositionInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name,
            'position_parent' => Common::isDataExist($entity->positionParent) ? $this->getPositionParentObject($entity->positionParent) : null,
        ]);

        return $rowJsonData;
    }
    
    //</editor-fold>
}
