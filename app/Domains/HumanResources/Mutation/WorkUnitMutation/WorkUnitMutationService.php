<?php

namespace App\Domains\HumanResources\Mutation\WorkUnitMutation;

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
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationServiceInterface;
use App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts\WorkUnitMutationInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * WorkUnitMutationService Class
 * It has all useful methods for business logic.
 */
class WorkUnitMutationService extends ServiceAbstract implements WorkUnitMutationServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var WorkUnitMutationRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our WorkUnitMutationInterface
     * WorkUnitMutationService constructor.
     *
     * @param WorkUnitMutationRepositoryInterface $repository
     */
    public function __construct(WorkUnitMutationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(WorkUnitMutationInterface $WorkUnitMutation)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($WorkUnitMutation->toArray(), [
            'employee_id' => 'required',
            'work_unit_id' => 'required',
            'mutation_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkUnitMutation);

        try {
            $result = $this->repository->create($WorkUnitMutation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit mutation was created', 200);
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
    public function update(WorkUnitMutationInterface $WorkUnitMutation)
    {
        $response = new BasicResponse();

        $validator = Validator::make($WorkUnitMutation->toArray(), [
            'employee_id' => 'required',
            'work_unit_id' => 'required',
            'mutation_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkUnitMutation);

        try {
            $this->repository->update($WorkUnitMutation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit mutation was updated', 200);
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
     * @return BasicResponse
     */
    public function delete(WorkUnitMutationInterface $WorkUnitMutation): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->deleteWhere([
                ['employee_id', '=', $WorkUnitMutation->employee_id],
                ['id', '=', $WorkUnitMutation->id]
            ]);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit mutation was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit mutations was deleted', 200);
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
    public function showWorkUnitMutation(int $employeeId, int $id): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $workUnitMutationResult = $this->repository->findWhere([
                ['employee_id', '=', $employeeId],
                ['id', '=', $id]
            ]);

            $response->setResult($workUnitMutationResult);

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
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @return GenericCollectionResponse
     */
    public function workUnitMutationList(int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->workUnitMutationList($employeeId, $workUnitId, $rangeMutationDate);

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
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @return GenericListSearchResponse
     */
    public function workUnitMutationListSearch(ListSearchRequest $listSearchRequest, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->workUnitMutationListSearch($parameter, $employeeId, $workUnitId, $rangeMutationDate);
            $totalCount = $this->repository->workUnitMutationListSearch($parameter, $employeeId, $workUnitId, $rangeMutationDate, true);

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
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @return GenericPageSearchResponse
     */
    public function workUnitMutationPageSearch(PageSearchRequest $pageSearchRequest, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null): GenericPageSearchResponse
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

            $results = $this->repository->workUnitMutationPageSearch($parameter, $employeeId, $workUnitId, $rangeMutationDate);
            $totalCount = $this->repository->workUnitMutationPageSearch($parameter, $employeeId, $workUnitId, $rangeMutationDate, true);
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
