<?php

namespace App\Http\Controllers\API\v1\HumanResources\MasterData;


use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitServiceInterface;
use App\Exports\HumanResources\MasterData\WorkUnitExport;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class WorkUnitController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_workUnitServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * WorkUnitController constructor.
     * @param WorkUnitServiceInterface $workUnitServiceInterface
     */
    public function __construct(WorkUnitServiceInterface $workUnitServiceInterface)
    {
        $this->_workUnitServiceInterface = $workUnitServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/work-unit/list",
     *     operationId="getWorkUnitList",
     *     summary="Get list of work unit",
     *     tags={"Work Unit"},
     *     description="Get list of work unit",
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
     *          name="country",
     *          in="query",
     *          description="Country parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="ID"
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
    public function getWorkUnitList(Request $request)
    {
        $parentId = $request->get('parent_id');
        $companyId = $request->get('company_id');
        $country = $request->get('country');
        $isActive = $request->get('is_active');

        return $this->getListJson($parentId, $companyId, $country, $isActive,
            [$this->_workUnitServiceInterface, 'workUnitList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'code' => $entity->code,
                        'title' => $entity->title,
                        'slug' => $entity->slug,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'url' => $entity->url,
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
     *     path="/work-unit/list-hierarchical",
     *     operationId="getWorkUnitListHierarchical",
     *     summary="Get list hierarchical of work unit",
     *     tags={"Work Unit"},
     *     description="Get list hierarchical of work unit",
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
     *          name="country",
     *          in="query",
     *          description="Country parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="ID"
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
    public function getWorkUnitListHierarchical(Request $request)
    {
        $companyId = $request->get('company_id');
        $country = $request->get('country');
        $isActive = $request->get('is_active');

        return $this->getListHierarchicalJson($companyId, $country, $isActive,
            [$this->_workUnitServiceInterface, 'workUnitListHierarchical'],
            function (Collection $entities) use ($companyId, $country, $isActive) {
                $rowJsonRootData = new Collection();
                $rowJsonChildData = new Collection();

                $rootItem = [
                    'id' => 0,
                    'title' => 'Root'
                ];

                foreach ($entities as $entity) {
                    $childItem = [
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'code' => $entity->code,
                        'title' => $entity->title,
                        'slug' => $entity->slug,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'url' => $entity->url,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ];

                    if ($entity->workUnitChilds->count() > 0) {
                        Arr::set($childItem, 'children', $this->getListWorkUnitChildJson($companyId, $country, $isActive, $entity->workUnitChilds));
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
     *     path="/work-unit/list-search",
     *     operationId="postWorkUnitListSearch",
     *     summary="Get list of work unit with query search",
     *     tags={"Work Unit"},
     *     description="Get list of work unit with query search",
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
     *                      description="Query property (Keyword would be filter code, title, slug, state/province, city, address, postcode, phone, fax, email and url)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="parent_id", ref="#/components/schemas/WorkUnitEloquent/properties/parent_id"),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/WorkUnitEloquent/properties/company_id"),
     *                  @OA\Property(property="country", ref="#/components/schemas/WorkUnitEloquent/properties/country"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/WorkUnitEloquent/properties/is_active")
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
    public function postWorkUnitListSearch(Request $request)
    {
        $parentId = $request->input('parent_id');
        $companyId = $request->input('company_id');
        $country = $request->input('country');
        $isActive = $request->input('is_active');

        return $this->getListSearchJson($request, $parentId, $companyId, $country, $isActive,
            [$this->_workUnitServiceInterface, 'workUnitListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'code' => $entity->code,
                        'title' => $entity->title,
                        'slug' => $entity->slug,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'url' => $entity->url,
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
     *     path="/work-unit/page-search",
     *     operationId="postWorkUnitPageSearch",
     *     summary="Get list of work unit with query and page parameter search",
     *     tags={"Work Unit"},
     *     description="Get list of work unit with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter code, title, slug, state/province, city, address, postcode, phone, fax, email and url)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/WorkUnitEloquent/properties/company_id"),
     *                          @OA\Property(property="country", ref="#/components/schemas/WorkUnitEloquent/properties/country"),
     *                          @OA\Property(property="is_active", ref="#/components/schemas/WorkUnitEloquent/properties/is_active")
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
    public function postWorkUnitPageSearch(Request $request)
    {
        $parentId = $request->input('parent_id');
        $companyId = $request->input('company_id');
        $country = $request->input('country');
        $isActive = $request->input('is_active');

        return $this->getPagedSearchJson($request, $parentId, $companyId, $country, $isActive,
            [$this->_workUnitServiceInterface, 'workUnitPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'parent_id' => Common::isDataExist($entity->workUnitParent) ? $this->getWorkUnitParentObject($entity->workUnitParent) : null,
                        'company' => $this->getCompanyObject($entity->company),
                        'code' => $entity->code,
                        'title' => $entity->title,
                        'slug' => $entity->slug,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'url' => $entity->url,
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
     *     path="/work-unit/detail/{id}",
     *     operationId="getWorkUnitDetail",
     *     summary="Get detail work unit",
     *     tags={"Work Unit"},
     *     description="Get detail work unit",
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
    public function getWorkUnitDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_workUnitServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'parent_id' => $entity->parent_id,
                        'company' => $this->getCompanyObject($entity->company),
                        'code' => $entity->code,
                        'title' => $entity->title,
                        'slug' => $entity->slug,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'url' => $entity->url,
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
     *     path="/work-unit/create",
     *     operationId="postWorkUnitCreate",
     *     summary="Create work unit",
     *     tags={"Work Unit"},
     *     description="Create work unit",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateWorkUnitEloquent")
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
    public function postWorkUnitCreate(Request $request)
    {
        $workUnit = $this->_workUnitServiceInterface->newInstance();

        $workUnit->parent_id = $request->has('parent_id') && $request->parent_id != 0 ? $request->input('parent_id') : null;
        $workUnit->company_id = $request->input('company_id');
        $workUnit->code = $request->input('code');
        $workUnit->title = $request->input('title');
        $workUnit->slug = $request->input('slug');
        $workUnit->country = $request->input('country');
        $workUnit->state_or_province = $request->input('state_or_province');
        $workUnit->city = $request->input('city');
        $workUnit->address = $request->input('address');
        $workUnit->postcode = $request->input('postcode');
        $workUnit->phone = $request->input('phone');
        $workUnit->fax = $request->input('fax');
        $workUnit->email = $request->input('email');
        $workUnit->url = $request->input('url');

        $this->setRequestAuthor($workUnit);

        $response = $this->_workUnitServiceInterface->create($workUnit);
        $workUnitCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $workUnitCreated);
    }

    /**
     * @OA\Put(
     *     path="/work-unit/update",
     *     operationId="putWorkUnitUpdate",
     *     summary="Update work unit",
     *     tags={"Work Unit"},
     *     description="Return object of work unit updated",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateWorkUnitEloquent")
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
    public function putWorkUnitUpdate(Request $request)
    {
        $application = $this->_workUnitServiceInterface->find($request->input('id'));

        $result = $application->getObject();

        $result->parent_id = $request->has('parent_id') && $request->parent_id != 0 ? $request->get('parent_id') : null;
        $result->company_id = $request->input('company_id');
        $result->code = $request->input('code');
        $result->title = $request->input('title');
        $result->slug = $request->input('slug');
        $result->country = $request->input('country');
        $result->state_or_province = $request->input('state_or_province');
        $result->city = $request->input('city');
        $result->address = $request->input('address');
        $result->postcode = $request->input('postcode');
        $result->phone = $request->input('phone');
        $result->fax = $request->input('fax');
        $result->email = $request->input('email');
        $result->url = $request->input('url');

        $this->setRequestAuthor($result);

        $response = $this->_workUnitServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/work-unit/delete/{id}",
     *     operationId="deleteWorkUnit",
     *     summary="Delete work unit",
     *     tags={"Work Unit"},
     *     description="Delete work unit",
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
    public function deleteWorkUnit(int $id)
    {
        $application = $this->_workUnitServiceInterface->find($id);

        $result = $application->getObject();

        $response = $this->_workUnitServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/work-unit/deletes",
     *     operationId="deleteBulkWorkUnit",
     *     summary="Delete bulk work unit",
     *     tags={"Work Unit"},
     *     description="Delete bulk work unit",
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
    public function deleteBulkWorkUnit(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_workUnitServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/work-unit/active",
     *     operationId="putWorkUnitActive",
     *     summary="Set active work unit",
     *     tags={"Work Unit"},
     *     description="Set active work unit",
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
     *                  @OA\Property(property="is_active", ref="#/components/schemas/WorkUnitEloquent/properties/is_active"),
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
    public function putWorkUnitActive(Request $request)
    {
        $application = $this->_workUnitServiceInterface->find($request->input('id'));

        $result = $application->getObject();

        $result->is_active = $request->input('is_active');

        $this->setRequestAuthor($result);

        $response = $this->_workUnitServiceInterface->workUnitSetActive($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/work-unit/slug/{company_id}/{title}",
     *     operationId="getWorkUnitSlug",
     *     summary="Get slug of work unit",
     *     tags={"Work Unit"},
     *     description="Return slug of work unit",
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
     *          name="title",
     *          in="path",
     *          description="Title parameter",
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
     * Return slug of work unit
     *
     * @param int $company_id
     * @param string $title
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWorkUnitSlug(int $company_id, string $title)
    {
        return $this->getSlugObjectJson($company_id, $title,
            [$this->_workUnitServiceInterface, 'workUnitSlug'],
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
     *     path="/work-unit/list-search/export",
     *     operationId="postWorkUnitListSearchExport",
     *     summary="Export list of work unit",
     *     tags={"Work Unit"},
     *     description="Export list of work unit",
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
     *                  @OA\Property(property="parent_id", ref="#/components/schemas/WorkUnitEloquent/properties/parent_id"),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/WorkUnitEloquent/properties/company_id"),
     *                  @OA\Property(property="country", ref="#/components/schemas/WorkUnitEloquent/properties/country"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/WorkUnitEloquent/properties/is_active")
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
    public function postWorkUnitListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $parentId = $request->input('parent_id');
        $companyId = $request->input('company_id');
        $country = $request->input('country');
        $isActive = $request->input('is_active');

        return $this->getListSearchExportJson($request, $export, $parentId, $companyId, $country, $isActive,
            [$this->_workUnitServiceInterface, 'workUnitListSearch'],
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

        if (Excel::store(new WorkUnitExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.master-data.work-unit', ['workUnits' => $entities])
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
     * @param string $title
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getSlugObjectJson(int $companyId, string $title,
                                       callable $searchMethod,
                                       callable $dtoObjectToJsonMethod)
    {
        $workUnit = $this->_workUnitServiceInterface->newInstance();
        $workUnit->company_id = $companyId;
        $workUnit->title = $title;

        $response = $searchMethod($workUnit);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $parentId = null, int $companyId = null, string $country = null, int $isActive = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($parentId, $companyId, $country, $isActive);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListHierarchicalJson(int $companyId = null, string $country = null, int $isActive = null,
                                             callable $searchMethod,
                                             callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $country, $isActive);
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
     * @param int $companyId
     * @param string|null $country
     * @param int $isActive
     * @param Collection $entities
     * @return Collection
     */
    private function getListWorkUnitChildJson(int $companyId = null, string $country = null, int $isActive = null, Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $item = [
                'id' => $entity->id,
                'company' => $this->getCompanyObject($entity->company),
                'code' => $entity->code,
                'title' => $entity->title,
                'slug' => $entity->slug,
                'country' => $entity->country,
                'state_or_province' => $entity->state_or_province,
                'city' => $entity->city,
                'address' => $entity->address,
                'postcode' => $entity->postcode,
                'phone' => $entity->phone,
                'fax' => $entity->fax,
                'email' => $entity->email,
                'url' => $entity->url,
                'is_active' => $entity->is_active,
                'created_by' => $entity->created_by,
                'modified_by' => $entity->modified_by
            ];

            $workUnitChild = $entity->workUnitChilds;

            if (!is_null($companyId)) {
                $workUnitChild = $workUnitChild->where('company_id', $companyId);
            }

            if (!is_null($country)) {
                $workUnitChild = $workUnitChild->where('country', $country);
            }

            if (!is_null($isActive)) {
                $workUnitChild = $workUnitChild->where('is_active', $isActive);
            }

            if ($workUnitChild->count() > 0) {
                Arr::set($item, 'children', $this->getListWorkUnitChildJson($companyId, $country, $isActive, $workUnitChild));
            }

            $rowJsonData->push($item);
        }

        return $rowJsonData;
    }

    /**
     * @param Request $request
     * @param int $parentId
     * @param int $companyId
     * @param string $country
     * @param int $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $parentId, $companyId, $country, $isActive);
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
     * @param int|null $companyId
     * @param int|null $parentId
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null,
                                             callable $searchMethod,
                                             callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $parentId, $companyId, $country, $isActive);
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
     * @param int|null $parentId
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $parentId, $companyId, $country, $isActive);
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
     * @param WorkUnitInterface $entity
     * @return Collection
     */
    private function getWorkUnitParentObject(WorkUnitInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'title' => $entity->title,
            'work_unit_parent' => Common::isDataExist($entity->workUnitParent) ? $this->getWorkUnitParentObject($entity->workUnitParent) : null,
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
