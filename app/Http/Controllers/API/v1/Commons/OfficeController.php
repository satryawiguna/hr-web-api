<?php

namespace App\Http\Controllers\API\v1\Commons;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\Commons\Office\Contracts\OfficeServiceInterface;
use App\Exports\Commons\OfficeExport;
use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class OfficeController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_officeServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * OfficeController constructor.
     * @param OfficeServiceInterface $officeServiceInterface
     */
    public function __construct(OfficeServiceInterface $officeServiceInterface)
    {
        $this->_officeServiceInterface = $officeServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/office/list",
     *     operationId="getOfficeList",
     *     summary="Get list of office",
     *     tags={"Office"},
     *     description="Get list of office",
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
     *          name="type",
     *          in="query",
     *          description="Type parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"HEAD", "BRANCH"},
     *              default="",
     *              example="HEAD"
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
     * Return list of office
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOfficeList(Request $request)
    {
        $companyId = $request->get('company_id');
        $type = $request->get('type');
        $country = $request->get('country');
        $isActive = $request->get('is_active');

        return $this->getListJson($companyId, $type, $country, $isActive,
            [$this->_officeServiceInterface, 'officeList'],
            function(Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'type' => $entity->type,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'latitude' => $entity->latitude,
                        'longitude' => $entity->longitude,
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
     *     path="/office/list-search",
     *     operationId="postOfficeListSearch",
     *     summary="Get list of office with query search",
     *     tags={"Office"},
     *     description="Get list of office with query search",
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
     *                      description="Query property (Keyword would be filter name, slug, state_or_province, city, address)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/OfficeEloquent/properties/company_id"),
     *                  @OA\Property(property="type", ref="#/components/schemas/OfficeEloquent/properties/type"),
     *                  @OA\Property(property="country", ref="#/components/schemas/OfficeEloquent/properties/country"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/OfficeEloquent/properties/is_active")
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
    public function postOfficeListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $type = $request->input('type');
        $country = $request->input('country');
        $isActive = $request->input('is_active');

        return $this->getListSearchJson($request, $companyId, $type, $country, $isActive,
            [$this->_officeServiceInterface, 'officeListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'type' => $entity->type,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'latitude' => $entity->latitude,
                        'longitude' => $entity->longitude,
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
     *     path="/office/page-search",
     *     operationId="postOfficePageSearch",
     *     summary="Get list of office with query and page parameter search",
     *     tags={"Office"},
     *     description="Get list of office with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter name, slug, state_or_province, city, address)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/OfficeEloquent/properties/company_id"),
     *                          @OA\Property(property="type", ref="#/components/schemas/OfficeEloquent/properties/type"),
     *                          @OA\Property(property="country", ref="#/components/schemas/OfficeEloquent/properties/country"),
     *                          @OA\Property(property="is_active", ref="#/components/schemas/OfficeEloquent/properties/is_active")
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
    public function postOfficePageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $type = $request->input('type');
        $country = $request->input('country');
        $isActive = $request->input('is_active');

        return $this->getPagedSearchJson($request, $companyId, $type, $country, $isActive,
            [$this->_officeServiceInterface, 'officePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'type' => $entity->type,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'latitude' => $entity->latitude,
                        'longitude' => $entity->longitude,
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
     *     path="/office/detail/{id}",
     *     operationId="getOfficeDetail",
     *     summary="Get detail office",
     *     tags={"Office"},
     *     description="Get detail office",
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
    public function getOfficeDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_officeServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'type' => $entity->type,
                        'country' => $entity->country,
                        'state_or_province' => $entity->state_or_province,
                        'city' => $entity->city,
                        'address' => $entity->address,
                        'postcode' => $entity->postcode,
                        'phone' => $entity->phone,
                        'fax' => $entity->fax,
                        'email' => $entity->email,
                        'latitude' => $entity->latitude,
                        'lonitude' => $entity->lonitude,
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
     *     path="/office/create",
     *     operationId="postOfficeCreate",
     *     summary="Create office",
     *     tags={"Office"},
     *     description="Create office",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateOfficeEloquent")
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
    public function postOfficeCreate(Request $request)
    {
        $office = $this->_officeServiceInterface->newInstance();

        $office->company_id = $request->input('company_id');
        $office->name = $request->input('name');
        $office->slug = $request->input('slug');
        $office->type = $request->input('type');
        $office->country = $request->input('country');
        $office->state_or_province = $request->input('state_or_province');
        $office->city = $request->input('city');
        $office->address = $request->input('address');
        $office->postcode = $request->input('postcode');
        $office->phone = $request->input('phone');
        $office->fax = $request->input('fax');
        $office->email = $request->input('email');
        $office->latitude = $request->input('latitude');
        $office->longitude = $request->input('longitude');

        $this->setRequestAuthor($office);

        $response = $this->_officeServiceInterface->create($office);
        $officeCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $officeCreated);
    }

    /**
     * @OA\Put(
     *     path="/office/update",
     *     operationId="putOfficeUpdate",
     *     summary="Update office",
     *     tags={"Office"},
     *     description="Update office",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/office",
     *              @OA\Schema(ref="#/components/schemas/UpdateOfficeEloquent")
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
    public function putOfficeUpdate(Request $request)
    {
        $company = $this->_officeServiceInterface->find($request->input('id'));

        $result = $company->getObject();

        $result->company_id = $request->input('company_id');
        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->country = $request->input('country');
        $result->state_or_province = $request->input('state_or_province');
        $result->city = $request->input('city');
        $result->address = $request->input('address');
        $result->postcode = $request->input('postcode');
        $result->phone = $request->input('phone');
        $result->fax = $request->input('fax');
        $result->email = $request->input('email');
        $result->latitude = $request->input('latitude');
        $result->longitude = $request->input('longitude');

        $this->setRequestAuthor($result);

        $response = $this->_officeServiceInterface->update($result);
        $officeUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $officeUpdated);
    }

    /**
     * @OA\Delete(
     *     path="/office/delete/{id}",
     *     operationId="deleteOffice",
     *     summary="Delete office",
     *     tags={"Office"},
     *     description="Delete office",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of office",
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
    public function deleteOffice(int $id)
    {
        $office = $this->_officeServiceInterface->find($id);

        $result = $office->getObject();

        $response = $this->_officeServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/office/deletes",
     *     operationId="deleteBulkOffice",
     *     summary="Delete bulk office",
     *     tags={"Office"},
     *     description="Delete bulk office",
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
    public function deleteBulkOffice(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_officeServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/office/active",
     *     operationId="putOfficeActive",
     *     summary="Set active office",
     *     tags={"Office"},
     *     description="Set active office",
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
     *                       property="id",
     *                       type="integer",
     *                       format="int64",
     *                       description="Id property",
     *                       example=1
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/OfficeEloquent/properties/is_active"),
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
    public function putOfficeActive(Request $request)
    {
        $office = $this->_officeServiceInterface->find($request->input('id'));

        $result = $office->getObject();

        $result->is_active = $request->input('is_active');

        $this->setRequestAuthor($result);

        $response = $this->_officeServiceInterface->officeSetActive($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/office/slug/{company_id}/{name}",
     *     operationId="getOfficeSlug",
     *     summary="Get slug of office",
     *     tags={"Office"},
     *     description="Get slug of office",
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
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOfficeSlug(int $company_id, string $name)
    {
        return $this->getSlugObjectJson($company_id, $name,
            [$this->_officeServiceInterface, 'officeSlug'],
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
     *     path="/office/list-search/export",
     *     operationId="postOfficeListSearchExport",
     *     summary="Export list of office",
     *     tags={"Office"},
     *     description="Export list of office",
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
     *                  @OA\Property(property="company_id", ref="#/components/schemas/OfficeEloquent/properties/company_id"),
     *                  @OA\Property(property="type", ref="#/components/schemas/OfficeEloquent/properties/type"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/OfficeEloquent/properties/is_active")
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
    public function postOfficeListSearchExport(Request $request)
    {

        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $type = $request->input('type');
        $country = $request->input('country');
        $isActive = $request->input('is_active');

        return $this->getListSearchExportJson($request, $export, $companyId, $type, $country, $isActive,
            [$this->_officeServiceInterface, 'officeListSearch'],
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

        if (Excel::store(new OfficeExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.commons.office', ['offices' => $entities])
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
        $office = $this->_officeServiceInterface->newInstance();
        $office->company_id = $companyId;
        $office->name = $name;

        $response = $searchMethod($office);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int $companyId
     * @param string $type
     * @param string|null $country
     * @param int $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, string $type = null, string $country = null, int $isActive = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $type, $country, $isActive);
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
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, string $type = null, string $country = null, int $isActive = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $type, $country, $isActive);
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
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, string $type = null, string $country = null, int $isActive = null,
                                                   callable $searchMethod,
                                                   callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $type, $country, $isActive);
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
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, string $type = null, string $country = null, int $isActive = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $type, $country, $isActive);
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
            'name' => $entity->name,
            'slug' => $entity->slug
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
