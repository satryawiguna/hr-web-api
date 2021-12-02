<?php

namespace App\Domains\HumanResources\MasterData\AdditionalQuestion;

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
use App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts\AdditionalQuestionRepositoryInterface;
use App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts\AdditionalQuestionServiceInterface;
use App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts\AdditionalQuestionInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * AdditionalQuestionService Class
 * It has all useful methods for business logic.
 */
class AdditionalQuestionService extends ServiceAbstract implements AdditionalQuestionServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var AdditionalQuestionRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our AdditionalQuestionInterface
     * AdditionalQuestionService constructor.
     *
     * @param AdditionalQuestionRepositoryInterface $repository
     */
    public function __construct(AdditionalQuestionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(AdditionalQuestionInterface $AdditionalQuestion): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($AdditionalQuestion->toArray(), [
            'company_id'  => 'required',
            'question'    => 'required',
            'status'      => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $result = $this->repository->create($AdditionalQuestion);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Additional question was created', 200);
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
    public function update(AdditionalQuestionInterface $AdditionalQuestion): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($AdditionalQuestion->toArray(), [
            'company_id'  => 'required',
            'question'    => 'required',
            'status'      => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $result = $this->repository->update($AdditionalQuestion);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Additional question was updated', 200);
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
    public function delete(AdditionalQuestionInterface $AdditionalQuestion)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($AdditionalQuestion);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Additional question was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Additional questions was deleted', 200);
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
     * @param int|null $isRequired
     * @param string|null $status
     * @return GenericCollectionResponse
     */
    public function additionalQuestionList(int $companyId = null, int $isRequired = null, string $status = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->additionalQuestionList($companyId, $isRequired, $status);

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
     * @param int|null $isRequired
     * @param string|null $status
     * @return GenericListSearchResponse
     */
    public function additionalQuestionListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $isRequired = null, string $status = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->additionalQuestionListSearch($parameter, $companyId, $isRequired, $status);
            $totalCount = $this->repository->additionalQuestionListSearch($parameter, $companyId, $isRequired, $status, true);

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
     * @param int|null $isRequired
     * @param string|null $status
     * @return GenericPageSearchResponse
     */
    public function additionalQuestionPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $isRequired = null, string $status = null): GenericPageSearchResponse
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

            $results = $this->repository->additionalQuestionPageSearch($parameter, $companyId, $isRequired, $status);
            $totalCount = $this->repository->additionalQuestionPageSearch($parameter, $companyId, $isRequired, $status, true);
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
