<?php

namespace App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory;

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
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryServiceInterface;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts\NonFormalEducationHistoryInterface;
use DateTime;
use ErrorException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

/**
 * NonFormalEducationHistoryService Class
 * It has all useful methods for business logic.
 */
class NonFormalEducationHistoryService extends ServiceAbstract implements NonFormalEducationHistoryServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var NonFormalEducationHistoryRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our NonFormalEducationHistoryInterface
     * NonFormalEducationHistoryService constructor.
     *
     * @param NonFormalEducationHistoryRepositoryInterface $repository
     */
    public function __construct(NonFormalEducationHistoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(NonFormalEducationHistoryInterface $NonFormalEducationHistory)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($NonFormalEducationHistory->toArray(), [
            'employee_id' => 'required',
            'type' => 'required',
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'institution' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($NonFormalEducationHistory);

        try {
            $result = $this->repository->create($NonFormalEducationHistory);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Non formal education history was created', 200);
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
     * @param Collection $NonFormalEducationHistories
     * @return BasicResponse|mixed
     */
    public function insert(Collection $NonFormalEducationHistories)
    {
        $response = new BasicResponse();

        $NonFormalEducationHistories->map(function ($row) use ($response) {
            $validator = Validator::make($row->toArray(), [
                'employee_id' => 'required',
                'type' => 'required',
                'name' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'institution' => 'required'
            ]);

            if ($validator->fails()) {
                $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                return $response;
            }

            $this->setAuditableInformationFromRequest($row);
        });

        try {
            $this->repository->insert($NonFormalEducationHistories);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Non formal education history was created', 200);
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
    public function update(NonFormalEducationHistoryInterface $NonFormalEducationHistory, array $params = [])
    {
        $response = new BasicResponse();

        $validator = Validator::make($NonFormalEducationHistory->toArray(), [
            'employee_id' => 'required',
            'type' => 'required',
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'institution' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($NonFormalEducationHistory);

        try {
            if (!$params) {
                $this->repository->update($NonFormalEducationHistory);
            } else {
                $this->repository->updateOrCreate($NonFormalEducationHistory, $params);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Non formal education history was updated', 200);
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
    public function delete(NonFormalEducationHistoryInterface $NonFormalEducationHistory)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($NonFormalEducationHistory);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Non formal education history was deleted', 200);
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
     * @return BasicResponse
     */
    public function deleteBulk(array $ids)
    {
        $response = new BasicResponse();

        try {
            $this->repository->deleteBulk($ids);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Non formal education was deleted', 200);
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
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function nonFormalEducationHistoryList(int $companyId = null, int $employeeId = null, DateTime $date = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->nonFormalEducationHistoryList($companyId, $employeeId, $date);

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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function nonFormalEducationHistoryListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->nonFormalEducationHistoryListSearch($parameter, $companyId, $employeeId, $date);
            $totalCount = $this->repository->nonFormalEducationHistoryListSearch($parameter, $companyId, $employeeId, $date, true);

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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function nonFormalEducationHistoryPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericPageSearchResponse
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

            $results = $this->repository->nonFormalEducationHistoryPageSearch($parameter, $companyId, $employeeId, $date);
            $totalCount = $this->repository->nonFormalEducationHistoryPageSearch($parameter, $companyId, $employeeId, $date, true);
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
