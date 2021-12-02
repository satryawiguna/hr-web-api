<?php

namespace App\Http\Controllers\API\v1\Commons;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyServiceInterface;
use App\Domains\Commons\Company\Contracts\Request\CreateCompanyRequest;
use App\Domains\Commons\Company\Contracts\Request\EditCompanyRequest;
use App\Domains\Commons\CompanyCategory\Contracts\CompanyCategoryInterface;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleInterface;
use App\Domains\Commons\Setting\Contracts\SettingServiceInterface;
use App\Domains\MediaLibrary\Contracts\MediaLibraryServiceInterface;
use App\Exports\Commons\CompanyExport;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class CompanyController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_companyServiceInterface;
    private $_settingServiceInterface;
    private $_mediaLibraryServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * CompanyController constructor.
     * @param CompanyServiceInterface $companyServiceInterface
     * @param SettingServiceInterface $settingServiceInterface
     * @param MediaLibraryServiceInterface $mediaLibraryServiceInterface
     */
    public function __construct(CompanyServiceInterface $companyServiceInterface,
                                SettingServiceInterface $settingServiceInterface,
                                MediaLibraryServiceInterface $mediaLibraryServiceInterface)
    {
        $this->_companyServiceInterface = $companyServiceInterface;
        $this->_settingServiceInterface = $settingServiceInterface;
        $this->_mediaLibraryServiceInterface = $mediaLibraryServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/company/list",
     *     operationId="getCompanyList",
     *     summary="Get list of company",
     *     tags={"Company"},
     *     description="Get list of company",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="company_category_id",
     *          in="query",
     *          description="Company category id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="employee_number_scale_id",
     *          in="query",
     *          description="Employee number scale id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
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
    public function getCompanyList(Request $request)
    {
        $companyCategoryId = $request->get('company_category_id');
        $employeeNumberScaleId = $request->get('employee_number_scale_id');
        $isActive = $request->get('is_active');

        return $this->getListJson($companyCategoryId, $employeeNumberScaleId, $isActive,
            [$this->_companyServiceInterface, 'companyList'],
            function(Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company_category' => Common::isDataExist($entity->companyCategory) ? $this->getCompanyCategoryObject($entity->companyCategory) : null,
                        'employee_number_scale' => Common::isDataExist($entity->employeeNumberScale) ? $this->getEmployeeNumberScaleObject($entity->employeeNumberScale) : null,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'email' => $entity->email,
                        'url' => $entity->url,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->morphMediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/company/list-search",
     *     operationId="postCompanyListSearch",
     *     summary="Get list of company with query search",
     *     tags={"Company"},
     *     description="Get list of company with query search",
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
     *                      description="Query property (Keyword would be filter name, slug, email, url and description)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="company_category_id", ref="#/components/schemas/CompanyEloquent/properties/company_category_id"),
     *                  @OA\Property(property="employee_number_scale_id", ref="#/components/schemas/CompanyEloquent/properties/employee_number_scale_id"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/CompanyEloquent/properties/is_active")
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
    public function postCompanyListSearch(Request $request)
    {
        $companyCategoryId = $request->input('company_category_id');
        $employeeNumberScaleId = $request->input('employee_number_scale_id');
        $isActive = $request->input('is_active');

        return $this->getListSearchJson($request, $companyCategoryId, $employeeNumberScaleId, $isActive,
            [$this->_companyServiceInterface, 'companyListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company_category' => Common::isDataExist($entity->companyCategory) ? $this->getCompanyCategoryObject($entity->companyCategory) : null,
                        'employee_number_scale' => Common::isDataExist($entity->employeeNumberScale) ? $this->getEmployeeNumberScaleObject($entity->employeeNumberScale) : null,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'email' => $entity->email,
                        'url' => $entity->url,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->morphMediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/company/page-search",
     *     operationId="postCompanyPageSearch",
     *     summary="Get list of company with query and page parameter search",
     *     tags={"Company"},
     *     description="Get list of company with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter name, slug, email, url and description)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="company_category_id", ref="#/components/schemas/CompanyEloquent/properties/company_category_id"),
     *                          @OA\Property(property="employee_number_scale_id", ref="#/components/schemas/CompanyEloquent/properties/employee_number_scale_id"),
     *                          @OA\Property(property="is_active", ref="#/components/schemas/CompanyEloquent/properties/is_active")
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
    public function postCompanyPageSearch(Request $request)
    {
        $companyCategoryId = $request->input('company_category_id');
        $employeeNumberScaleId = $request->input('employee_number_scale_id');
        $isActive = $request->input('is_active');

        return $this->getPagedSearchJson($request, $companyCategoryId, $employeeNumberScaleId, $isActive,
            [$this->_companyServiceInterface, 'companyPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company_category' => Common::isDataExist($entity->companyCategory) ? $this->getCompanyCategoryObject($entity->companyCategory) : null,
                        'employee_number_scale' => Common::isDataExist($entity->employeeNumberScale) ? $this->getEmployeeNumberScaleObject($entity->employeeNumberScale) : null,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'email' => $entity->email,
                        'url' => $entity->url,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->morphMediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/company/detail/{id}",
     *     operationId="getCompanyDetail",
     *     summary="Get detail company",
     *     tags={"Company"},
     *     description="Get detail company",
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
    public function getCompanyDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_companyServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company_category' => Common::isDataExist($entity->companyCategory) ? $this->getCompanyCategoryObject($entity->companyCategory) : null,
                        'employee_number_scale' => Common::isDataExist($entity->employeeNumberScale) ? $this->getEmployeeNumberScaleObject($entity->employeeNumberScale) : null,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'email' => $entity->email,
                        'url' => $entity->url,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->morphMediaLibraries
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/company/create",
     *     operationId="postCompanyCreate",
     *     summary="Create company",
     *     tags={"Company"},
     *     description="Create company",
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
     *                      @OA\Schema(ref="#/components/schemas/CreateCompanyEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="media_libraries",
     *                              description="Media library property",
     *                              type="array",
     *                              @OA\Items(
     *                                  @OA\Property(
     *                                      property="media_library_id",
     *                                      description="Media library id property",
     *                                      type="string",
     *                                      example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="pivot",
     *                                      description="Pivot property",
     *                                      @OA\Property(
     *                                          property="attribute",
     *                                          type="string",
     *                                          example="logo"
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                      )
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
    public function postCompanyCreate(Request $request)
    {
        $createCompanyRequest = new CreateCompanyRequest();

        $createCompanyRequest->company_category_id = $request->input('company_category_id');
        $createCompanyRequest->employee_number_scale_id = $request->input('employee_number_scale_id');
        $createCompanyRequest->name = $request->input('name');
        $createCompanyRequest->slug = $request->input('slug');
        $createCompanyRequest->email = $request->input('email');
        $createCompanyRequest->url = $request->input('url');
        $createCompanyRequest->latitude = $request->input('latitude');
        $createCompanyRequest->longitude = $request->input('longitude');
        $createCompanyRequest->description = $request->input('description');
        $createCompanyRequest->is_active = $request->input('is_active');
        $createCompanyRequest->media_libraries = $request->input('media_libraries');

        $this->setRequestAuthor($createCompanyRequest);

        $responseCompany = $this->_companyServiceInterface->create($createCompanyRequest);

        if (!$responseCompany->isSuccess()) {
            return $this->getBasicErrorJson($responseCompany);
        }

        //Generate setting default

        $companyCreated = $responseCompany->getObject();

        $response = $this->_settingServiceInterface->settingInitializeDefault($companyCreated->id);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        $rowJsonData = new Collection();

        if ($companyCreated) {
            $rowJsonData->push([
                'id' => $companyCreated->id,
                'company_category' => Common::isDataExist($companyCreated->companyCategory) ? $this->getCompanyCategoryObject($companyCreated->companyCategory) : null,
                'employee_number_scale' => Common::isDataExist($companyCreated->employeeNumberScale) ? $this->getEmployeeNumberScaleObject($companyCreated->employeeNumberScale) : null,
                'name' => $companyCreated->name,
                'slug' => $companyCreated->slug,
                'email' => $companyCreated->email,
                'url' => $companyCreated->url,
                'description' => $companyCreated->description,
                'is_active' => $companyCreated->is_active,
                'created_by' => $companyCreated->created_by,
                'modified_by' => $companyCreated->modified_by,
                'media_libraries' => $companyCreated->morphMediaLibraries
            ]);
        }

        return $this->getBasicSuccessJson($responseCompany, $rowJsonData->first());
    }

    /**
     * @OA\Put(
     *     path="/company/update",
     *     operationId="putCompanyUpdate",
     *     summary="Update company",
     *     tags={"Company"},
     *     description="Update company",
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
     *                      @OA\Schema(ref="#/components/schemas/UpdateCompanyEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="media_libraries",
     *                              description="Media library property",
     *                              type="array",
     *                              @OA\Items(
     *                                  @OA\Property(
     *                                      property="media_library_id",
     *                                      description="Media library id property",
     *                                      type="string",
     *                                      example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="pivot",
     *                                      description="Pivot property",
     *                                      @OA\Property(
     *                                          property="attribute",
     *                                          type="string",
     *                                          example="logo"
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                      )
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
    public function putCompanyUpdate(Request $request)
    {
        $editCompanyRequest = new EditCompanyRequest();

        $editCompanyRequest->id = $request->input('id');
        $editCompanyRequest->company_category_id = $request->input('company_category_id');
        $editCompanyRequest->employee_number_scale_id = $request->input('employee_number_scale_id');
        $editCompanyRequest->name = $request->input('name');
        $editCompanyRequest->slug = $request->input('slug');
        $editCompanyRequest->email = $request->input('email');
        $editCompanyRequest->url = $request->input('url');
        $editCompanyRequest->latitude = $request->input('latitude');
        $editCompanyRequest->longitude = $request->input('longitude');
        $editCompanyRequest->description = $request->input('description');
        $editCompanyRequest->is_active = $request->input('is_active');
        $editCompanyRequest->media_libraries = $request->input('media_libraries');

        $this->setRequestAuthor($editCompanyRequest);

        $response = $this->_companyServiceInterface->update($editCompanyRequest);
        $companyUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        $rowJsonData = new Collection();

        if ($companyUpdated) {
            $rowJsonData->push([
                'id' => $companyUpdated->id,
                'company_category' => Common::isDataExist($companyUpdated->companyCategory) ? $this->getCompanyCategoryObject($companyUpdated->companyCategory) : null,
                'employee_number_scale' => Common::isDataExist($companyUpdated->employeeNumberScale) ? $this->getEmployeeNumberScaleObject($companyUpdated->employeeNumberScale) : null,
                'name' => $companyUpdated->name,
                'slug' => $companyUpdated->slug,
                'email' => $companyUpdated->email,
                'url' => $companyUpdated->url,
                'description' => $companyUpdated->description,
                'is_active' => $companyUpdated->is_active,
                'created_by' => $companyUpdated->created_by,
                'modified_by' => $companyUpdated->modified_by,
                'media_libraries' => $companyUpdated->morphMediaLibraries
            ]);
        }

        return $this->getBasicSuccessJson($response, $rowJsonData->first());
    }

    /**
     * @OA\Delete(
     *     path="/company/delete/{id}",
     *     operationId="deleteCompany",
     *     summary="Delete company",
     *     tags={"Company"},
     *     description="Delete company",
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCompany(int $id)
    {
        $company = $this->_companyServiceInterface->find($id);

        $result = $company->getObject();

        $response = $this->_companyServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/company/deletes",
     *     operationId="deleteBulkCompany",
     *     summary="Delete bulk company",
     *     tags={"Company"},
     *     description="Delete bulk company",
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
    public function deleteBulkCompany(Request $request)
    {
        try {
            $ids = $request->input('ids');

            $response = $this->_companyServiceInterface->deleteBulk($ids);

            if (!$response->isSuccess()) {
                return $this->getBasicErrorJson($response);
            }

            return $this->getBasicSuccessJson($response);

        } catch (Exception $ex) {
            $response = new ObjectResponse();
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 500);

            return $this->getBasicErrorJson($response);
        }
    }

    /**
     * @OA\Put(
     *     path="/company/active",
     *     operationId="putCompanyActive",
     *     summary="Set active company",
     *     tags={"Company"},
     *     description="Set active company",
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
     *                      property="id",
     *                      description="Id property",
     *                      type="integer",
     *                      format="int64"
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/CompanyEloquent/properties/is_active"),
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
    public function putCompanyActive(Request $request)
    {
        $company = $this->_companyServiceInterface->find($request->input('id'));

        $result = $company->getObject();

        $result->is_active = $request->input('is_active');

        $this->setRequestAuthor($result);

        $response = $this->_companyServiceInterface->companySetActive($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/company/slug/{name}",
     *     operationId="getCompanySlug",
     *     summary="Get slug of company",
     *     tags={"Company"},
     *     description="Get slug of company",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
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
    public function getCompanySlug(string $name)
    {
        return $this->getSlugObjectJson($name,
            [$this->_companyServiceInterface, 'companySlug'],
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
     *     path="/company/list-search/export",
     *     operationId="postCompanyListSearchExport",
     *     summary="Export list of company",
     *     tags={"Company"},
     *     description="Export list of company",
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
     *                  @OA\Property(property="company_category_id", ref="#/components/schemas/CompanyEloquent/properties/company_category_id"),
     *                  @OA\Property(property="employee_number_scale_id", ref="#/components/schemas/CompanyEloquent/properties/employee_number_scale_id"),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/CompanyEloquent/properties/is_active")
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
    public function postCompanyListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyCategoryId = $request->input('company_category_id');
        $employeeNumberScaleId = $request->input('employee_number_scale_id');
        $isActive = $request->input('is_active');

        return $this->getListSearchExportJson($request, $export, $companyCategoryId, $employeeNumberScaleId, $isActive,
            [$this->_companyServiceInterface, 'companyListSearch'],
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

        if (Excel::store(new CompanyExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.commons.company', ['companies' => $entities])
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
     * @param string $name
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getSlugObjectJson(string $name,
                                       callable $searchMethod,
                                       callable $dtoObjectToJsonMethod)
    {
        $company = $this->_companyServiceInterface->newInstance();
        $company->name = $name;

        $response = $searchMethod($company);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $companyCategoryId
     * @param int|null $employeeNumberScaleId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyCategoryId, $employeeNumberScaleId, $isActive);
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
     * @param int|null $companyCategoryId
     * @param int|null $employeeNumberScaleId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyCategoryId, $employeeNumberScaleId, $isActive);
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
     * @param int|null $companyCategoryId
     * @param int|null $employeeNumberScaleId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null,
                                             callable $searchMethod,
                                             callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyCategoryId, $employeeNumberScaleId, $isActive);
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
     * @param int|null $companyCategoryId
     * @param int|null $employeeNumberScaleId
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyCategoryId, $employeeNumberScaleId, $isActive);
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
     * @param EmployeeNumberScaleInterface $entity
     * @return Collection
     */
    private function getEmployeeNumberScaleObject(EmployeeNumberScaleInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name,
            'slug' => $entity->slug
        ]);

        return $rowJsonData;
    }

    /**
     * @param CompanyCategoryInterface $entity
     * @return Collection
     */
    private function getCompanyCategoryObject(CompanyCategoryInterface $entity)
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
