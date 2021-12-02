<?php

namespace App\Http\Controllers\API\v1\HumanResources\Project;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\Commons\ContractType\Contracts\ContractTypeInterface;
use App\Domains\HumanResources\Project\Contracts\ProjectInterface;
use App\Domains\HumanResources\Project\Contracts\ProjectServiceInterface;
use App\Domains\HumanResources\Project\Contracts\Request\CreateProjectRequest;
use App\Domains\HumanResources\Project\Contracts\Request\EditProjectRequest;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\Request\CreateProjectAddendumRequest;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\Request\EditProjectAddendumRequest;
use App\Exports\HumanResources\Project\ProjectExport;
use App\Helpers\Common;
use App\Helpers\DateTimeRange;
use App\Helpers\NumericRange;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use File;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ProjectController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_projectServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * ProjectController constructor.
     * @param ProjectServiceInterface $projectServiceInterface
     */
    public function __construct(ProjectServiceInterface $projectServiceInterface)
    {
        $this->_projectServiceInterface = $projectServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/project/list",
     *     operationId="getProjectList",
     *     summary="Get list of project",
     *     tags={"Project"},
     *     description="Get list of project",
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
     *          name="contract_type_id",
     *          in="query",
     *          description="Contract type id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_issue_date",
     *          in="query",
     *          description="Start issue date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_issue_date",
     *          in="query",
     *          description="End issue date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="date",
     *          in="query",
     *          description="Date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_value",
     *          in="query",
     *          description="Start value parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="float",
     *              example="0"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_value",
     *          in="query",
     *          description="End value parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="float",
     *              example="100"
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
     * @throws Exception
     */
    public function getProjectList(Request $request)
    {
        $parentId = $request->get('parent_id');
        $companyId = $request->get('company_id');
        $contractTypeId = $request->get('contract_type_id');
        $rangeIssueDate = new DateTimeRange($request->get('start_issue_date'), $request->get('end_issue_date'));
        $date = $request->has('date') && !is_null($request->get('date')) ? new DateTime($request->get('date')) : null;
        $rangeValue = new NumericRange($request->get('start_value'), $request->get('end_value'));

        return $this->getListJson($parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue,
            [$this->_projectServiceInterface, 'projectList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'contract_type'=> $this->getContractTypeObject($entity->contractType),
                        'reference_number' => $entity->reference_number,
                        'name' => $entity->name,
                        'first_party_number' => $entity->first_party_number,
                        'second_party_number' => $entity->second_party_number,
                        'issue_date' => $entity->issue_date,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'activity' => $entity->activity,
                        'description' => $entity->description,
                        'value' => $entity->value,
                        'is_contract' => $entity->is_contract,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/project/list-hierarchical",
     *     operationId="getProjectListHierarchical",
     *     summary="Get list hierarchical of project",
     *     tags={"Project"},
     *     description="Get list hierarchical of project",
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
     *          name="contract_type_id",
     *          in="query",
     *          description="Contract type id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_issue_date",
     *          in="query",
     *          description="Start issue date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_issue_date",
     *          in="query",
     *          description="End issue date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="date",
     *          in="query",
     *          description="Date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_value",
     *          in="query",
     *          description="Start value parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="float",
     *              example="0"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_value",
     *          in="query",
     *          description="End value parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="float",
     *              example="100"
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
     * @throws Exception
     */
    public function getProjectListHierarchical(Request $request)
    {
        $companyId = $request->get('company_id');
        $contractTypeId = $request->get('contract_type_id');
        $rangeIssueDate = new DateTimeRange($request->get('start_issue_date'), $request->get('end_issue_date'));
        $date = $request->has('date') && !is_null($request->get('date')) ? new DateTime($request->get('date')) : null;
        $rangeValue = new NumericRange($request->get('start_value'), $request->get('end_value'));

        return $this->getListHierarchicalJson($companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue,
            [$this->_projectServiceInterface, 'projectListHierarchical'],
            function (Collection $entities) use ($companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue) {
                $rowJsonRootData = new Collection();
                $rowJsonChildData = new Collection();

                $rootItem = [
                    'id' => 0,
                    'name' => 'Root'
                ];

                foreach ($entities as $entity) {
                    $childItem = [
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'contract_type'=> $this->getContractTypeObject($entity->contractType),
                        'reference_number' => $entity->reference_number,
                        'name' => $entity->name,
                        'first_party_number' => $entity->first_party_number,
                        'second_party_number' => $entity->second_party_number,
                        'issue_date' => $entity->issue_date,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'activity' => $entity->activity,
                        'description' => $entity->description,
                        'value' => $entity->value,
                        'is_contract' => $entity->is_contract,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ];

                    if ($entity->projectChilds->count() > 0) {
                        Arr::set($childItem, 'children', $this->getListProjectChildJson($companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue, $entity->projectChilds));
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
     *     path="/project/list-search",
     *     operationId="postProjectListSearch",
     *     summary="Get list of project with query search",
     *     tags={"Project"},
     *     description="Get list of project with query search",
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
     *                      description="Query property (Keyword would be filter reference number, name, first_party_number, second_party_number, activity and description)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="parent_id", ref="#/components/schemas/ProjectEloquent/properties/parent_id"),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/ProjectEloquent/properties/company_id"),
     *                  @OA\Property(property="contract_type_id", ref="#/components/schemas/ProjectEloquent/properties/contract_type_id"),
     *                  @OA\Property(
     *                      property="start_issue_date",
     *                      description="Start issue date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_issue_date",
     *                      description="End issue date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_value",
     *                      description="Start value parameter",
     *                      type="float",
     *                      example="0"
     *                  ),
     *                  @OA\Property(
     *                      property="end_value",
     *                      description="End value parameter",
     *                      type="float",
     *                      example="100"
     *                  ),
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
     * @throws Exception
     */
    public function postProjectListSearch(Request $request)
    {
        $parentId = $request->has('parent_id') && !is_null($request->get('parent_id')) ? $request->input('parent_id') : null;
        $companyId = $request->input('company_id');
        $contractTypeId = $request->input('contract_type_id');
        $rangeIssueDate = new DateTimeRange($request->input('start_issue_date'), $request->input('end_issue_date'));
        $date = $request->has('date') && !is_null($request->get('date')) ? new DateTime($request->get('date')) : null;
        $rangeValue = new NumericRange($request->input('start_value'), $request->input('end_value'));

        return $this->getListSearchJson($request, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue,
            [$this->_projectServiceInterface, 'projectListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'contract_type'=> $this->getContractTypeObject($entity->contractType),
                        'reference_number' => $entity->reference_number,
                        'name' => $entity->name,
                        'first_party_number' => $entity->first_party_number,
                        'second_party_number' => $entity->second_party_number,
                        'issue_date' => $entity->issue_date,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'activity' => $entity->activity,
                        'description' => $entity->description,
                        'value' => $entity->value,
                        'is_contract' => $entity->is_contract,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/project/page-search",
     *     operationId="postProjectPageSearch",
     *     summary="Get list of project with query and page parameter search",
     *     tags={"Project"},
     *     description="Get list of project with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter reference number, name, first_party_number, second_party_number, activity and description)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="parent_id", ref="#/components/schemas/ProjectEloquent/properties/parent_id"),
     *                          @OA\Property(property="company_id", ref="#/components/schemas/ProjectEloquent/properties/company_id"),
     *                          @OA\Property(property="contract_type_id", ref="#/components/schemas/ProjectEloquent/properties/contract_type_id"),
     *                          @OA\Property(
     *                              property="start_issue_date",
     *                              description="Start issue date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="end_issue_date",
     *                              description="End issue date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="date",
     *                              description="Date parameter",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
     *                          @OA\Property(
     *                              property="start_value",
     *                              description="Start value parameter",
     *                              type="float",
     *                              example="0"
     *                          ),
     *                          @OA\Property(
     *                              property="end_value",
     *                              description="End value parameter",
     *                              type="float",
     *                              example="100"
     *                          ),
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
     * @throws Exception
     */
    public function postProjectPageSearch(Request $request)
    {
        $parentId = $request->input('parent_id');
        $companyId = $request->input('company_id');
        $contractTypeId = $request->input('contract_type_id');
        $rangeIssueDate = new DateTimeRange($request->input('start_issue_date'), $request->input('end_issue_date'));
        $date = $request->has('date') && !is_null($request->get('date')) ? new DateTime($request->get('date')) : null;
        $rangeValue = new NumericRange($request->input('start_value'), $request->input('end_value'));

        return $this->getPagedSearchJson($request, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue,
            [$this->_projectServiceInterface, 'projectPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'contract_type' => $this->getContractTypeObject($entity->contractType),
                        'reference_number' => $entity->reference_number,
                        'name' => $entity->name,
                        'first_party_number' => $entity->first_party_number,
                        'second_party_number' => $entity->second_party_number,
                        'issue_date' => $entity->issue_date,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'activity' => $entity->activity,
                        'description' => $entity->description,
                        'value' => $entity->value,
                        'is_contract' => $entity->is_contract,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/project/detail/{id}",
     *     operationId="getProjectDetail",
     *     summary="Get detail project",
     *     tags={"Project"},
     *     description="Get detail project",
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
    public function getProjectDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_projectServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'company' => $this->getCompanyObject($entity->company),
                        'contract_type' => $this->getContractTypeObject($entity->contractType),
                        'reference_number' => $entity->reference_number,
                        'name' => $entity->name,
                        'first_party_number' => $entity->first_party_number,
                        'second_party_number' => $entity->second_party_number,
                        'issue_date' => $entity->issue_date,
                        'start_date' => $entity->start_date,
                        'end_date' => $entity->end_date,
                        'activity' => $entity->activity,
                        'description' => $entity->description,
                        'value' => $entity->value,
                        'is_contract' => $entity->is_contract,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                        'media_libraries' => $entity->mediaLibraries
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/project/create",
     *     operationId="postProjectCreate",
     *     summary="Create project",
     *     tags={"Project"},
     *     description="Create project",
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
     *                      @OA\Schema(ref="#/components/schemas/CreateProjectEloquent"),
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
     *                                          example="document"
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="work_units",
     *                              description="Work Units",
     *                              type="array",
     *                              @OA\Items(
     *                                  type="integer",
     *                                  format="int64",
     *                                  example=1
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="project_addendums",
     *                              description="Project addendums",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateProjectAddendumEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="project_terms",
     *                              description="Project terms",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/CreateProjectTermsEloquent")
     *                          )
     *                      ),
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
     * @throws Exception
     */
    public function postProjectCreate(Request $request)
    {
        $createProjectRequest = new CreateProjectRequest();

        $createProjectRequest->parent_id = $request->input('parent_id');
        $createProjectRequest->company_id = $request->input('company_id');
        $createProjectRequest->contract_type_id = $request->input('contract_type_id');
        $createProjectRequest->reference_number = $request->input('reference_number');
        $createProjectRequest->name = $request->input('name');
        $createProjectRequest->first_party_number = $request->input('first_party_number');
        $createProjectRequest->second_party_number = $request->input('second_party_number');
        $createProjectRequest->issue_date = ($request->input('issue_date')) ? new DateTime($request->input('issue_date')) : null;
        $createProjectRequest->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $createProjectRequest->end_date = ($request->input('end_date')) ? new DateTime($request->input('end_date')) : null;
        $createProjectRequest->activity = $request->input('activity');
        $createProjectRequest->description = $request->input('description');
        $createProjectRequest->value = $request->input('value');
        $createProjectRequest->is_contract = $request->input('is_contract');
        $createProjectRequest->media_libraries = $request->input('media_libraries');

        // Has many
        $createProjectRequest->project_terms = $request->input('project_terms');
        $createProjectRequest->project_addendums = $request->input('project_addendums');

        // Many Many
        $createProjectRequest->work_units = $request->input('work_units');

        $this->setRequestAuthor($createProjectRequest);

        $project = $this->_projectServiceInterface->create($createProjectRequest);

        if (!$project->isSuccess()) {
            return $this->getBasicErrorJson($project);
        }

        $projectCreated = $project->getObject();

        if (isset($createProjectRequest->project_addendums) && !empty($createProjectRequest->project_addendums)) {
            foreach($createProjectRequest->project_addendums as $project_addendum) {
                $createProjectAddendumRequest = new CreateProjectAddendumRequest();

                $createProjectAddendumRequest->project_id = $projectCreated->id;
                $createProjectAddendumRequest->reference_number = $project_addendum['reference_number'];
                $createProjectAddendumRequest->name = $project_addendum['name'];
                $createProjectAddendumRequest->issue_date = $project_addendum['issue_date'];
                $createProjectAddendumRequest->start_date = $project_addendum['start_date'];
                $createProjectAddendumRequest->end_date = $project_addendum['end_date'];
                $createProjectAddendumRequest->description = $project_addendum['description'];
                $createProjectAddendumRequest->value = $project_addendum['value'];
                $createProjectAddendumRequest->is_contract = $project_addendum['is_contract'];
                $createProjectAddendumRequest->media_libraries = $project_addendum['media_libraries'];

                $this->setRequestAuthor($createProjectAddendumRequest);

                $projectAddendum = $this->_projectServiceInterface->createProjectAddendum($createProjectAddendumRequest);

                if (!$projectAddendum->isSuccess()) {
                    return $this->getBasicErrorJson($projectAddendum);
                }
            }
        }

        return $this->getBasicSuccessJson($project, $projectCreated);
    }

    /**
     * @OA\Put(
     *     path="/project/update",
     *     operationId="putProjectUpdate",
     *     summary="Update project",
     *     tags={"Project"},
     *     description="Update project",
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
     *                      @OA\Schema(ref="#/components/schemas/UpdateProjectEloquent"),
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
     *                                          example="document"
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="work_units",
     *                              description="Work Units",
     *                              type="array",
     *                              @OA\Items(
     *                                  type="integer",
     *                                  format="int64",
     *                                  example=1
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="project_addendums",
     *                              description="Project addendums",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateProjectAddendumEloquent")
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="project_terms",
     *                              description="Project terms",
     *                              type="array",
     *                              @OA\Items(ref="#/components/schemas/UpdateProjectTermsEloquent")
     *                          )
     *                      ),
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
     * @throws Exception
     */
    public function putProjectUpdate(Request $request)
    {
        $editProjectRequest = new EditProjectRequest();

        $editProjectRequest->id = $request->input('id');
        $editProjectRequest->parent_id = $request->input('parent_id');
        $editProjectRequest->company_id = $request->input('company_id');
        $editProjectRequest->contract_type_id = $request->input('contract_type_id');
        $editProjectRequest->reference_number = $request->input('reference_number');
        $editProjectRequest->name = $request->input('name');
        $editProjectRequest->first_party_number = $request->input('first_party_number');
        $editProjectRequest->second_party_number = $request->input('second_party_number');
        $editProjectRequest->issue_date = ($request->input('issue_date')) ? new DateTime($request->input('issue_date')) : null;
        $editProjectRequest->start_date = ($request->input('start_date')) ? new DateTime($request->input('start_date')) : null;
        $editProjectRequest->end_date = ($request->input('end_date')) ? new DatetIme($request->input('end_date')) : null;
        $editProjectRequest->activity = $request->input('activity');
        $editProjectRequest->description = $request->input('description');
        $editProjectRequest->value = $request->input('value');
        $editProjectRequest->is_contract = $request->input('is_contract');
        $editProjectRequest->media_libraries = $request->input('media_libraries');

        // Has many
        $editProjectRequest->project_terms = $request->input('project_terms');
        $editProjectRequest->project_addendums = $request->input('project_addendums');

        // Many Many
        $editProjectRequest->work_units = $request->input('work_units');

        $this->setRequestAuthor($editProjectRequest);

        $project = $this->_projectServiceInterface->update($editProjectRequest);

        if (!$project->isSuccess()) {
            return $this->getBasicErrorJson($project);
        }

        if (isset($editProjectRequest->project_addendums) && !empty($editProjectRequest->project_addendums)) {
            foreach($editProjectRequest->project_addendums as $project_addendum) {
                $editProjectAddendumRequest = new EditProjectAddendumRequest();

                $editProjectAddendumRequest->id = $project_addendum['id'];
                $editProjectAddendumRequest->project_id = $request->input('id');
                $editProjectAddendumRequest->reference_number = $project_addendum['reference_number'];
                $editProjectAddendumRequest->name = $project_addendum['name'];
                $editProjectAddendumRequest->issue_date = $project_addendum['issue_date'];
                $editProjectAddendumRequest->start_date = $project_addendum['start_date'];
                $editProjectAddendumRequest->end_date = $project_addendum['end_date'];
                $editProjectAddendumRequest->description = $project_addendum['description'];
                $editProjectAddendumRequest->value = $project_addendum['value'];
                $editProjectAddendumRequest->is_contract = $project_addendum['is_contract'];
                $editProjectAddendumRequest->media_libraries = $project_addendum['media_libraries'];

                $this->setRequestAuthor($editProjectAddendumRequest);

                $projectAddendum = $this->_projectServiceInterface->updateProjectAddendum($editProjectAddendumRequest);

                if (!$projectAddendum->isSuccess()) {
                    return $this->getBasicErrorJson($project);
                }
            }
        }

        return $this->getBasicSuccessJson($project);
    }

    /**
     * @OA\Delete(
     *     path="/project/delete/{id}",
     *     operationId="deleteProject",
     *     summary="Delete project",
     *     tags={"Project"},
     *     description="Delete project",
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
    public function deleteProject(int $id)
    {
        $project = $this->_projectServiceInterface->find($id);

        $result = $project->getObject();

        $response = $this->_projectServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/project/deletes",
     *     operationId="deleteBulkProject",
     *     summary="Delete bulk project",
     *     tags={"Project"},
     *     description="Delete bulk project",
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
    public function deleteBulkProject(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_projectServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/project/list-search/export",
     *     operationId="postProjectListSearchExport",
     *     summary="Export list of project",
     *     tags={"Project"},
     *     description="Export list of project",
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
     *                  @OA\Property(property="parent_id", ref="#/components/schemas/ProjectEloquent/properties/parent_id"),
     *                  @OA\Property(property="company_id", ref="#/components/schemas/ProjectEloquent/properties/company_id"),
     *                  @OA\Property(property="contract_type_id", ref="#/components/schemas/ProjectEloquent/properties/contract_type_id"),
     *                  @OA\Property(
     *                      property="start_issue_date",
     *                      description="Start issue date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="end_issue_date",
     *                      description="End issue date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date parameter",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="start_value",
     *                      description="Start value parameter",
     *                      type="float",
     *                      example="0"
     *                  ),
     *                  @OA\Property(
     *                      property="end_value",
     *                      description="End value parameter",
     *                      type="float",
     *                      example="100"
     *                  ),
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
     * @throws Exception
     */
    public function postProjectListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $parentId = $request->input('parent_id');
        $companyId = $request->input('company_id');
        $contractTypeId = $request->input('contract_type_id');
        $rangeIssueDate = new DateTimeRange($request->input('start_issue_date'), $request->input('end_issue_date'));
        $date = $request->has('date') && !is_null($request->get('date')) ? new DateTime($request->get('date')) : null;
        $rangeValue = new NumericRange($request->input('start_value'), $request->input('end_value'));

        return $this->getListSearchExportJson($request, $export, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue,
            [$this->_projectServiceInterface, 'projectListSearch'],
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

        $path = 'human-resources/projects/excel/';
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (Excel::store(new ProjectExport($entities), $path . $file)) {
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

        $path = storage_path('app/human-resources/projects/pdf/');
        $file = uniqid() . $ext;

        if(!File::exists($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        if (PDF::loadView('exports.human-resources.project.project', ['projects' => $entities])
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
     * @param int|null $id
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);
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
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param Collection $entities
     * @return Collection
     */
    private function getListProjectChildJson(int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null, Collection $entities)
    {
        $rowJsonData = new Collection();

        foreach ($entities as $entity) {
            $item = [
                'id' => $entity->id,
                'company' => $this->getCompanyObject($entity->company),
                'contract_type'=> $this->getContractTypeObject($entity->contractType),
                'reference_number' => $entity->reference_number,
                'name' => $entity->name,
                'first_party_number' => $entity->first_party_number,
                'second_party_number' => $entity->second_party_number,
                'issue_date' => $entity->issue_date,
                'start_date' => $entity->start_date,
                'end_date' => $entity->end_date,
                'activity' => $entity->activity,
                'description' => $entity->description,
                'value' => $entity->value,
                'is_contract' => $entity->is_contract,
                'created_by' => $entity->created_by,
                'modified_by' => $entity->modified_by,
                'media_libraries' => $entity->mediaLibraries
            ];

            $projectChild = $entity->projectChilds;

            if (!is_null($companyId)) {
                $projectChild = $projectChild->where('company_id', $companyId);
            }

            if (!is_null($contractTypeId)) {
                $projectChild = $projectChild->where('contract_type_id', $contractTypeId);
            }

            if (!is_null($rangeIssueDate->start) &&
                !is_null($rangeIssueDate->end)) {
                $projectChild = $projectChild->whereBetween('issue_date', [
                    $rangeIssueDate->start->format(Config::get('datetime.format.default')),
                    $rangeIssueDate->end->format(Config::get('datetime.format.default'))
                ]);
            }

            if (!is_null($rangeValue->start) &&
                !is_null($rangeValue->end)) {
                $projectChild = $projectChild->whereBetween('value', [$rangeValue->start, $rangeValue->end]);
            }

            if ($projectChild->count() > 0) {
                Arr::set($item, 'children', $this->getListProjectChildJson($companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue, $projectChild));
            }

            $rowJsonData->push($item);
        }

        return $rowJsonData;
    }

    /**
     * @param Request $request
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);
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
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListHierarchicalJson(int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null,
                                             callable $searchMethod,
                                             callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);
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
     * @param string|null $export
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection(), $export);

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
     * @param string|null $type
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoPageSearchToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null,
                                        callable $searchMethod,
                                        callable $dtoPageSearchToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $parentId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);
        $rowJsonData = $dtoPageSearchToRowJsonMethod($response->getDtoCollection());

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
     * @param ContractTypeInterface $entity
     * @return Collection
     */
    private function getContractTypeObject(ContractTypeInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param ProjectInterface $entity
     * @return Collection
     */
    private function getProjectParentObject(ProjectInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name,
            'project_parent' => Common::isDataExist($entity->projectParent) ? $this->getProjectParentObject($entity->projectParent) : null,
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
