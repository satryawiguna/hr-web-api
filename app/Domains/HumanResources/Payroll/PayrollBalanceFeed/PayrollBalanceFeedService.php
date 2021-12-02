<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalanceFeed;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollBalanceFeed\Contracts\PayrollBalanceFeedInterface;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * PayrollBalanceFeedService Class
 * It has all useful methods for business logic.
 */
class PayrollBalanceFeedService extends ServiceAbstract implements PayrollBalanceFeedServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var PayrollBalanceFeedRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our PayrollBalanceFeedInterface
     * PayrollBalanceFeedService constructor.
     *
     * @param PayrollBalanceFeedRepositoryInterface $repository
     */
    public function __construct(PayrollBalanceFeedRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(PayrollBalanceFeedInterface $PayrollBalanceFeed)
    {
        $response = new BasicResponse();

        $validator = Validator::make($PayrollBalanceFeed->toArray(), [
            'payroll_balance_id' => 'required',
            'element_id' => 'required',
            'element_value_id' => 'required',
            'add_or_subtract' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PayrollBalanceFeed);

        try {
            $this->repository->create($PayrollBalanceFeed);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll balance feed was created', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollBalanceFeedInterface $PayrollBalanceFeed)
    {
        $response = new BasicResponse();

        $validator = Validator::make($PayrollBalanceFeed->toArray(), [
            'payroll_balance_id' => 'required',
            'element_id' => 'required',
            'element_value_id' => 'required',
            'add_or_subtract' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PayrollBalanceFeed);

        try {
            $this->repository->update($PayrollBalanceFeed);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll balance feed was updated', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollBalanceFeedInterface $PayrollBalanceFeed)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($PayrollBalanceFeed);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll balance feed was deleted', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @return GenericCollectionResponse
     */
    public function payrollBalanceFeedList(int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        $results = $this->repository->payrollBalanceFeedList($payrollBalanceId, $elementId, $elementValueId);

        foreach ($results as $result) {
            $response->_dtoCollection->push($result);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @return GenericListSearchResponse
     */
    public function payrollBalanceFeedListSearch(ListSearchRequest $listSearchRequest, int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        $parameter->query = $listSearchRequest->query;

        $results = $this->repository->payrollBalanceFeedListSearch($parameter, $payrollBalanceId, $elementId, $elementValueId);
        $totalCount = $this->repository->payrollBalanceFeedListSearch($parameter, $payrollBalanceId, $elementId, $elementValueId, true);

        foreach ($results as $result) {
            $response->_dtoCollection->push($result);
        }

        $response->_totalCount = $totalCount;

        return $response;
    }

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int|null $payrollBalanceId
     * @param int|null $elementId
     * @param int|null $elementValueId
     * @return GenericPageSearchResponse
     */
    public function payrollBalanceFeedPageSearch(PageSearchRequest $pageSearchRequest, int $payrollBalanceId = null, int $elementId = null, int $elementValueId = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

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

        $results = $this->repository->payrollBalanceFeedPageSearch($parameter, $payrollBalanceId, $elementId, $elementValueId);
        $totalCount = $this->repository->payrollBalanceFeedPageSearch($parameter, $payrollBalanceId, $elementId, $elementValueId, true);

        if ($pageSearchRequest->draw) {
            $totalPage = ceil($totalCount / $parameter->length);
        } else {
            $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
        }

        foreach ($results as $result) {
            $response->_dtoCollection->push($result);
        }

        $response->_totalCount = $totalCount;
        $response->_totalPage = $totalPage;

        return $response;
    }

    //</editor-fold>
}
