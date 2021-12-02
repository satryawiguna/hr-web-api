<?php

namespace App\Domains\HumanResources\Mutation\PositionMutation;

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
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationRepositoryInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationServiceInterface;
use App\Domains\HumanResources\Mutation\PositionMutation\Contracts\PositionMutationInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * PositionMutationService Class
 * It has all useful methods for business logic.
 */
class PositionMutationService extends ServiceAbstract implements PositionMutationServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var PositionMutationRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our PositionMutationInterface
     * PositionMutationService constructor.
     *
     * @param PositionMutationRepositoryInterface $repository
     */
    public function __construct(PositionMutationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(PositionMutationInterface $PositionMutation)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($PositionMutation->toArray(), [
            'employee_id' => 'required',
            'position_id' => 'required',
            'mutation_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PositionMutation);

        try {
            $result = $this->repository->create($PositionMutation);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Position mutation was created', 200);
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
    public function update(PositionMutationInterface $PositionMutation)
    {
        $response = new BasicResponse();

        $validator = Validator::make($PositionMutation->toArray(), [
            'employee_id' => 'required',
            'position_id' => 'required',
            'mutation_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PositionMutation);

        try {
            $this->repository->update($PositionMutation);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Position mutation was updated', 200);
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
    public function delete(int $employeeId, int $id): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->deleteWhere([
                ['employee_id', '=', $employeeId],
                ['id', '=', $id]
            ]);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Position mutation was deleted', 200);
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
     * @return BasicResponse
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Position mutations was deleted', 200);
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
    public function showPositionMutation(int $employeeId, int $id): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $positionMutationResult = $this->repository->findWhere([
                ['employee_id', '=', $employeeId],
                ['id', '=', $id]
            ])->first();

            $response->setResult($positionMutationResult);

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
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @return GenericCollectionResponse
     */
    public function positionMutationList(int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->positionMutationList($employeeId, $positionId, $gradeId, $rangeMutationDate);

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
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @return GenericListSearchResponse
     */
    public function positionMutationListSearch(ListSearchRequest $listSearchRequest, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->positionMutationListSearch($parameter, $employeeId, $positionId, $gradeId, $rangeMutationDate);
            $totalCount = $this->repository->positionMutationListSearch($parameter, $employeeId, $positionId, $gradeId, $rangeMutationDate, true);

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
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @return GenericPageSearchResponse
     */
    public function positionMutationPageSearch(PageSearchRequest $pageSearchRequest, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null): GenericPageSearchResponse
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

            $results = $this->repository->positionMutationPageSearch($parameter, $employeeId, $positionId, $gradeId, $rangeMutationDate);
            $totalCount = $this->repository->positionMutationPageSearch($parameter, $employeeId, $positionId, $gradeId, $rangeMutationDate, true);
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

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int|null $companyId
     * @param int|null $positionId
     * @param object|null $rangeMutationDate
     * @return GenericPageSearchResponse
     */
    public function positionMutationPageSearchCompany(PageSearchRequest $pageSearchRequest, int $companyId = null, int $positionId = null, object $rangeMutationDate = null): GenericPageSearchResponse
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

            $results = $this->repository->positionMutationPageSearchCompany($parameter, $companyId, $positionId, $rangeMutationDate);
            $totalCount = $this->repository->positionMutationPageSearchCompany($parameter, $companyId, $positionId, $rangeMutationDate, true);

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
