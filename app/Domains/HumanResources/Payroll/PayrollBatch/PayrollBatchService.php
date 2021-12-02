<?php

namespace App\Domains\HumanResources\Payroll\PayrollBatch;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollBatch\Contracts\PayrollBatchInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * PayrollBatchService Class
 * It has all useful methods for business logic.
 */
class PayrollBatchService extends ServiceAbstract implements PayrollBatchServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var PayrollBatchRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our PayrollBatchInterface
     * PayrollBatchService constructor.
     *
     * @param PayrollBatchRepositoryInterface $repository
     */
    public function __construct(PayrollBatchRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(PayrollBatchInterface $PayrollBatch)
    {
        $response = new BasicResponse();

        $validator = Validator::make($PayrollBatch->toArray(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PayrollBatch);

        try {
            $this->repository->create($PayrollBatch);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll batch was created', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollBatchInterface $PayrollBatch)
    {
        $response = new BasicResponse();

        $validator = Validator::make($PayrollBatch->toArray(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PayrollBatch);

        try {
            $this->repository->update($PayrollBatch);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll batch was updated', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollBatchInterface $PayrollBatch)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($PayrollBatch);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll batch was deleted', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * @return GenericCollectionResponse
     */
    public function payrollBatchList(): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        $results = $this->repository->payrollBatchList();

        foreach ($results as $result) {
            $response->_dtoCollection->push($result);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @return GenericListSearchResponse
     */
    public function payrollBatchListSearch(ListSearchRequest $listSearchRequest): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        $parameter->query = $listSearchRequest->query;

        $results = $this->repository->payrollBatchListSearch($parameter);
        $totalCount = $this->repository->payrollBatchListSearch($parameter, true);

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
    public function payrollBatchPageSearch(PageSearchRequest $pageSearchRequest): GenericPageSearchResponse
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

        $results = $this->repository->payrollBatchPageSearch($parameter);
        $totalCount = $this->repository->payrollBatchPageSearch($parameter, true);

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
     * @param PayrollBatchInterface $PayrollBatch
     * @return ObjectResponse
     */
    public function payrollBatchSlug(PayrollBatchInterface $PayrollBatch): ObjectResponse
    {
        $response = new ObjectResponse();

        $result = $result = (object)[
            'slug' => SlugService::createSlug($PayrollBatch, 'slug', $PayrollBatch->getName())
        ];

        $response->_dto = $result;

        return $response;
    }

    //</editor-fold>
}
