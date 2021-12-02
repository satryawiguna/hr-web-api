<?php

namespace App\Domains\Commons\EmployeeNumberScale;

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
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleRepositoryInterface;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleServiceInterface;
use App\Domains\Commons\EmployeeNumberScale\Contracts\EmployeeNumberScaleInterface;
use Cviebrock\EloquentSluggable\Services\SlugService;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * EmployeeNumberScaleService Class
 * It has all useful methods for business logic.
 */
class EmployeeNumberScaleService extends ServiceAbstract implements EmployeeNumberScaleServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var EmployeeNumberScaleRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our EmployeeNumberScaleInterface
     * EmployeeNumberScaleService constructor.
     *
     * @param EmployeeNumberScaleRepositoryInterface $repository
     */
    public function __construct(EmployeeNumberScaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(EmployeeNumberScaleInterface $EmployeeNumberScale): ObjectResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($EmployeeNumberScale->toArray(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($EmployeeNumberScale);

        try {
            $result = $this->repository->create($EmployeeNumberScale);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee number scale was created', 200);
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
    public function update(EmployeeNumberScaleInterface $EmployeeNumberScale): BasicResponse
    {
        $response = new ObjectResponse();

        $validator = Validator::make($EmployeeNumberScale->toArray(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($EmployeeNumberScale);

        try {
            $result = $this->repository->update($EmployeeNumberScale);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee number scale was updated', 200);
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
    public function delete(EmployeeNumberScaleInterface $EmployeeNumberScale): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($EmployeeNumberScale);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee number scale was deleted', 200);
        } catch (\Askedio\SoftCascade\Exceptions\SoftCascadeLogicException $e) {
            $response->addErrorMessageResponse($response->getMessageCollection(), "Employee number scale is used", 500);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee number scales was deleted', 200);
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
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function employeeNumberScaleList(int $isActive = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->employeeNumberScaleList($isActive);

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
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function employeeNumberScaleListSearch(ListSearchRequest $listSearchRequest, int $isActive = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->employeeNumberScaleListSearch($parameter, $isActive);
            $totalCount = $this->repository->employeeNumberScaleListSearch($parameter, $isActive, true);

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
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function employeeNumberScalePageSearch(PageSearchRequest $pageSearchRequest, int $isActive = null): GenericPageSearchResponse
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

            $results = $this->repository->employeeNumberScalePageSearch($parameter, $isActive);
            $totalCount = $this->repository->employeeNumberScalePageSearch($parameter, $isActive, true);
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
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     * @return BasicResponse
     */
    public function employeeNumberScaleSetActive(EmployeeNumberScaleInterface $EmployeeNumberScale): BasicResponse
    {
        $response = new BasicResponse();

        $validator = Validator::make($EmployeeNumberScale->toArray(), [
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($EmployeeNumberScale);

        try {
            $result = $this->repository->update($EmployeeNumberScale);

            if ($result->is_active == 1) {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee number scale was activated', 200);
            } else {
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee number scale was deactivated', 200);
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
     * @param EmployeeNumberScaleInterface $EmployeeNumberScale
     * @return ObjectResponse
     */
    public function employeeNumberScaleSlug(EmployeeNumberScaleInterface $EmployeeNumberScale): ObjectResponse
    {
        $response = new ObjectResponse();

        try {

            $result = (object)[
                'slug' => SlugService::createSlug($EmployeeNumberScale, 'slug', $EmployeeNumberScale->getName())
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
