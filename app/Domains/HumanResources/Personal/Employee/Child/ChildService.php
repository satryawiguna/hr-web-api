<?php

namespace App\Domains\HumanResources\Personal\Employee\Child;

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
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildServiceInterface;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

/**
 * ChildService Class
 * It has all useful methods for business logic.
 */
class ChildService extends ServiceAbstract implements ChildServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var ChildRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our ChildInterface
     * ChildService constructor.
     *
     * @param ChildRepositoryInterface $repository
     */
    public function __construct(ChildRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(ChildInterface $Child)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($Child->toArray(), [
            'employee_id' => 'required',
            'full_name' => 'required',
            'nick_name' => 'required',
            'gender_id' => 'required',
            'order' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Child);

        try {
            $result = $this->repository->create($Child);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Child was created', 200);
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
     * @param Collection $Childs
     * @return BasicResponse|mixed
     */
    public function insert(Collection $Childs)
    {
        $response = new BasicResponse();

        $Childs->map(function ($row) use ($response) {
            $validator = Validator::make($row->toArray(), [
                'employee_id' => 'required',
                'full_name' => 'required',
                'nick_name' => 'required',
                'gender_id' => 'required',
                'order' => 'required',
                'birth_place' => 'required',
                'birth_date' => 'required'
            ]);

            if ($validator->fails()) {
                $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                return $response;
            }

            $this->setAuditableInformationFromRequest($row);
        });

        try {
            $this->repository->insert($Childs);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Childs was created', 200);
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
    public function update(ChildInterface $Child, array $params = [])
    {
        $response = new BasicResponse();

        $validator = Validator::make($Child->toArray(), [
            'employee_id' => 'required',
            'full_name' => 'required',
            'nick_name' => 'required',
            'gender_id' => 'required',
            'order' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($Child);

        try {
            if (!$params) {
                $this->repository->update($Child);
            } else {
                $this->repository->updateOrCreate($Child, $params);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Child was updated', 200);
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
    public function delete(ChildInterface $Child)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($Child);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Child was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Childs was deleted', 200);
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
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @return GenericCollectionResponse
     */
    public function childList(int $companyId = null, int  $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->childList($companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass);

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
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @return GenericListSearchResponse
     */
    public function childListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->childListSearch($parameter, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass);
            $totalCount = $this->repository->childListSearch($parameter, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, true);

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
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @return GenericPageSearchResponse
     */
    public function childPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null): GenericPageSearchResponse
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

            $results = $this->repository->childPageSearch($parameter, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass);
            $totalCount = $this->repository->childPageSearch($parameter, $companyId, $employeeId, $genderId, $rangeBirthDate, $rangeBPJSKesehatanDate, $bpjsKesehatanClass, true);
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
