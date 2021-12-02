<?php

namespace App\Domains\HumanResources\Payroll\PayrollProcessType;

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
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeRepositoryInterface;
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeServiceInterface;
use App\Domains\HumanResources\Payroll\PayrollProcessType\Contracts\PayrollProcessTypeInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * PayrollProcessTypeService Class
 * It has all useful methods for business logic.
 */
class PayrollProcessTypeService extends ServiceAbstract implements PayrollProcessTypeServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var PayrollProcessTypeRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our PayrollProcessTypeInterface
     * PayrollProcessTypeService constructor.
     *
     * @param PayrollProcessTypeRepositoryInterface $repository
     */
    public function __construct(PayrollProcessTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(PayrollProcessTypeInterface $PayrollProcessType)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($PayrollProcessType->toArray(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PayrollProcessType);

        try {
            $result = $this->repository->create($PayrollProcessType);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll process type was created', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function update(PayrollProcessTypeInterface $PayrollProcessType)
    {
        $response = new BasicResponse();

        $validator = Validator::make($PayrollProcessType->toArray(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($PayrollProcessType);

        try {
            $this->repository->update($PayrollProcessType);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll process type was updated', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PayrollProcessTypeInterface $PayrollProcessType)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($PayrollProcessType);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Payroll process type was deleted', 200);
        } catch (Exception $ex) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $ex->getMessage(), 400);
        }

        return $response;
    }

    /**
     * @return GenericCollectionResponse
     */
    public function payrollProcessTypeList(): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        $results = $this->repository->payrollProcessTypeList();

        foreach ($results as $result) {
            $response->_dtoCollection->push($result);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @return GenericListSearchResponse
     */
    public function payrollProcessTypeListSearch(ListSearchRequest $listSearchRequest): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        $parameter->query = $listSearchRequest->query;

        $results = $this->repository->payrollProcessTypeListSearch($parameter);
        $totalCount = $this->repository->payrollProcessTypeListSearch($parameter, true);

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
    public function payrollProcessTypePageSearch(PageSearchRequest $pageSearchRequest): GenericPageSearchResponse
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

        $results = $this->repository->payrollProcessTypePageSearch($parameter);
        $totalCount = $this->repository->payrollProcessTypePageSearch($parameter, true);

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
     * @param PayrollProcessTypeInterface $PayrollProcessType
     * @return ObjectResponse
     */
    public function payrollProcessTypeSlug(PayrollProcessTypeInterface $PayrollProcessType): ObjectResponse
    {
        $response = new ObjectResponse();

        $result = $result = (object)[
            'slug' => SlugService::createSlug($PayrollProcessType, 'slug', $PayrollProcessType->getName())
        ];

        $response->_dto = $result;

        return $response;
    }

    //</editor-fold>
}
