<?php

namespace App\Domains\HumanResources\MasterData\BaseSalaryCustomType;

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
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeServiceInterface;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * BaseSalaryCustomTypeService Class
 * It has all useful methods for business logic.
 */
class BaseSalaryCustomTypeService extends ServiceAbstract implements BaseSalaryCustomTypeServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var BaseSalaryCustomTypeRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our BaseSalaryCustomTypeInterface
     * BaseSalaryCustomTypeService constructor.
     *
     * @param BaseSalaryCustomTypeRepositoryInterface $repository
     */
    public function __construct(BaseSalaryCustomTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(BaseSalaryCustomTypeInterface $BaseSalaryCustomType)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($BaseSalaryCustomType->toArray(), [
            'company_id' => 'required',
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($BaseSalaryCustomType);

        try {
            $result = $this->repository->create($BaseSalaryCustomType);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Base salary custom type was created', 200);
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
    public function update(BaseSalaryCustomTypeInterface $BaseSalaryCustomType)
    {
        $response = new BasicResponse();

        $validator = Validator::make($BaseSalaryCustomType->toArray(), [
            'company_id' => 'required',
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($BaseSalaryCustomType);

        try {
            $this->repository->update($BaseSalaryCustomType);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Base salary custom type was updated', 200);
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
    public function delete(BaseSalaryCustomTypeInterface $BaseSalaryCustomType)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($BaseSalaryCustomType);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Base salary custom type was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Base salary custom types was deleted', 200);
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
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function baseSalaryCustomTypeList(int $companyId = null, int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->baseSalaryCustomTypeList($companyId, $isActive);

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
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function baseSalaryCustomTypeListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->baseSalaryCustomTypeListSearch($parameter, $companyId, $isActive);
            $totalCount = $this->repository->baseSalaryCustomTypeListSearch($parameter, $companyId, $isActive, true);

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
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function baseSalaryCustomTypePageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $isActive = null): GenericPageSearchResponse
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

            $results = $this->repository->baseSalaryCustomTypePageSearch($parameter, $companyId, $isActive);
            $totalCount = $this->repository->baseSalaryCustomTypePageSearch($parameter, $companyId, $isActive, true);
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
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     * @return BasicResponse
     */
    public function baseSalaryCustomTypeSetActive(BaseSalaryCustomTypeInterface $BaseSalaryCustomType): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($BaseSalaryCustomType->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($BaseSalaryCustomType);

        try {
            $result = $this->repository->update($BaseSalaryCustomType);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Base salary custom type was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Base salary custom type was deactivated', 200);
            }

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
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     * @return ObjectResponse
     */
    public function baseSalaryCustomTypeSlug(BaseSalaryCustomTypeInterface $BaseSalaryCustomType): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $result = (object)[
                'slug' => SlugService::createSlug($BaseSalaryCustomType, 'slug', $BaseSalaryCustomType->getName(), ['company_id' => $BaseSalaryCustomType->getCompanyId()])
            ];

            $response->setResult($result);

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
