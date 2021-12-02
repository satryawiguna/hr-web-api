<?php

namespace App\Domains\HumanResources\Personal\Employee\FormalEducationHistory;

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
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryServiceInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryInterface;
use DateTime;
use ErrorException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

/**
 * FormalEducationHistoryService Class
 * It has all useful methods for business logic.
 */
class FormalEducationHistoryService extends ServiceAbstract implements FormalEducationHistoryServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var FormalEducationHistoryRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our FormalEducationHistoryInterface
     * FormalEducationHistoryService constructor.
     *
     * @param FormalEducationHistoryRepositoryInterface $repository
     */
    public function __construct(FormalEducationHistoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(FormalEducationHistoryInterface $FormalEducationHistory)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($FormalEducationHistory->toArray(), [
            'employee_id' => 'required',
            'degree_id' => 'required',
            'major_id' => 'required',
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($FormalEducationHistory);

        try {
            $result = $this->repository->create($FormalEducationHistory);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Formal education history was created', 200);
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
     * @param Collection $FormalEducationHistories
     * @return BasicResponse|mixed
     */
    public function insert(Collection $FormalEducationHistories)
    {
        $response = new BasicResponse();

        $FormalEducationHistories->map(function ($row) use ($response) {
            $validator = Validator::make($row->toArray(), [
                'employee_id' => 'required',
                'degree_id' => 'required',
                'major_id' => 'required',
                'name' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date'
            ]);

            if ($validator->fails()) {
                $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                return $response;
            }

            $this->setAuditableInformationFromRequest($row);
        });


        try {
            $this->repository->insert($FormalEducationHistories);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Formal education history was created', 200);
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
    public function update(FormalEducationHistoryInterface $FormalEducationHistory, array $params = [])
    {
        $response = new BasicResponse();

        $validator = Validator::make($FormalEducationHistory->toArray(), [
            'employee_id' => 'required',
            'degree_id' => 'required',
            'major_id' => 'required',
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($FormalEducationHistory);

        try {
            if (!$params) {
                $this->repository->update($FormalEducationHistory);
            } else {
                $this->repository->updateOrCreate($FormalEducationHistory, $params);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Formal education history was updated', 200);
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
    public function delete(FormalEducationHistoryInterface $FormalEducationHistory)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($FormalEducationHistory);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Formal education history was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Formal education was deleted', 200);
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function formalEducationHistoryList(int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->formalEducationHistoryList($companyId, $employeeId, $degreeId, $majorId, $date);

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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function formalEducationHistoryListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->formalEducationHistoryListSearch($parameter, $companyId, $employeeId, $degreeId, $majorId, $date);
            $totalCount = $this->repository->formalEducationHistoryListSearch($parameter, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, true);

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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function formalEducationHistoryPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null): GenericPageSearchResponse
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

            $results = $this->repository->formalEducationHistoryPageSearch($parameter, $companyId, $employeeId, $degreeId, $majorId, $date);
            $totalCount = $this->repository->formalEducationHistoryPageSearch($parameter, $companyId, $employeeId, $degreeId, $majorId, $date, true);
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
