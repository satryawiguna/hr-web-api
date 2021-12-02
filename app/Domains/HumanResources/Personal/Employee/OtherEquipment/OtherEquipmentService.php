<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment;

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
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentServiceInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

/**
 * OtherEquipmentService Class
 * It has all useful methods for business logic.
 */
class OtherEquipmentService extends ServiceAbstract implements OtherEquipmentServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var OtherEquipmentRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our OtherEquipmentInterface
     * OtherEquipmentService constructor.
     *
     * @param OtherEquipmentRepositoryInterface $repository
     */
    public function __construct(OtherEquipmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(OtherEquipmentInterface $OtherEquipment)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($OtherEquipment->toArray(), [
            'employee_id' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($OtherEquipment);

        try {
            $result = $this->repository->create($OtherEquipment);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other equipment was created', 200);
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
     * @param Collection $OtherEquipments
     * @return BasicResponse|mixed
     */
    public function insert(Collection $OtherEquipments)
    {
        $response = new BasicResponse();

        $OtherEquipments->map(function ($row) use ($response) {
            $validator = Validator::make($row->toArray(), [
                'employee_id' => 'required',
                'competence_id' => 'required',
                'reference_number' => 'required',
                'issue_date' => 'required',
                'validity' => 'required'
            ]);

            if ($validator->fails()) {
                $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

                return $response;
            }

            $this->setAuditableInformationFromRequest($row);
        });

        try {
            $this->repository->insert($OtherEquipments);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work competence was created', 200);
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
    public function update(OtherEquipmentInterface $OtherEquipment, array $params = [])
    {
        $response = new BasicResponse();

        $validator = Validator::make($OtherEquipment->toArray(), [
            'employee_id' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($OtherEquipment);

        try {
            if (!$params) {
                $this->repository->update($OtherEquipment);
            } else {
                $this->repository->updateOrCreate($OtherEquipment, $params);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other equipment was updated', 200);
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
    public function delete(OtherEquipmentInterface $OtherEquipment)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($OtherEquipment);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Other equipment was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'other equipment was deleted', 200);
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
     * @return GenericCollectionResponse
     */
    public function otherEquipmentList(int $companyId = null, int $employeeId = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->otherEquipmentList($companyId, $employeeId);

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
     * @return GenericListSearchResponse
     */
    public function otherEquipmentListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $employeeId = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->otherEquipmentListSearch($parameter, $companyId, $employeeId);
            $totalCount = $this->repository->otherEquipmentListSearch($parameter, $companyId, $employeeId, true);

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
     * @return GenericPageSearchResponse
     */
    public function otherEquipmentPageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $employeeId = null): GenericPageSearchResponse
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

            $results = $this->repository->otherEquipmentPageSearch($parameter, $companyId, $employeeId);
            $totalCount = $this->repository->otherEquipmentPageSearch($parameter, $companyId, $employeeId,true);
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
