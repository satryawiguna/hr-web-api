<?php

namespace App\Domains\HumanResources\MasterData\WorkUnit;

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
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitRepositoryInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitServiceInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * WorkUnitService Class
 * It has all useful methods for business logic.
 */
class WorkUnitService extends ServiceAbstract implements WorkUnitServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var WorkUnitRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our WorkUnitInterface
     * WorkUnitService constructor.
     *
     * @param WorkUnitRepositoryInterface $repository
     */
    public function __construct(WorkUnitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(WorkUnitInterface $WorkUnit): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($WorkUnit->toArray(), [
            'company_id' => 'required',
            'code' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'country' => 'required',
            'state_or_province' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postcode' => 'numeric',
            'phone' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkUnit);

        try {
            $result = $this->repository->create($WorkUnit);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit was created', 200);
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
    public function update(WorkUnitInterface $WorkUnit): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($WorkUnit->toArray(), [
            'company_id' => 'required',
            'code' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'country' => 'required',
            'state_or_province' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postcode' => 'numeric',
            'phone' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkUnit);

        try {
            $this->repository->update($WorkUnit);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit was updated', 200);
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
    public function delete(WorkUnitInterface $WorkUnit): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($WorkUnit);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work units was deleted', 200);
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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function workUnitList(int $parentId = null, int $companyId = null, string $country = null, int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->workUnitList($parentId, $companyId, $country, $isActive);

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
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function workUnitListHierarchical(int $companyId = null, string $country = null, int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->workUnitListHierarchical($companyId, $country, $isActive);

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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function workUnitListSearch(ListSearchRequest $listSearchRequest, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->workUnitListSearch($parameter, $parentId, $companyId, $country, $isActive);
            $totalCount = $this->repository->workUnitListSearch($parameter, $parentId, $companyId, $country, $isActive, true);

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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function workUnitPageSearch(PageSearchRequest $pageSearchRequest, int $parentId = null, int $companyId = null, string $country = null, int $isActive = null): GenericPageSearchResponse
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

            $results = $this->repository->workUnitPageSearch($parameter, $parentId, $companyId, $country, $isActive);
            $totalCount = $this->repository->workUnitPageSearch($parameter, $parentId, $companyId, $country, $isActive, true);
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
     * @param WorkUnitInterface $WorkUnit
     * @return BasicResponse
     */
    public function workUnitSetActive(WorkUnitInterface $WorkUnit): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($WorkUnit->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkUnit);

        try {
            $result = $this->repository->update($WorkUnit);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work unit was deactivated', 200);
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
     * @param WorkUnitInterface $WorkUnit
     * @return ObjectResponse
     */
    public function workUnitSlug(WorkUnitInterface $WorkUnit): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $result = (object)[
                'slug' => SlugService::createSlug($WorkUnit, 'slug', $WorkUnit->getTitle(), ['company_id' => $WorkUnit->getCompanyId()])
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
