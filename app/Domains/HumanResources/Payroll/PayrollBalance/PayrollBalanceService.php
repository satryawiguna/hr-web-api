<?php

namespace App\Domains\HumanResources\Payroll\PayrollBalance;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollBalance\Contracts\PayrollBalanceInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * PayrollBalanceService Class
 * It has all useful methods for business logic.
 */
class PayrollBalanceService extends ServiceAbstract implements PayrollBalanceServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var PayrollBalanceRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our PayrollBalanceInterface
     * PayrollBalanceService constructor.
     *
     * @param PayrollBalanceRepositoryInterface $repository
     */
    public function __construct(PayrollBalanceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(PayrollBalanceInterface $PayrollBalance)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($PayrollBalance->toArray(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PayrollBalance);

        try {
            $result = $this->repository->create($PayrollBalance);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll balance was created', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollBalanceInterface $PayrollBalance)
    {
        $response = new BasicResponse();

        $validator = Validator::make($PayrollBalance->toArray(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PayrollBalance);

        try {
            $this->repository->update($PayrollBalance);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll balance was updated', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollBalanceInterface $PayrollBalance)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($PayrollBalance);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll balance was deleted', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * @return GenericCollectionResponse
     */
    public function payrollBalanceList(): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        $results = $this->repository->payrollBalanceList();

        foreach ($results as $result) {
            $response->_dtoCollection->push($result);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @return GenericListSearchResponse
     */
    public function payrollBalanceListSearch(ListSearchRequest $listSearchRequest): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        $parameter->query = $listSearchRequest->query;

        $results = $this->repository->payrollBalanceListSearch($parameter);
        $totalCount = $this->repository->payrollBalanceListSearch($parameter, true);

        foreach ($results as $result) {
            $response->_dtoCollection->push($result);
        }

        $response->_totalCount = $totalCount;

        return $response;
    }

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @return GenericPageSearchResponse
     */
    public function payrollBalancePageSearch(PageSearchRequest $pageSearchRequest): GenericPageSearchResponse
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

        $results = $this->repository->payrollBalancePageSearch($parameter);
        $totalCount = $this->repository->payrollBalancePageSearch($parameter, true);

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

    /**
     * @param PayrollBalanceInterface $PayrollBalance
     * @return ObjectResponse
     */
    public function payrollBalanceSlug(PayrollBalanceInterface $PayrollBalance): ObjectResponse
    {
        $response = new ObjectResponse();

        $result = $result = (object)[
            'slug' => SlugService::createSlug($PayrollBalance, 'slug', $PayrollBalance->getName())
        ];

        $response->_dto = $result;

        return $response;
    }

    //</editor-fold>
}
