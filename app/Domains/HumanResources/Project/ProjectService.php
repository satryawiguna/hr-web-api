<?php

namespace App\Domains\HumanResources\Project;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Project\Contracts\Request\CreateProjectRequest;
use App\Domains\HumanResources\Project\Contracts\Request\EditProjectRequest;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\Request\CreateProjectAddendumRequest;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\Request\EditProjectAddendumRequest;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Project\Contracts\ProjectRepositoryInterface;
use App\Domains\HumanResources\Project\Contracts\ProjectServiceInterface;
use App\Domains\HumanResources\Project\Contracts\ProjectInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumRepositoryInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumInterface;
use App\Helpers\Slim;
use App\Helpers\SlimStatus;
use DateTime;
use Auth;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

/**
 * ProjectService Class
 * It has all useful methods for business logic.
 */
class ProjectService extends ServiceAbstract implements ProjectServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var ProjectRepositoryInterface
     */
    protected $repository;

    protected $repositoryProjectAddendums;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our ProjectInterface
     * ProjectService constructor.
     *
     * @param ProjectRepositoryInterface $repository
     * @param ProjectAddendumRepositoryInterface $repositoryProjectAddendums
     */
    public function __construct(ProjectRepositoryInterface $repository,
                                ProjectAddendumRepositoryInterface $repositoryProjectAddendums)
    {
        $this->repository = $repository;
        $this->repositoryProjectAddendums = $repositoryProjectAddendums;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @param CreateProjectRequest $request
     * @return ObjectResponse
     */
    public function create(CreateProjectRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'company_id' => 'required',
            'contract_type_id' => 'required',
            'reference_number' => 'required',
            'name' => 'required',
            'first_party_number' => 'required',
            'second_party_number' => 'required',
            'issue_date' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'activity' => 'required',
            'description' => 'min:100',
            'value' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $project = $this->newInstance([
                'parent_id' => $request->parent_id,
                'company_id' => $request->company_id,
                'contract_type_id' => $request->contract_type_id,
                'reference_number' => $request->reference_number,
                'name' => $request->name,
                'first_party_number' => $request->first_party_number,
                'second_party_number' => $request->second_party_number,
                'issue_date' => $request->issue_date,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'activity' => $request->activity,
                'description' => $request->description,
                'value' => $request->value,
                'is_contract' => $request->is_contract,
            ]);

            $this->setAuditableInformationFromRequest($project, $request);

            $mediaLibraries = [];

            if ($request->media_libraries) {
                foreach ($request->media_libraries as $item) {
                    $mediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }

            $relation = [];

            if (isset($request->project_terms) && !empty($request->project_terms)) {
                foreach ($request->project_terms as $key => $value) {
                    $request->project_terms[$key] = $this->setAuditableInformationFromRequest($value, $request);
                }

                foreach ($request->project_terms as $project_term) {
                    $validator = Validator::make((array) $project_term, [
                        'step' => 'required',
                        'name' => 'required',
                        'value' => 'required',
                    ]);

                    if ($validator->fails()) {
                        $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                        return $response;
                    }
                }

                $relation['projectTerms'] = [
                    'data' => $request->project_terms,
                    'method' => 'createMany'
                ];
            }

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $mediaLibraries,
                    'method' => 'attach'
                ],
                'workUnits' => [
                    'data' => $request->work_units,
                    'method' => 'attach'
                ],
            ];

            $projectResult = $this->repository->create($project, $relation);

            $response->setResult($projectResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project was created', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param CreateProjectAddendumRequest $request
     * @return BasicResponse
     */
    public function createProjectAddendum(CreateProjectAddendumRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make((array) $request, [
            'project_id' => 'required',
            'reference_number' => 'required',
            'name' => 'required',
            'issue_date' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $projectAddendum = $this->repositoryProjectAddendums->newInstance([
                'project_id'       => $request->project_id,
                'reference_number' => $request->reference_number,
                'name'             => $request->name,
                'issue_date'       => ($request->issue_date) ? new DateTime($request->issue_date) : null,
                'start_date'       => ($request->start_date) ? new DateTime($request->start_date) : null,
                'end_date'         => ($request->end_date) ? new DateTime($request->end_date) : null,
                'description'      => $request->description,
                'value'            => $request->value,
                'is_contract'      => $request->is_contract
            ]);

            $this->setAuditableInformationFromRequest($projectAddendum, $request);

            $projectAddendumMediaLibraries = [];

            if ($projectAddendum->media_libraries) {
                foreach ($projectAddendum->media_libraries as $item) {
                    $projectAddendumMediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $projectAddendumMediaLibraries,
                    'method' => 'attach'
                ],
            ];

            $this->repositoryProjectAddendums->create($projectAddendum, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project addendum was created', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function update(EditProjectRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make((array) $request, [
            'company_id' => 'required',
            'contract_type_id' => 'required',
            'reference_number' => 'required',
            'name' => 'required',
            'first_party_number' => 'required',
            'second_party_number' => 'required',
            'issue_date' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'activity' => 'required',
            'description' => 'min:100',
            'value' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $project = $this->repository->find($request->id);

            $project->fill([
                'parent_id' => $request->parent_id,
                'company_id' => $request->company_id,
                'contract_type_id' => $request->contract_type_id,
                'reference_number' => $request->reference_number,
                'name' => $request->name,
                'first_party_number' => $request->first_party_number,
                'second_party_number' => $request->second_party_number,
                'issue_date' => $request->issue_date,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'activity' => $request->activity,
                'description' => $request->description,
                'value' => $request->value,
                'is_contract' => $request->is_contract,
            ]);

            $this->setAuditableInformationFromRequest($project, $request);

            $mediaLibraries = [];

            if ($request->media_libraries) {
                foreach ($request->media_libraries as $item) {
                    $mediaLibraries[$item['media_library_id']] = [
                        'attribute' => $item['pivot']['attribute']
                    ];
                }
            }

            $relation = [];

            if (isset($request->project_terms) && !empty($request->project_terms)) {
                foreach ($request->project_terms as $key => $value) {
                    $request->project_terms[$key] = $this->setAuditableInformationFromRequest($value, $request);
                }

                foreach ($request->project_terms as $project_term) {
                    $validator = Validator::make((array) $project_term, [
                        'step' => 'required',
                        'name' => 'required',
                        'value' => 'required',
                    ]);

                    if ($validator->fails()) {
                        $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                        return $response;
                    }
                }

                $relation['projectTerms'] = [
                    'data'     => $request->project_terms,
                    'method'   => 'sync',
                    'isDetach' => false
                ];
            }

            $relation = [
                'morphMediaLibraries' => [
                    'data' => $mediaLibraries,
                    'method' => 'sync'
                ],
                'workUnits' => [
                    'data' => $request->work_units,
                    'method' => 'sync'
                ],
            ];

            $projectResult = $this->repository->update($project, $relation);

            $response->setResult($projectResult);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project was updated', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    public function updateProjectAddendum(EditProjectAddendumRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        $projectAddendumId = $request->id;

        try {
            switch ($request->id) {
                case ($request->id == 0 || !$request->id):
                    $validator = Validator::make((array) $request, [
                        'reference_number' => 'required',
                        'name' => 'required',
                        'issue_date' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'value' => 'required',
                    ]);

                    if ($validator->fails()) {
                        $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                        return $response;
                    }

                    $projectAddendum = $this->repositoryProjectAddendums->newInstance([
                        'project_id'       => $request->project_id,
                        'reference_number' => $request->reference_number,
                        'name'             => $request->name,
                        'issue_date'       => ($request->issue_date) ? new DateTime($request->issue_date) : null,
                        'start_date'       => ($request->start_date) ? new DateTime($request->start_date) : null,
                        'end_date'         => ($request->end_date) ? new DateTime($request->end_date) : null,
                        'description'      => $request->description,
                        'value'            => $request->value,
                        'is_contract'      => $request->is_contract
                    ]);

                    $this->setAuditableInformationFromRequest($projectAddendum, $request);

                    $projectAddendumMediaLibraries = [];

                    if ($projectAddendum->media_libraries) {
                        foreach ($projectAddendum->media_libraries as $item) {
                            $projectAddendumMediaLibraries[$item['media_library_id']] = [
                                'attribute' => $item['pivot']['attribute']
                            ];
                        }
                    }

                    $relation = [
                        'morphMediaLibraries' => [
                            'data' => $projectAddendumMediaLibraries,
                            'method' => 'attach'
                        ],
                    ];

                    $this->repositoryProjectAddendums->create($projectAddendum, $relation);

                    $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project addendum was created', 200);
                    break;

                case ($request->id < 0):
                    $projectAddendum = $this->repositoryProjectAddendums->find(abs($request->id));

                    $relation = [
                        'morphMediaLibraries' => [
                            'method' => 'detach'
                        ]
                    ];

                    $this->repositoryProjectAddendums->delete($projectAddendum, false, $relation);

                    $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project addendum was deleted', 200);
                    break;

                default:
                    $validator = Validator::make((array) $request, [
                        'reference_number' => 'required',
                        'name' => 'required',
                        'issue_date' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'value' => 'required',
                    ]);

                    if ($validator->fails()) {
                        $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                        return $response;
                    }

                    $projectAddendum = $this->repositoryProjectAddendums->find($projectAddendumId);

                    $projectAddendum->fill([
                        'project_id'       => $request->project_id,
                        'reference_number' => $request->reference_number,
                        'name'             => $request->name,
                        'issue_date'       => ($request->issue_date) ? new DateTime($request->issue_date) : null,
                        'start_date'       => ($request->start_date) ? new DateTime($request->start_date) : null,
                        'end_date'         => ($request->end_date) ? new DateTime($request->end_date) : null,
                        'description'      => $request->description,
                        'value'            => $request->value,
                        'is_contract'      => $request->is_contract
                    ]);

                    $this->setAuditableInformationFromRequest($projectAddendum, $request);

                    $projectAddendumMediaLibraries = [];

                    if ($request->media_libraries) {
                        foreach ($request->media_libraries as $item) {
                            $projectAddendumMediaLibraries[$item['media_library_id']] = [
                                'attribute' => $item['pivot']['attribute']
                            ];
                        }
                    }

                    $relation = [
                        'morphMediaLibraries' => [
                            'data' => $projectAddendumMediaLibraries,
                            'method' => 'sync'
                        ],
                    ];

                    $this->repositoryProjectAddendums->update($projectAddendum, $relation);

                    $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project addendum was updated', 200);
                    break;
            }


        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProjectInterface $Project): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'morphMediaLibraries' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->delete($Project, false, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param array $ids
     * @return BasicResponse|mixed
     */
    public function deleteBulk(array $ids)
    {
        $response = new BasicResponse();

        try {
            $relation = [
                'morphMediaLibraries' => [
                    'method' => 'detach'
                ]
            ];

            $this->repository->deleteBulk($ids, false, $relation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericCollectionResponse
     */
    public function projectList(int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->projectList($parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericCollectionResponse
     */
    public function projectListHierarchical(int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->projectListHierarchical($companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericListSearchResponse
     */
    public function projectListSearch(ListSearchRequest $listSearchRequest, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->projectListSearch($parameter, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);
            $totalCount = $this->repository->projectListSearch($parameter, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericPageSearchResponse
     */
    public function projectPageSearch(PageSearchRequest $pageSearchRequest, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

        try {
            if ($pageSearchRequest->draw) {
                $parameter->draw = $pageSearchRequest->draw;
                $parameter->columns = $pageSearchRequest->columns;
                $parameter->order = $pageSearchRequest->order;
                $parameter->start = $pageSearchRequest->start;
                $parameter->length = $pageSearchRequest->length;
                $parameter->search = $pageSearchRequest->search;
            } else {
                $parameter->pagination = $pageSearchRequest->pagination;
                $parameter->query = $pageSearchRequest->query;
                $parameter->sort = $pageSearchRequest->sort;
            }

            $results = $this->repository->projectPageSearch($parameter, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue);
            $totalCount = $this->repository->projectPageSearch($parameter, $parentId, $companyId, $contractTypeId, $rangeIssueDate, $date, $rangeValue, true);
            if ($pageSearchRequest->draw) {
                $totalPage = ceil($totalCount / $parameter->length);
            } else {
                $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
            }

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);
            $response->setTotalPage($totalPage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    //</editor-fold>
}
