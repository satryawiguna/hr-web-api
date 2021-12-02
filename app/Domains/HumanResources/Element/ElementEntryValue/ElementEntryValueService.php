<?php

namespace App\Domains\HumanResources\Element\ElementEntryValue;

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
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueRepositoryInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueServiceInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueInterface;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * ElementEntryValueService Class
 * It has all useful methods for business logic.
 */
class ElementEntryValueService extends ServiceAbstract implements ElementEntryValueServiceInterface
{
    //<editor-fold desc="#field">
    
    /**
     * @var ElementEntryValueRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">
    
    /**
     * Loads our $repo with the actual Repo associated with our ElementEntryValueInterface
     * ElementEntryValueService constructor.
     *
     * @param ElementEntryValueRepositoryInterface $repository
     */
    public function __construct(ElementEntryValueRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * {@inheritdoc}
     */
    public function create(ElementEntryValueInterface $ElementEntryValue)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($ElementEntryValue->toArray(), [
            'element_entry_id' => 'required',
            'element_value_id' => 'required',
            'effective_start_date' => 'required',
            'effective_end_date' => 'required',
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($ElementEntryValue);

        try {
            $result = $this->repository->create($ElementEntryValue);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Element entry value was created', 200);
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
    public function update(ElementEntryValueInterface $ElementEntryValue)
    {
        $response = new BasicResponse();

        $validator = Validator::make($ElementEntryValue->toArray(), [
            'element_entry_id' => 'required',
            'element_value_id' => 'required',
            'effective_start_date' => 'required',
            'effective_end_date' => 'required',
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($ElementEntryValue);

        try {
            $this->repository->update($ElementEntryValue);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Element entry value was updated', 200);
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
    public function delete(ElementEntryValueInterface $ElementEntryValue)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($ElementEntryValue);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Element entry value was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Element entry values was deleted', 200);
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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericCollectionResponse
     */
    public function elementEntryValueList(int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->elementEntryValueList($elementEntryId, $elementValueId, $date, $rangeValue);

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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericListSearchResponse
     */
    public function elementEntryValueListSearch(ListSearchRequest $listSearchRequest, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->elementEntryValueListSearch($parameter, $elementEntryId, $elementValueId, $date, $rangeValue);
            $totalCount = $this->repository->elementEntryValueListSearch($parameter, $elementEntryId, $elementValueId, $date, $rangeValue, true);

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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericPageSearchResponse
     */
    public function elementEntryValuePageSearch(PageSearchRequest $pageSearchRequest, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null): GenericPageSearchResponse
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

            $results = $this->repository->elementEntryValuePageSearch($parameter, $elementEntryId, $elementValueId, $date, $rangeValue);
            $totalCount = $this->repository->elementEntryValuePageSearch($parameter, $elementEntryId, $elementValueId, $date, $rangeValue, true);
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
}
