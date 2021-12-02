<?php

namespace App\Domains\HumanResources\MasterData\OtherType;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionInterface;
use App\Domains\ServiceAbstract;
use App\Domains\HumanResources\MasterData\OtherType\Contracts\OtherTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\OtherType\Contracts\OtherTypeServiceInterface;
use App\Domains\HumanResources\MasterData\OtherType\Contracts\OtherTypeInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * OtherTypeService Class
 * It has all useful methods for business logic.
 */
class OtherTypeService extends ServiceAbstract implements OtherTypeServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var OtherTypeRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our OtherTypeInterface
     * OtherTypeService constructor.
     *
     * @param OtherTypeRepositoryInterface $repository
     */
    public function __construct(OtherTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(OtherTypeInterface $OtherType)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($OtherType->toArray(), [
            'company_id' => 'required',
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($OtherType);

        try {
            $result = $this->repository->create($OtherType);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other type was created', 200);
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
    public function update(OtherTypeInterface $OtherType)
    {
        $response = new BasicResponse();

        $validator = Validator::make($OtherType->toArray(), [
            'company_id' => 'required',
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($OtherType);

        try {
            $this->repository->update($OtherType);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other type was updated', 200);
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
    public function delete(OtherTypeInterface $OtherType)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($OtherType);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other type was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other types was deleted', 200);
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
    public function otherTypeList(int $companyId = null, int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->otherTypeList($companyId, $isActive);

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
    public function otherTypeListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->otherTypeListSearch($parameter, $companyId, $isActive);
            $totalCount = $this->repository->otherTypeListSearch($parameter, $companyId, $isActive, true);

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
    public function otherTypePageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $isActive = null): GenericPageSearchResponse
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

            $results = $this->repository->otherTypePageSearch($parameter, $companyId, $isActive);
            $totalCount = $this->repository->otherTypePageSearch($parameter, $companyId, $isActive, true);
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
     * @param OtherTypeInterface $OtherType
     * @return BasicResponse
     */
    public function otherTypeSetActive(OtherTypeInterface $OtherType): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($OtherType->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($OtherType);

        try {
            $result = $this->repository->update($OtherType);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other type was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other type was deactivated', 200);
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
     * @param OtherTypeInterface $OtherType
     * @return ObjectResponse
     */
    public function otherTypeSlug(OtherTypeInterface $OtherType): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $result = (object)[
                'slug' => SlugService::createSlug($OtherType, 'slug', $OtherType->getName(), ['company_id' => $OtherType->getCompanyId()])
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
