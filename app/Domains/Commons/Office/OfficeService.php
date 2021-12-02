<?php

namespace App\Domains\Commons\Office;

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
use App\Domains\Commons\Office\Contracts\OfficeRepositoryInterface;
use App\Domains\Commons\Office\Contracts\OfficeServiceInterface;
use App\Domains\Commons\Office\Contracts\OfficeInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * OfficeService Class
 * It has all useful methods for business logic.
 */
class OfficeService extends ServiceAbstract implements OfficeServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var OfficeRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our OfficeInterface
     * OfficeService constructor.
     *
     * @param OfficeRepositoryInterface $repository
     */
    public function __construct(OfficeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(OfficeInterface $Office): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Office->toArray(), [
            'company_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'type' => 'required',
            'country' => 'required',
            'state_or_province' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Office);

        try {
            $result = $this->repository->create($Office);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Office was created', 200);
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
    public function update(OfficeInterface $Office): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Office->toArray(), [
            'company_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'type' => 'required',
            'country' => 'required',
            'state_or_province' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Office);

        try {
            $result = $this->repository->update($Office);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Office was updated', 200);
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
    public function delete(OfficeInterface $Office): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($Office);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Office was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Offices was deleted', 200);
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
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function officeList(int $companyId = null, string $type = null, string $country = null, int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->officeList($companyId, $type, $country, $isActive);

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
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function officeListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, string $type = null, string $country = null, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->officeListSearch($parameter, $companyId, $type, $country, $isActive);
            $totalCount = $this->repository->officeListSearch($parameter, $companyId, $type, $country, $isActive, true);

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
     * @param string|null $type
     * @param string|null $country
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function officePageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, string $type = null, string $country = null, int $isActive = null): GenericPageSearchResponse
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

            $results = $this->repository->officePageSearch($parameter, $companyId, $type, $country, $isActive);
            $totalCount = $this->repository->officePageSearch($parameter, $companyId, $type, $country, $isActive, true);
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
     * @param OfficeInterface $Office
     * @return BasicResponse
     */
    public function officeSetActive(OfficeInterface $Office): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($Office->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Office);

        try {
            $result = $this->repository->update($Office);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Office was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Office was deactivated', 200);
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
     * @param OfficeInterface $Office
     * @return ObjectResponse
     */
    public function officeSlug(OfficeInterface $Office): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $result = (object)[
                'slug' => SlugService::createSlug($Office, 'slug', $Office->getName(), ['company_id' => $Office->getCompanyId()])
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
