<?php

namespace App\Domains\HumanResources\Mutation\ProjectMutation;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationServiceInterface;
use App\Domains\HumanResources\Mutation\ProjectMutation\Contracts\ProjectMutationInterface;
use DateTime;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * ProjectMutationService Class
 * It has all useful methods for business logic.
 */
class ProjectMutationService extends ServiceAbstract implements ProjectMutationServiceInterface
{
    /**
     * @var ProjectMutationRepositoryInterface
     */
    protected $repository;

    /**
     * Loads our $repo with the actual Repo associated with our ProjectMutationInterface
     * ProjectMutationService constructor.
     *
     * @param ProjectMutationRepositoryInterface $repository
     */
    public function __construct(ProjectMutationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ProjectMutationInterface $ProjectMutation)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($ProjectMutation->toArray(), [
            'project_id' => 'required',
            'mutation_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($ProjectMutation);

        try {
            $result = $this->repository->create($ProjectMutation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project mutation was created', 200);
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
    public function update(ProjectMutationInterface $ProjectMutation)
    {
        $response = new BasicResponse();

        $validator = Validator::make($ProjectMutation->toArray(), [
            'project_id' => 'required',
            'mutation_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($ProjectMutation);

        try {
            $this->repository->update($ProjectMutation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project mutation was updated', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    public function delete(int $employeeId, int $id): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->deleteWhere([
                ['employee_id', '=', $employeeId],
                ['id', '=', $id]
            ]);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project mutation was deleted', 200);
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
     * @param int $employeeId
     * @param array $ids
     * @return BasicResponse|mixed
     */
    public function deleteBulk(int $employeeId, array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            foreach ($ids as $id) {
                $this->repository->deleteWhere([
                    ['employee_id', '=', $employeeId],
                    ['id', '=', $id]
                ]);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Project mutations was deleted', 200);
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
     * @param int $employeeId
     * @param int $id
     * @return ObjectResponse
     */
    public function showProjectMutation(int $employeeId, int $id): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $projectMutationResult = $this->repository->findWhere([
                ['employee_id', '=', $employeeId],
                ['id', '=', $id]
            ])->first();

            $response->setResult($projectMutationResult);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @return GenericCollectionResponse
     */
    public function projectMutationList(int $employeeId = null, int $projectId = null, object $rangeMutationDate = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->projectMutationList($employeeId, $projectId, $rangeMutationDate);

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
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @return GenericListSearchResponse
     */
    public function projectMutationListSearch(ListSearchRequest $listSearchRequest, int $employeeId = null, int  $projectId = null, object $rangeMutationDate = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->projectMutationListSearch($parameter, $employeeId, $projectId, $rangeMutationDate);
            $totalCount = $this->repository->projectMutationListSearch($parameter, $employeeId, $projectId, $rangeMutationDate, true);

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
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @return GenericPageSearchResponse
     */
    public function projectMutationPageSearch(PageSearchRequest $pageSearchRequest, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null): GenericPageSearchResponse
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

            $results = $this->repository->projectMutationPageSearch($parameter, $employeeId, $projectId, $rangeMutationDate);
            $totalCount = $this->repository->projectMutationPageSearch($parameter, $employeeId, $projectId, $rangeMutationDate, true);
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
