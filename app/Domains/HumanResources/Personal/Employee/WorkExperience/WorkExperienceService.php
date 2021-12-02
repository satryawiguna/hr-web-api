<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkExperience;

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
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceServiceInterface;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\Contracts\WorkExperienceInterface;
use DateTime;
use ErrorException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

/**
 * WorkExperienceService Class
 * It has all useful methods for business logic.
 */
class WorkExperienceService extends ServiceAbstract implements WorkExperienceServiceInterface
{
    //<editor-fold desc="#field">

    /**
     * @var WorkExperienceRepositoryInterface
     */
    protected $repository;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * Loads our $repo with the actual Repo associated with our WorkExperienceInterface
     * WorkExperienceService constructor.
     *
     * @param WorkExperienceRepositoryInterface $repository
     */
    public function __construct(WorkExperienceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * {@inheritdoc}
     */
    public function create(WorkExperienceInterface $WorkExperience)
    {
        $response = new ObjectResponse();

        $validator = Validator::make($WorkExperience->toArray(), [
            'employee_id' => 'required',
            'company' => 'required',
            'business_type' => 'required',
            'position' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkExperience);

        try {
            $result = $this->repository->create($WorkExperience);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work experience history was created', 200);
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
     * @param Collection $WorkExperiences
     * @return BasicResponse|mixed
     */
    public function insert(Collection $WorkExperiences)
    {
        $response = new BasicResponse();

        $WorkExperiences->map(function ($row) use ($response) {
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
            $this->repository->insert($WorkExperiences);

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
    public function update(WorkExperienceInterface $WorkExperience, array $params = [])
    {
        $response = new BasicResponse();

        $validator = Validator::make($WorkExperience->toArray(), [
            'employee_id' => 'required',
            'company' => 'required',
            'business_type' => 'required',
            'position' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $this->setAuditableInformationFromRequest($WorkExperience);

        try {
            if (!$params) {
                $this->repository->update($WorkExperience);
            } else {
                $this->repository->updateOrCreate($WorkExperience, $params);
            }

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work experience history was updated', 200);
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
    public function delete(WorkExperienceInterface $WorkExperience)
    {
        $response = new BasicResponse();

        try {
            $this->repository->delete($WorkExperience);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work experience history was deleted', 200);
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

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Work experience was deleted', 200);
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
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function workExperienceList(int $companyId = null, int $employeeId = null, DateTime $date = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository->workExperienceList($companyId, $employeeId, $date);

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
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function workExperienceListSearch(ListSearchRequest $listSearchRequest, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            $results = $this->repository->workExperienceListSearch($parameter, $companyId, $employeeId, $date);
            $totalCount = $this->repository->workExperienceListSearch($parameter, $companyId, $employeeId, true);

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
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function workExperiencePageSearch(PageSearchRequest $pageSearchRequest, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericPageSearchResponse
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

            $results = $this->repository->workExperiencePageSearch($parameter, $companyId, $employeeId, $date);
            $totalCount = $this->repository->workExperiencePageSearch($parameter, $companyId, $employeeId, $date, true);
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
