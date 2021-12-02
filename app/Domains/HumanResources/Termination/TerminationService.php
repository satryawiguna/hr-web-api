<?php

namespace App\Domains\HumanResources\Termination;

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
use App\Domains\HumanResources\Termination\Contracts\TerminationRepositoryInterface;
use App\Domains\HumanResources\Termination\Contracts\TerminationServiceInterface;
use App\Domains\HumanResources\Termination\Contracts\TerminationInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * TerminationService Class
 * It has all useful methods for business logic.
 */
class TerminationService extends ServiceAbstract implements TerminationServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var TerminationRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our TerminationInterface
     * TerminationService constructor.
     *
     * @param TerminationRepositoryInterface $repository
     */
    public function __construct(TerminationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(TerminationInterface $Termination)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Termination->toArray(), [
            'employee_id' => 'required',
            'type' => 'required',
            'termination_date' => 'required',
            'severance' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Termination);

        try {
            $result = $this->repository->create($Termination);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Termination was created', 200);
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
    public function update(TerminationInterface $Termination)
    {
        $response = new BasicResponse();

        $validator = Validator::make($Termination->toArray(), [
            'employee_id' => 'required',
            'type' => 'required',
            'termination_date' => 'required',
            'severance' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Termination);

        try {
            $this->repository->update($Termination);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Termination was updated', 200);
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
    public function delete(TerminationInterface $Termination)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($Termination);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Termination was deleted', 200);
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
            $this->repository->deleteBulk($ids);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Terminations was deleted', 200);
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
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @return GenericCollectionResponse
     */
    public function terminationList(int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->terminationList($employeeId, $type, $rangeTerminationDate, $rangeSeverance);

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
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @return GenericListSearchResponse
     */
    public function terminationListSearch(ListSearchRequest $listSearchRequest, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->terminationListSearch($parameter, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
            $totalCount = $this->repository->terminationListSearch($parameter, $employeeId, $type, $rangeTerminationDate, $rangeSeverance, true);

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
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @return GenericPageSearchResponse
     */
    public function terminationPageSearch(PageSearchRequest $pageSearchRequest, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null): GenericPageSearchResponse
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

            $results = $this->repository->terminationPageSearch($parameter, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
            $totalCount = $this->repository->terminationPageSearch($parameter, $employeeId, $type, $rangeTerminationDate, $rangeSeverance,true);
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
