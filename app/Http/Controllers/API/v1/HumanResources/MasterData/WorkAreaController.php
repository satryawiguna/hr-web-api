<?php

namespace App\Http\Controllers\API\v1\HumanResources\MasterData;


use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\MasterData\WorkArea\Contracts\WorkAreaServiceInterface;
use App\Exports\HumanResources\MasterData\WorkAreaExport;
use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class WorkAreaController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_workAreaServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * WorkAreaController constructor.
     * @param WorkAreaServiceInterface $workAreaServiceInterface
     */
    public function __construct(WorkAreaServiceInterface $workAreaServiceInterface)
    {
        $this->_workAreaServiceInterface = $workAreaServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/work-area/list",
     *     operationId="getWorkAreaList",
     *     summary="Get list of work area",
     *     tags={"Work Area"},
     *     description="Get list of work area",
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
    public function getWorkAreaList(Request $request)
    {
        $companyId = $request->get('company_id');
        $country = $request->get('country');
        $isActive = $request->get('is_active');

        return $this->getListJson($companyId, $country, $isActive,
            [$this->_workAreaServiceInterface, 'workAreaList'],
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
     *     path="/work-area/list-search",
     *     operationId="postWorkAreaListSearch",
     *     summary="Get list of work area with query search",
     *     tags={"Work Area"},
     *     description="Get list of work area with query search",
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
     *                  @OA\Property(property="company_id", ref="#/components/schemas/WorkAreaEloquent/properties/company_id"),
     *                  @OA\Property(property="country", ref="#/components/schemas/WorkAreaEloquent/properties/country"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/WorkAreaEloquent/properties/is_active")
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
    public function postWorkAreaListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $country = $request->input('country');
        $isActive = $request->input('is_active');

        return $this->getListSearchJson($request, $companyId, $country, $isActive,
            [$this->_workAreaServiceInterface, 'workAreaListSearch'],
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
     *     path="/work-area/page-search",
     *     operationId="postWorkAreaPageSearch",
     *     summary="Get list of work area with query and page parameter search",
     *     tags={"Work Area"},
     *     description="Get list of work area with query and page parameter search",
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
     *                          @OA\Property(property="company_id", ref="#/components/schemas/WorkAreaEloquent/properties/company_id"),
     *                          @OA\Property(property="country", ref="#/components/schemas/WorkAreaEloquent/properties/country"),
     *                          @OA\Property(property="is_active", ref="#/components/schemas/WorkAreaEloquent/properties/is_active")
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
    public function postWorkAreaPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $country = $request->input('country');
        $isActive = $request->input('is_active');

        return $this->getPagedSearchJson($request, $companyId, $country, $isActive,
            [$this->_workAreaServiceInterface, 'workAreaPageSearch'],
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
     *     path="/work-area/detail/{id}",
     *     operationId="getWorkAreaDetail",
     *     summary="Get detail work area",
     *     tags={"Work Area"},
     *     description="Get detail work area",
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
    public function getWorkAreaDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_workAreaServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
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

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/work-area/create",
     *     operationId="postWorkAreaCreate",
     *     summary="Create work area",
     *     tags={"Work Area"},
     *     description="Create work area",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateWorkAreaEloquent")
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
    public function postWorkAreaCreate(Request $request)
    {
        $workArea = $this->_workAreaServiceInterface->newInstance();

        $workArea->company_id = $request->input('company_id');
        $workArea->code = $request->input('code');
        $workArea->title = $request->input('title');
        $workArea->slug = $request->input('slug');
        $workArea->country = $request->input('country');
        $workArea->state_or_province = $request->input('state_or_province');
        $workArea->city = $request->input('city');
        $workArea->address = $request->input('address');
        $workArea->postcode = $request->input('postcode');
        $workArea->phone = $request->input('phone');
        $workArea->fax = $request->input('fax');
        $workArea->email = $request->input('email');
        $workArea->url = $request->input('url');

        $this->setRequestAuthor($workArea);

        $response = $this->_workAreaServiceInterface->create($workArea);
        $workAreaCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $workAreaCreated);
    }

    /**
     * @OA\Put(
     *     path="/work-area/update",
     *     operationId="putWorkAreaUpdate",
     *     summary="Update work area",
     *     tags={"Work Area"},
     *     description="Update work area",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateWorkAreaEloquent")
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
    public function putWorkAreaUpdate(Request $request)
    {
        $application = $this->_workAreaServiceInterface->find($request->input('id'));

        $result = $application->getObject();

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

        $response = $this->_workAreaServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/work-area/delete/{id}",
     *     operationId="deleteWorkArea",
     *     summary="Delete work area",
     *     tags={"Work Area"},
     *     description="Delete work area",
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
    public function deleteWorkArea(int $id)
    {
        $application = $this->_workAreaServiceInterface->find($id);

        $result = $application->getObject();

        $response = $this->_workAreaServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/work-area/deletes",
     *     operationId="deleteBulkWorkArea",
     *     summary="Delete bulk work area",
     *     tags={"Work Area"},
     *     description="Delete bulk work area",
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
    public function deleteBulkWorkArea(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_workAreaServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/work-area/active",
     *     operationId="putWorkAreaActive",
     *     summary="Set active work area",
     *     tags={"Work Area"},
     *     description="Set active work area",
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
     *                  @OA\Property(property="is_active", ref="#/components/schemas/WorkAreaEloquent/properties/is_active"),
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
    public function putWorkAreaActive(Request $request)
    {
        $application = $this->_workAreaServiceInterface->find($request->input('id'));

        $result = $application->getObject();

        $result->is_active = $request->input('is_active');

        $this->setRequestAuthor($result);

        $response = $this->_workAreaServiceInterface->workAreaSetActive($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/work-area/slug/{company_id}/{title}",
     *     operationId="getWorkAreaSlug",
     *     summary="Get slug of work area",
     *     tags={"Work Area"},
     *     description="Get slug of work area",
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
     * @param string $title
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWorkAreaSlug(int $company_id, string $title)
    {

        return $this->getSlugObjectJson($company_id, $title,
            [$this->_workAreaServiceInterface, 'workAreaSlug'],
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
     *     path="/work-area/list-search/export",
     *     operationId="postWorkAreaListSearchExport",
     *     summary="Export list of work area",
     *     tags={"Work Area"},
     *     description="Export list of work area",
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
     *                  @OA\Property(property="company_id", ref="#/components/schemas/WorkAreaEloquent/properties/company_id"),
     *                  @OA\Property(property="country", ref="#/components/schemas/WorkAreaEloquent/properties/country"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/WorkAreaEloquent/properties/is_active")
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
    public function postWorkAreaListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $isActive = $request->input('is_active');

        return $this->getListSearchExportJson($request, $export, $companyId, $isActive,
            [$this->_workAreaServiceInterface, 'workAreaListSearch'],
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

        if (Excel::store(new WorkAreaExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.master-data.work-area', ['workAreas' => $entities])
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
        $workArea = $this->_workAreaServiceInterface->newInstance();
        $workArea->company_id = $companyId;
        $workArea->title = $title;

        $response = $searchMethod($workArea);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
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
    private function getListJson(int $companyId = null, string $country = null, int $isActive = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $country, $isActive);
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
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, string $country = null, int $isActive = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $country, $isActive);
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
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, int $isActive = null,
                                             callable $searchMethod,
                                             callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $isActive);
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
     * @param string|null $country
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, string $country = null, int $isActive = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $country, $isActive);
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
